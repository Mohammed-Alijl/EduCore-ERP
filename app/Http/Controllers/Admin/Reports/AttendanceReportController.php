<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Services\Reports\AttendanceReportService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AttendanceReportController extends Controller implements HasMiddleware
{
    public function __construct(
        private readonly AttendanceReportService $reportService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_attendance-reports', only: ['index']),
        ];
    }

    public function index(Request $request)
    {
        $academicYears = AcademicYear::orderBy('name')->get();

        // Default to the current academic year if no filter is provided
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

        return view('admin.reports.attendance.index', compact(
            'kpis',
            'chartData',
            'academicYears',
            'academicYearId',
        ));
    }
}
