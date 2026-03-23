<?php

namespace App\Services\Reports;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FinancialReportService
{
    public function getOutstandingBalancesQuery()
    {
        $locale = app()->getLocale();

        return DB::table('student_accounts')
            ->join('students', 'student_accounts.student_id', '=', 'students.id')
            ->select(
                'students.id',
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(students.name, '$.\"{$locale}\"')) as name"),

                DB::raw('SUM(student_accounts.debit) as total_charges'),

                DB::raw('SUM(student_accounts.credit) as total_payments'),

                DB::raw('SUM(student_accounts.debit) - SUM(student_accounts.credit) as net_balance'),

                DB::raw('MAX(CASE WHEN student_accounts.credit > 0 THEN student_accounts.date ELSE NULL END) as last_payment_date') // The last payment date (only consider credit transactions)
            )
            ->groupBy('students.id', DB::raw("JSON_UNQUOTE(JSON_EXTRACT(students.name, '$.\"{$locale}\"'))"))
            ->havingRaw('net_balance > 0')
            ->orderByDesc('net_balance')
            ->get();
    }

    /**
     * KPIS For Financial Report
     */
    public function getFinancialKPIs()
    {
        $balances = $this->getOutstandingBalancesQuery();

        return [
            'total_expected_revenue' => $balances->sum('net_balance'),

            'defaulters_count' => $balances->count(),

            'average_debt' => $balances->count() > 0
                ? round($balances->sum('net_balance') / $balances->count(), 2)
                : 0,
        ];
    }

    public function datatable($query)
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('last_payment_date', function ($row) {
                if (! $row->last_payment_date) {
                    return '<span class="badge bg-danger">'.trans('admin.reports.financial.last_payment_not_found').'</span>';
                }

                return '<span class="badge bg-secondary">'.\Carbon\Carbon::parse($row->last_payment_date)->diffForHumans().'</span><br><small class="text-muted">'.$row->last_payment_date.'</small>';
            })
            ->addColumn('actions', function ($row) {
                return view('admin.reports.finance.partials._actions', compact('row'))->render();
            })
            ->rawColumns(['last_payment_date', 'actions'])
            ->make(true);
    }

    /**
     * Get chart data for financial reports
     */
    public function getChartData(): array
    {
        return [
            'revenueTrend' => $this->getRevenueTrendData(),
            'studentDistribution' => $this->getStudentDistributionData(),
            'paymentTimeline' => $this->getPaymentTimelineData(),
        ];
    }

    /**
     * Get revenue trend data for the last 12 months
     */
    protected function getRevenueTrendData(): array
    {
        $data = DB::table('student_accounts')
            ->select(
                DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
                DB::raw('SUM(debit) as charges'),
                DB::raw('SUM(credit) as payments'),
                DB::raw('SUM(debit) - SUM(credit) as outstanding')
            )
            ->where('date', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'categories' => $data->pluck('month')->toArray(),
            'charges' => $data->pluck('charges')->map(fn ($val) => (float) $val)->toArray(),
            'payments' => $data->pluck('payments')->map(fn ($val) => (float) $val)->toArray(),
            'outstanding' => $data->pluck('outstanding')->map(fn ($val) => (float) $val)->toArray(),
        ];
    }

    /**
     * Get student distribution by balance range
     */
    protected function getStudentDistributionData(): array
    {
        $balances = $this->getOutstandingBalancesQuery();

        $ranges = [
            '0-1000' => $balances->filter(fn ($b) => $b->net_balance > 0 && $b->net_balance <= 1000)->count(),
            '1001-5000' => $balances->filter(fn ($b) => $b->net_balance > 1000 && $b->net_balance <= 5000)->count(),
            '5001-10000' => $balances->filter(fn ($b) => $b->net_balance > 5000 && $b->net_balance <= 10000)->count(),
            '10000+' => $balances->filter(fn ($b) => $b->net_balance > 10000)->count(),
        ];

        return [
            'labels' => array_keys($ranges),
            'values' => array_values($ranges),
        ];
    }

    /**
     * Get payment timeline data for the last 12 months
     */
    protected function getPaymentTimelineData(): array
    {
        $data = DB::table('student_accounts')
            ->select(
                DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
                DB::raw('SUM(CASE WHEN debit > 0 THEN debit ELSE 0 END) as total_charges'),
                DB::raw('SUM(CASE WHEN credit > 0 THEN credit ELSE 0 END) as total_payments')
            )
            ->where('date', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'categories' => $data->pluck('month')->toArray(),
            'charges' => $data->pluck('total_charges')->map(fn ($val) => (float) $val)->toArray(),
            'payments' => $data->pluck('total_payments')->map(fn ($val) => (float) $val)->toArray(),
        ];
    }
}
