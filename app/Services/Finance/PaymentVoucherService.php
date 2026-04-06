<?php

namespace App\Services\Finance;

use App\Models\Academic\AcademicYear;
use App\Models\Currency;
use App\Models\PaymentGateway;
use App\Models\PaymentVoucher;
use App\Models\Student;
use App\Services\Payments\PaymentGatewayManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PaymentVoucherService
{
    public function __construct(
        private readonly PaymentGatewayManager $gatewayManager,
    ) {}

    /**
     * Get the base query for fetching vouchers with necessary relationships and filters.
     */
    public function getVouchersQuery(array $filters): Builder
    {
        $query = PaymentVoucher::with(['student', 'academicYear', 'paymentGateway']);

        return $this->applyFilters($query, $filters);
    }

    /**
     * Generate the DataTable response for the given query, including custom columns and formatting.
     */
    public function datatable(Builder $query): mixed
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('student', fn ($row) => '<strong>'.e($row->student->name).'</strong>')
            ->addColumn('payment_method', fn ($row) => '<span class="badge badge-info">'.e($row->paymentGateway->name).'</span>')
            ->addColumn('amount', function ($row) {
                return '<span class="text-danger fw-bold">'.number_format($row->amount, 2).' '.$row->currency_code.'</span><br>'
                    .'<small class="text-muted">'.__('admin.Finance.payment_vouchers.fields.base_amount').': $'.number_format($row->base_amount, 2).'</small>';
            })
            ->addColumn('date', fn ($row) => '<small class="text-muted">'.$row->date->format('Y-m-d').'</small>')
            ->addColumn('actions', fn ($row) => $this->renderActionsColumn($row))
            ->rawColumns(['student', 'payment_method', 'amount', 'date', 'actions'])
            ->make(true);
    }

    /**
     * Create a voucher and record the corresponding debit in the student's ledger.
     */
    public function create(array $data): PaymentVoucher
    {
        return DB::transaction(function () use ($data) {
            $currency = Currency::where('code', $data['currency_code'])->firstOrFail();
            $gateway = PaymentGateway::findOrFail($data['payment_gateway_id']);
            $student = Student::findOrFail($data['student_id']);

            $baseAmount = $this->calculateBaseAmount((float) $data['amount'], (float) $currency->exchange_rate);

            $voucher = PaymentVoucher::create([
                'student_id' => $student->id,
                'academic_year_id' => $data['academic_year_id'],
                'payment_gateway_id' => $gateway->id,
                'amount' => $data['amount'],
                'currency_code' => $data['currency_code'],
                'exchange_rate' => $currency->exchange_rate,
                'base_amount' => $baseAmount,
                'date' => $data['date'] ?? now()->toDateString(),
                'reference_number' => $data['reference_number'] ?? null,
                'description' => $data['description'],
            ]);

            // Student ledger — debit the voucher amount from the student's account balance
            $voucher->studentAccount()->create([
                'student_id' => $student->id,
                'debit' => $baseAmount,
                'credit' => 0.00,
                'date' => $data['date'] ?? now()->toDateString(),
                'description' => 'Voucher #'.$voucher->id.' via '.$gateway->name
                    .($data['reference_number'] ? ' - Ref: '.$data['reference_number'] : ''),
            ]);

            return $voucher;
        });
    }

    /**
     * Delete the voucher and its associated student account entry in a single transaction.
     */
    public function delete(PaymentVoucher $voucher): bool
    {
        return DB::transaction(function () use ($voucher) {
            $this->deleteStudentAccount($voucher);

            return $voucher->delete();
        });
    }

    /**
     * Get the required lookup data for the voucher form.
     */
    public function getLookups(): array
    {
        $allGateways = PaymentGateway::where('status', true)
            ->select('id', 'code', 'name')
            ->get();

        return [
            'academic_years' => AcademicYear::select('id', 'name')->get(),
            'payment_gateways' => $allGateways->filter(fn ($gateway) => ! $this->gatewayManager->resolveFromGateway($gateway)->isOnline())->values(),
            'currencies' => Currency::select('code', 'name', 'is_default')->get(),
        ];
    }

    /**
     * Convert the paid amount to the base currency using the exchange rate.
     */
    private function calculateBaseAmount(float $amount, float $exchangeRate): float
    {
        return round($amount / $exchangeRate, 2);
    }

    /**
     * Delete the associated student account entry.
     */
    private function deleteStudentAccount(PaymentVoucher $voucher): void
    {
        if ($voucher->studentAccount) {
            $voucher->studentAccount()->delete();
        }
    }

    /**
     * Apply filters to the query.
     */
    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query->when(! empty($filters['student_id']), fn ($q) => $q->where('student_id', $filters['student_id']));
        $query->when(! empty($filters['payment_gateway_id']), fn ($q) => $q->where('payment_gateway_id', $filters['payment_gateway_id']));

        return $query->latest();
    }

    /**
     * Render the actions column for the voucher table.
     */
    private function renderActionsColumn(PaymentVoucher $voucher): string
    {
        return view('admin.Finance.payment_vouchers.partials.actions', ['voucher' => $voucher])->render();
    }
}
