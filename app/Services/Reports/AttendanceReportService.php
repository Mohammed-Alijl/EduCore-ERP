<?php

namespace App\Services\Reports;

use App\Models\Attendance;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AttendanceReportService
{
    // --------------------------------------------------------
    // Query Builders
    // --------------------------------------------------------

    /**
     * Build the base student attendance summary query.
     *
     * @param  string|null  $locale  Override locale for export
     */
    private function buildAttendanceSummaryQuery(
        int $academicYearId,
        ?int $gradeId = null,
        ?int $sectionId = null,
        ?string $locale = null
    ): Builder {
        $locale = $locale ?? app()->getLocale();

        $present = Attendance::STATUS_PRESENT;
        $absent = Attendance::STATUS_ABSENT;
        $late = Attendance::STATUS_LATE;

        $query = DB::table('attendances')
            ->join('students', 'attendances.student_id', '=', 'students.id')
            ->join('sections', 'attendances.section_id', '=', 'sections.id')
            ->where('attendances.academic_year_id', $academicYearId)
            ->select(
                'students.id as student_id',
                'students.student_code',
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(students.name, '$.\"$locale\"')) as student_name"),
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(sections.name, '$.\"$locale\"')) as section_name"),

                DB::raw('COUNT(*) as total_days'),
                DB::raw("SUM(CASE WHEN attendances.attendance_status = {$present} THEN 1 ELSE 0 END) as present_days"),
                DB::raw("SUM(CASE WHEN attendances.attendance_status = {$absent} THEN 1 ELSE 0 END) as absent_days"),
                DB::raw("SUM(CASE WHEN attendances.attendance_status = {$late} THEN 1 ELSE 0 END) as late_days"),

                DB::raw("ROUND(
                    (SUM(CASE WHEN attendances.attendance_status = {$present} THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2
                ) as attendance_percentage")
            )
            ->groupBy(
                'students.id',
                'students.student_code',
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(students.name, '$.\"$locale\"'))"),
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(sections.name, '$.\"$locale\"'))")
            );

        if ($gradeId) {
            $query->where('attendances.grade_id', $gradeId);
        }

        if ($sectionId) {
            $query->where('attendances.section_id', $sectionId);
        }

        return $query;
    }

    /**
     * Build the student attendance summary query for a given academic year.
     */
    public function getStudentAttendanceSummaryQuery(int $academicYearId)
    {
        return $this->buildAttendanceSummaryQuery($academicYearId)
            ->orderBy('attendance_percentage', 'asc')
            ->get();
    }

    /**
     * Get query builder for export (returns Builder, not Collection).
     *
     * @param  string|null  $locale  Force specific locale for export file
     */
    public function getExportQuery(
        int $academicYearId,
        ?int $gradeId = null,
        ?int $sectionId = null,
        ?string $locale = null
    ): Builder {
        return $this->buildAttendanceSummaryQuery($academicYearId, $gradeId, $sectionId, $locale)
            ->orderBy('students.id');
    }

    // --------------------------------------------------------
    // KPIs
    // --------------------------------------------------------

    /**
     * Calculate attendance KPIs for the current academic year.
     *
     * @return array{absent_today: int, average_attendance: float, at_risk_count: int}
     */
    public function getAttendanceKPIs(int $academicYearId): array
    {
        $absent = Attendance::STATUS_ABSENT;

        // Total absent today across the school
        $absentToday = DB::table('attendances')
            ->where('academic_year_id', $academicYearId)
            ->where('attendance_date', now()->toDateString())
            ->where('attendance_status', $absent)
            ->count();

        // Build the summary to compute average and at-risk
        $summary = $this->getStudentAttendanceSummaryQuery($academicYearId);

        $averageAttendance = $summary->count() > 0
            ? round($summary->avg('attendance_percentage'), 2)
            : 0;

        $atRiskCount = $summary->where('attendance_percentage', '<', 85)->count();

        return [
            'absent_today' => $absentToday,
            'average_attendance' => $averageAttendance,
            'at_risk_count' => $atRiskCount,
        ];
    }

    // --------------------------------------------------------
    // Charts
    // --------------------------------------------------------

    /**
     * Get absence count grouped by day of week for trend analysis.
     *
     * Uses DAYOFWEEK() which returns 1=Sunday … 7=Saturday.
     */
    public function getChartData(int $academicYearId): array
    {
        $absent = Attendance::STATUS_ABSENT;
        $locale = app()->getLocale();

        $dayNames = [
            1 => trans('admin.reports.attendance.days.sunday'),
            2 => trans('admin.reports.attendance.days.monday'),
            3 => trans('admin.reports.attendance.days.tuesday'),
            4 => trans('admin.reports.attendance.days.wednesday'),
            5 => trans('admin.reports.attendance.days.thursday'),
            6 => trans('admin.reports.attendance.days.friday'),
            7 => trans('admin.reports.attendance.days.saturday'),
        ];

        // ─── 1. Absences by Day of Week ─────────────────────────────
        $dayData = DB::table('attendances')
            ->where('academic_year_id', $academicYearId)
            ->where('attendance_status', $absent)
            ->select(
                DB::raw('DAYOFWEEK(attendance_date) as day_number'),
                DB::raw('COUNT(*) as absences_count')
            )
            ->groupBy('day_number')
            ->orderBy('day_number')
            ->get();

        // Fill all 7 days (even with 0 absences)
        $categoriesDay = [];
        $valuesDay = [];

        foreach ($dayNames as $num => $name) {
            $categoriesDay[] = $name;
            $valuesDay[] = (int) ($dayData->firstWhere('day_number', $num)->absences_count ?? 0);
        }

        // ─── 2. Absences by Grade ───────────────────────────────────
        $gradeData = DB::table('attendances')
            ->join('grades', 'attendances.grade_id', '=', 'grades.id')
            ->where('attendances.academic_year_id', $academicYearId)
            ->where('attendances.attendance_status', $absent)
            ->select(
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(grades.name, '$.\"$locale\"')) as grade_name"),
                DB::raw('COUNT(*) as absences_count')
            )
            ->groupBy('grades.id', DB::raw("JSON_UNQUOTE(JSON_EXTRACT(grades.name, '$.\"$locale\"'))"))
            ->orderBy('absences_count', 'desc')
            ->get();

        $categoriesGrade = $gradeData->pluck('grade_name')->toArray();
        $valuesGrade = $gradeData->pluck('absences_count')->map(fn ($val) => (int) $val)->toArray();

        if (empty($categoriesGrade)) {
            $categoriesGrade = [trans('admin.reports.attendance.charts.no_data')];
            $valuesGrade = [0];
        }

        return [
            'absencesByDay' => [
                'categories' => $categoriesDay,
                'values' => $valuesDay,
            ],
            'absencesByGrade' => [
                'categories' => $categoriesGrade,
                'values' => $valuesGrade,
            ],
        ];
    }

    // --------------------------------------------------------
    // DataTable
    // --------------------------------------------------------

    /**
     * Format the attendance summary collection for Yajra DataTables.
     */
    public function datatable($query)
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('attendance_percentage', function ($row) {
                $pct = (float) $row->attendance_percentage;

                if ($pct >= 95) {
                    return '<span class="badge bg-success" style="font-size:.8125rem;padding:.45em .85em;border-radius:8px;">'
                        .$pct.'%</span>';
                }

                if ($pct >= 85) {
                    return '<span class="badge bg-warning text-dark" style="font-size:.8125rem;padding:.45em .85em;border-radius:8px;">'
                        .$pct.'%</span>';
                }

                return '<span class="badge bg-danger" style="font-size:.8125rem;padding:.45em .85em;border-radius:8px;">'
                    .$pct.'%</span>';
            })
            ->rawColumns(['attendance_percentage'])
            ->make(true);
    }
}
