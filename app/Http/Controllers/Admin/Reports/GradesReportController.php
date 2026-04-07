<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\GradesReportRequest;
use App\Jobs\GenerateGradesExportJob;
use App\Jobs\GenerateGradesPdfJob;
use App\Services\Reports\GradesReportService;
use Illuminate\Http\JsonResponse;
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
            new Middleware('permission:export_grades-reports', only: ['requestExport', 'requestPdfExport']),
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

        return view('admin.Reports.grades.index', compact('kpis', 'chartData', 'filterData', 'filters'));
    }

    /**
     * Get subjects filtered dynamically by grade and classroom
     */
    public function getSubjects(Request $request)
    {
        $data = $this->reportService->getSubjects($request);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Get exams filtered dynamically by academic year, subject, and bounds
     */
    public function getExams(Request $request)
    {
        $data = $this->reportService->getExames($request);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Request Excel export
     */
    public function requestExport(GradesReportRequest $request): JsonResponse
    {
        $admin = auth('admin')->user();
        $filters = $request->validated();

        GenerateGradesExportJob::dispatch($admin, $filters);

        return response()->json([
            'status' => 'success',
            'message' => trans('admin.exports.grades_report.generate_report_message'),
        ]);
    }

    /**
     * Request PDF export
     */
    public function requestPdfExport(GradesReportRequest $request): JsonResponse
    {
        $admin = auth('admin')->user();
        $filters = $request->validated();

        GenerateGradesPdfJob::dispatch($admin, $filters, app()->getLocale());

        return response()->json([
            'status' => 'success',
            'message' => trans('admin.exports.grades_report_pdf.generate_report_message'),
        ]);
    }
}
