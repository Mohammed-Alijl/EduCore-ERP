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
                    return '<span class="badge bg-danger">' . trans('admin.reports.financial.last_payment_not_found') . '</span>';
                }

                return '<span class="badge bg-secondary">' . \Carbon\Carbon::parse($row->last_payment_date)->diffForHumans() . '</span><br><small class="text-muted">' . $row->last_payment_date . '</small>';
            })
            ->addColumn('actions', function ($row) {
                return view('admin.reports.partials.finance_actions', compact('row'))->render();
            })
            ->rawColumns(['last_payment_date', 'actions'])
            ->make(true);
    }
}
