<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Services\Reports\FinancialReportService;
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
}
