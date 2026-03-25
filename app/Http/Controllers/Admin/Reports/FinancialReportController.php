<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Services\Reports\FinancialReportService;
use App\Http\Requests\Export\FinancialReportRequest;
use App\Jobs\GenerateFinancialExportJob;
use App\Jobs\GenerateFinancialPdfJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class FinancialReportController extends Controller implements HasMiddleware
{
    public function __construct(
        private readonly FinancialReportService $reportService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_financial-reports', only: ['outstandingBalances']),
            new Middleware('permission:export_financial-reports', only: ['requestExport', 'requestPdfExport']),
        ];
    }

    public function outstandingBalances(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->reportService->getOutstandingBalancesQuery();

            return $this->reportService->datatable($query);
        }

        $kpis = $this->reportService->getFinancialKPIs();
        $chartData = $this->reportService->getChartData();

        return view('admin.reports.finance.outstanding_balances', compact('kpis', 'chartData'));
    }

    /**
     * Request Excel export
     */
    public function requestExport(FinancialReportRequest $request): JsonResponse
    {
        $admin = auth('admin')->user();

        GenerateFinancialExportJob::dispatch($admin);

        return response()->json([
            'status' => 'success',
            'message' => trans('admin.exports.financial_report.generate_report_message'),
        ]);
    }

    /**
     * Request PDF export
     */
    public function requestPdfExport(FinancialReportRequest $request): JsonResponse
    {
        $admin = auth('admin')->user();

        GenerateFinancialPdfJob::dispatch($admin, app()->getLocale());

        return response()->json([
            'status' => 'success',
            'message' => trans('admin.exports.financial_report_pdf.generate_report_message'),
        ]);
    }
}
