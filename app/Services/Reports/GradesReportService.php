<?php

namespace App\Services\Reports;

use App\Models\AcademicYear;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class GradesReportService
{
    /**
     * Get the main grades query with optional filters.
     *
     * @param  array<string, mixed>  $filters
     */
    public function getGradesQuery(array $filters = []): \Illuminate\Support\Collection
    {
        $locale = app()->getLocale();

        $query = DB::table('student_exam_results')
            ->join('exams', 'student_exam_results.exam_id', '=', 'exams.id')
            ->join('students', 'student_exam_results.student_id', '=', 'students.id')
            ->join('subjects', 'exams.subject_id', '=', 'subjects.id')
            ->join('grades', 'students.grade_id', '=', 'grades.id')
            ->join('class_rooms', 'students.classroom_id', '=', 'class_rooms.id')
            ->leftJoin('sections', 'students.section_id', '=', 'sections.id')
            ->select(
                'student_exam_results.id as result_id',
                'students.id as student_id',
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(students.name, '$.\"$locale\"')) as student_name"),
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(grades.name, '$.\"$locale\"')) as grade_name"),
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(class_rooms.name, '$.\"$locale\"')) as classroom_name"),
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(sections.name, '$.\"$locale\"')) as section_name"),
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(subjects.name, '$.\"$locale\"')) as subject_name"),
                'exams.title as exam_title',
                'exams.total_marks',
                'student_exam_results.final_score',
                DB::raw('ROUND((student_exam_results.final_score / exams.total_marks) * 100, 1) as percentage')
            );

        if (! empty($filters['academic_year_id'])) {
            $query->where('exams.academic_year_id', $filters['academic_year_id']);
        }

        if (! empty($filters['grade_id'])) {
            $query->where('students.grade_id', $filters['grade_id']);
        }

        if (! empty($filters['classroom_id'])) {
            $query->where('students.classroom_id', $filters['classroom_id']);
        }

        if (! empty($filters['section_id'])) {
            $query->where('students.section_id', $filters['section_id']);
        }

        if (! empty($filters['subject_id'])) {
            $query->where('exams.subject_id', $filters['subject_id']);
        }

        if (! empty($filters['exam_id'])) {
            $query->where('exams.id', $filters['exam_id']);
        }

        return $query->orderByDesc('percentage')->get();
    }

    /**
     * Get KPI metrics for the grades report.
     *
     * @param  array<string, mixed>  $filters
     * @return array<string, mixed>
     */
    public function getKPIs(array $filters = []): array
    {
        $results = $this->getGradesQuery($filters);

        $totalResults = $results->count();
        $totalStudents = $results->unique('student_id')->count();
        $averagePercentage = $totalResults > 0 ? round($results->avg('percentage'), 1) : 0;
        $passCount = $results->filter(fn ($r) => $r->percentage >= 50)->count();
        $passRate = $totalResults > 0 ? round(($passCount / $totalResults) * 100, 1) : 0;
        $totalExams = $results->unique('exam_title')->count();

        return [
            'total_students' => $totalStudents,
            'average_percentage' => $averagePercentage,
            'pass_rate' => $passRate,
            'total_exams' => $totalExams,
        ];
    }

    /**
     * Get chart data for the grades report.
     *
     * @param  array<string, mixed>  $filters
     * @return array<string, array<string, mixed>>
     */
    public function getChartData(array $filters = []): array
    {
        $results = $this->getGradesQuery($filters);

        return [
            'scoreDistribution' => $this->getScoreDistribution($results),
            'subjectPerformance' => $this->getSubjectPerformance($results),
            'gradeComparison' => $this->getGradeComparison($results),
        ];
    }

    /**
     * Build the DataTable response.
     */
    public function datatable(\Illuminate\Support\Collection $query): mixed
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('percentage', function ($row) {
                $color = $row->percentage >= 80 ? 'success' : ($row->percentage >= 50 ? 'warning' : 'danger');

                return '<span class="badge bg-'.$color.'" style="font-size: 0.875rem; padding: 0.375rem 0.75rem;">'.
                    $row->percentage.'%</span>';
            })
            ->editColumn('final_score', function ($row) {
                return '<span style="font-weight: 600;">'.$row->final_score.'</span> / '.
                    '<span class="text-muted">'.$row->total_marks.'</span>';
            })
            ->addColumn('status', function ($row) {
                if ($row->percentage >= 80) {
                    return '<span class="badge bg-success" style="padding: 0.375rem 0.75rem;"><i class="las la-trophy mr-1 ml-1"></i>'.trans('admin.reports.grades.statuses.excellent').'</span>';
                }
                if ($row->percentage >= 50) {
                    return '<span class="badge bg-warning text-dark" style="padding: 0.375rem 0.75rem;"><i class="las la-check-circle mr-1 ml-1"></i>'.trans('admin.reports.grades.statuses.pass').'</span>';
                }

                return '<span class="badge bg-danger" style="padding: 0.375rem 0.75rem;"><i class="las la-times-circle mr-1 ml-1"></i>'.trans('admin.reports.grades.statuses.fail').'</span>';
            })
            ->rawColumns(['percentage', 'final_score', 'status'])
            ->make(true);
    }

    /**
     * Get filter dropdown data.
     *
     * @return array<string, \Illuminate\Support\Collection>
     */
    public function getFilterData(): array
    {
        $locale = app()->getLocale();

        return [
            'academicYears' => AcademicYear::query()->orderByDesc('is_current')->orderByDesc('starts_at')->get(),
            'grades' => Grade::active()->get(),
            'subjects' => Subject::active()->get(),
            'exams' => Exam::query()
                ->select('id', 'title', 'subject_id')
                ->orderBy('title')
                ->get(),
        ];
    }

    /**
     * Get score distribution data for the bar chart.
     *
     * @return array<string, array<int|string>>
     */
    protected function getScoreDistribution(\Illuminate\Support\Collection $results): array
    {
        $ranges = [
            '0-20%' => $results->filter(fn ($r) => $r->percentage >= 0 && $r->percentage < 20)->count(),
            '20-40%' => $results->filter(fn ($r) => $r->percentage >= 20 && $r->percentage < 40)->count(),
            '40-60%' => $results->filter(fn ($r) => $r->percentage >= 40 && $r->percentage < 60)->count(),
            '60-80%' => $results->filter(fn ($r) => $r->percentage >= 60 && $r->percentage < 80)->count(),
            '80-100%' => $results->filter(fn ($r) => $r->percentage >= 80 && $r->percentage <= 100)->count(),
        ];

        return [
            'labels' => array_keys($ranges),
            'values' => array_values($ranges),
        ];
    }

    /**
     * Get average score per subject for the radar/bar chart.
     *
     * @return array<string, array<float|string>>
     */
    protected function getSubjectPerformance(\Illuminate\Support\Collection $results): array
    {
        $grouped = $results->groupBy('subject_name');

        $labels = [];
        $values = [];

        foreach ($grouped as $subject => $subjectResults) {
            $labels[] = $subject;
            $values[] = round($subjectResults->avg('percentage'), 1);
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    /**
     * Get average score per grade for comparison chart.
     *
     * @return array<string, array<float|string>>
     */
    protected function getGradeComparison(\Illuminate\Support\Collection $results): array
    {
        $grouped = $results->groupBy('grade_name');

        $labels = [];
        $averages = [];
        $passRates = [];

        foreach ($grouped as $grade => $gradeResults) {
            $labels[] = $grade;
            $averages[] = round($gradeResults->avg('percentage'), 1);
            $passCount = $gradeResults->filter(fn ($r) => $r->percentage >= 50)->count();
            $passRates[] = $gradeResults->count() > 0
                ? round(($passCount / $gradeResults->count()) * 100, 1)
                : 0;
        }

        return [
            'labels' => $labels,
            'averages' => $averages,
            'passRates' => $passRates,
        ];
    }
}
