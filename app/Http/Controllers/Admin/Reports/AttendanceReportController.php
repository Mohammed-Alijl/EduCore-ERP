<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\AttendanceReportRequest;
use App\Jobs\GenerateAttendanceExportJob;
use App\Jobs\GenerateAttendancePdfJob;
use App\Models\AcademicYear;
use App\Services\Academic\GradeService;
use App\Services\Reports\AttendanceReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class AttendanceReportController extends Controller implements HasMiddleware
{
    public function __construct(
        private readonly AttendanceReportService $reportService,
        private readonly GradeService $gradeService,
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_attendanceReports', only: ['index']),
            new Middleware('permission:export_attendanceReports', only: ['requestExport', 'requestPdfExport']),
        ];
    }

    /**
     * Display the attendance report dashboard.
     */
    public function index(Request $request): View|JsonResponse
    {
        $academicYears = AcademicYear::orderBy('name')->get();

        $academicYearId = $request->input(
            'academic_year_id',
            $academicYears->firstWhere('is_current', true)?->id ?? $academicYears->first()?->id
        );

        if ($request->ajax()) {
            $query = $this->reportService->getStudentAttendanceSummaryQuery((int) $academicYearId);

            return $this->reportService->datatable($query);
        }

        $kpis = $this->reportService->getAttendanceKPIs((int) $academicYearId);
        $chartData = $this->reportService->getChartData((int) $academicYearId);
        $grades = $this->gradeService->getActive();

        return view('admin.Reports.attendance.index', compact(
            'kpis',
            'chartData',
            'academicYears',
            'academicYearId',
            'grades',
        ));
    }

    /**
     * Request an attendance report export (Excel).
     */
    public function requestExport(AttendanceReportRequest $request): JsonResponse
    {
        $admin = auth('admin')->user();

        GenerateAttendanceExportJob::dispatch(
            $admin,
            $request->validated('academic_year_id'),
            $request->validated('grade_id'),
            $request->validated('section_id')
        );

        return response()->json([
            'status' => 'success',
            'message' => trans('admin.exports.attendance_report.generate_report_message'),
        ]);
    }

    /**
     * Request an attendance report PDF export.
     */
    public function requestPdfExport(AttendanceReportRequest $request): JsonResponse
    {
        $admin = auth('admin')->user();

        GenerateAttendancePdfJob::dispatch(
            $admin,
            $request->validated('academic_year_id'),
            $request->validated('grade_id'),
            $request->validated('section_id'),
            app()->getLocale()
        );

        return response()->json([
            'status' => 'success',
            'message' => trans('admin.exports.attendance_report_pdf.generate_report_message'),
        ]);
    }
}
