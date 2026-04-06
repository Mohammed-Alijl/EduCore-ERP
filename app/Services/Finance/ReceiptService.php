<?php

namespace App\Services\Finance;

use App\DTOs\PaymentResult;
use App\Models\Finance\Currency;
use App\Models\Finance\PaymentGateway;
use App\Models\Finance\Receipt;
use App\Models\Student;
use App\Services\Payments\PaymentGatewayManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReceiptService
{
    public function __construct(
        private readonly PaymentGatewayManager $gatewayManager,
    ) {}

    /**
     * Get the base query for fetching receipts with necessary relationships and filters.
     */
    public function getReceiptsQuery(array $filters): Builder
    {
        $query = Receipt::with(['student', 'academicYear', 'currency', 'paymentGateway']);

        return $this->applyFilters($query, $filters);
    }

    /**
     * Generate the DataTable response for the given query, including custom columns and formatting.
     */
    public function datatable(Builder $query)
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('student', fn ($row) => '<strong>'.e($row->student->name).'</strong>')
            ->addColumn('payment_method', fn ($row) => '<span class="badge badge-info">'.e($row->paymentGateway->name).'</span>')
            ->addColumn('amount', function ($row) {
                $html = '<span class="text-success fw-bold">'.number_format($row->paid_amount, 2).' '.$row->currency_code.'</span><br>'
                    .'<small class="text-muted">'.__('admin.Finance.receipts.fields.base_amount').': $'.number_format($row->base_amount, 2).'</small>';

                if ($row->surcharge_amount > 0) {
                    $html .= '<br><small class="text-warning">'.__('admin.Finance.receipts.fields.surcharge').': '.number_format($row->surcharge_amount, 2).' '.$row->currency_code.'</small>';
                }

                return $html;
            })
            ->addColumn('date', fn ($row) => '<small class="text-muted">'.$row->date->format('Y-m-d').'</small>')
            ->addColumn('actions', fn ($row) => $this->renderActionsColumn($row))
            ->rawColumns(['student', 'payment_method', 'amount', 'date', 'actions'])
            ->make(true);
    }

    /**
     * Initiate receipt creation using the Strategy Pattern for payment processing.
     *
     * For offline gateways: creates DB records immediately and returns the Receipt.
     * For online gateways: returns a PaymentResult with redirect_url (no DB records yet).
     */
    public function createReceipt(array $data): Receipt|PaymentResult
    {
        $student = Student::findOrFail($data['student_id']);
        $currency = Currency::where('code', $data['currency_code'])->firstOrFail();
        $gateway = PaymentGateway::findOrFail($data['payment_gateway_id']);

        $processor = $this->gatewayManager->resolveFromGateway($gateway);
        $processor->validatePayment($data);
        $result = $processor->initiatePayment($data, $gateway);

        // online payment
        if ($result->isPending) {
            return $result;
        }

        // Payment failed
        if (! $result->success) {
            throw new \RuntimeException($result->message);
        }

        // offline payment create the result
        return $this->createReceiptFromResult($data, $result, $student, $currency, $gateway);
    }

    /**
     * Create the receipt and student ledger entry from a verified payment result.
     *
     * Used by createReceipt() for sync gateways, and by future webhook handler for async gateways.
     */
    public function createReceiptFromResult(
        array $data,
        PaymentResult $result,
        Student $student,
        Currency $currency,
        PaymentGateway $gateway,
    ): Receipt {
        return DB::transaction(function () use ($data, $result, $student, $currency, $gateway) {
            $paidForDebt = $data['paid_amount'];
            $surchargeAmount = $result->surchargeAmount;
            $baseAmount = $this->calculateBaseAmount($paidForDebt, $currency->exchange_rate);

            $receipt = Receipt::create([
                'student_id' => $student->id,
                'academic_year_id' => $data['academic_year_id'],
                'payment_gateway_id' => $gateway->id,
                'paid_amount' => $paidForDebt,
                'surcharge_amount' => $surchargeAmount,
                'currency_code' => $data['currency_code'],
                'exchange_rate' => $currency->exchange_rate,
                'base_amount' => $baseAmount,
                'transaction_id' => $result->transactionReference,
                'date' => $data['date'] ?? now()->toDateString(),
                'description' => $data['description'] ?? 'Receipt for student '.$student->name,
            ]);

            // Student ledger — ONLY credit the debt portion (surcharge excluded)
            $receipt->studentAccount()->create([
                'student_id' => $student->id,
                'debit' => 0.00,
                'credit' => $baseAmount,
                'date' => $data['date'] ?? now()->toDateString(),
                'description' => 'Receipt #'.$receipt->id.' via '.$gateway->name
                    .' - Ref: '.$result->transactionReference,
            ]);

            return $receipt;
        });
    }

    /**
     * Delete the receipt and its associated student account entry in a single transaction.
     */
    public function deleteReceipt(Receipt $receipt): bool
    {
        return DB::transaction(function () use ($receipt) {
            $this->deleteStudentAccount($receipt);

            return $receipt->delete();
        });
    }

    /**
     * Get the required lookup data for the receipts form.
     */
    public function getLookups(): array
    {
        $allGateways = \App\Models\PaymentGateway::where('status', true)
            ->select('id', 'code', 'name')
            ->get();

        return [
            'academic_years' => \App\Models\AcademicYear::select('id', 'name')->get(),
            'payment_gateways' => $allGateways,
            'offline_payment_gateways' => $allGateways->filter(fn ($gateway) => ! $this->gatewayManager->resolveFromGateway($gateway)->isOnline())->values(),
            'currencies' => \App\Models\Currency::select('code', 'name', 'is_default')->get(),
        ];
    }

    /**
     * Convert the paid amount to the base currency using the exchange rate.
     */
    private function calculateBaseAmount(float $paidAmount, float $exchangeRate): float
    {
        return round($paidAmount / $exchangeRate, 2);
    }

    /**
     * Delete the associated student account entry.
     */
    private function deleteStudentAccount(Receipt $receipt): void
    {
        if ($receipt->studentAccount) {
            $receipt->studentAccount()->delete();
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
     * Render the actions column for the receipt table.
     */
    private function renderActionsColumn(Receipt $receipt): string
    {
        return view('admin.Finance.receipts.partials.actions', ['receipt' => $receipt])->render();
    }
}
