<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Services\Reports\GradesReportService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GradesReportController extends Controller implements HasMiddleware
{
    public function __construct(
        private readonly GradesReportService $reportService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_grades-reports', only: ['index']),
        ];
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'academic_year_id',
            'grade_id',
            'classroom_id',
            'section_id',
            'subject_id',
            'exam_id',
        ]);

        if ($request->ajax()) {
            $query = $this->reportService->getGradesQuery($filters);

            return $this->reportService->datatable($query);
        }

        $kpis = $this->reportService->getKPIs($filters);
        $chartData = $this->reportService->getChartData($filters);
        $filterData = $this->reportService->getFilterData();

        return view('admin.reports.grades.index', compact('kpis', 'chartData', 'filterData', 'filters'));
    }
}
