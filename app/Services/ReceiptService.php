<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Receipt;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReceiptService
{
    public function getReceiptsQuery(array $filters): Builder
    {
        $query = Receipt::with(['student', 'invoice.fee.feeCategory', 'grade', 'classroom', 'academicYear']);

        return $this->applyFilters($query, $filters);
    }

    public function datatable(Builder $query)
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('receipt_number', fn($row) => '<span class="badge badge-receipt-number">' . e($row->receipt_number) . '</span>')
            ->addColumn('student', fn($row) => '<strong>' . e($row->student->name) . '</strong><br><small class="text-muted">' . e($row->student->student_code ?? '') . '</small>')
            ->addColumn('invoice_ref', fn($row) => '<span class="text-muted">INV-#' . $row->invoice_id . '</span>')
            ->addColumn('amount', fn($row) => '<span class="receipt-amount-cell">$' . number_format($row->amount, 2) . '</span>')
            ->addColumn('payment_method', fn($row) => $this->renderPaymentMethodBadge($row->payment_method))
            ->addColumn('date', fn($row) => '<small class="text-muted">' . $row->receipt_date->format('Y-m-d') . '</small>')
            ->addColumn('actions', fn($row) => $this->renderActionsColumn($row))
            ->rawColumns(['receipt_number', 'student', 'invoice_ref', 'amount', 'payment_method', 'date', 'actions'])
            ->make(true);
    }

    public function createReceipt(array $data): Receipt
    {
        return DB::transaction(function () use ($data) {
            $invoice = Invoice::with(['student', 'grade', 'classroom', 'academicYear'])->findOrFail($data['invoice_id']);

            $receipt = Receipt::create([
                'receipt_number'  => $this->generateReceiptNumber(),
                'invoice_id'      => $invoice->id,
                'student_id'      => $invoice->student_id,
                'grade_id'        => $invoice->grade_id,
                'classroom_id'    => $invoice->classroom_id,
                'academic_year_id' => $invoice->academic_year_id,
                'amount'          => $invoice->amount,
                'payment_method'  => $data['payment_method'],
                'receipt_date'    => now()->toDateString(),
                'description'     => $data['description'] ?? null,
            ]);

            return $receipt;
        });
    }

    public function deleteReceipt(Receipt $receipt): bool
    {
        return DB::transaction(function () use ($receipt) {
            return $receipt->delete();
        });
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query->when(!empty($filters['student_id']), fn($q) => $q->where('student_id', $filters['student_id']));
        $query->when(!empty($filters['grade_id']), fn($q) => $q->where('grade_id', $filters['grade_id']));
        $query->when(!empty($filters['classroom_id']), fn($q) => $q->where('classroom_id', $filters['classroom_id']));
        $query->when(!empty($filters['academic_year_id']), fn($q) => $q->where('academic_year_id', $filters['academic_year_id']));
        $query->when(!empty($filters['payment_method']), fn($q) => $q->where('payment_method', $filters['payment_method']));

        return $query->latest();
    }

    private function renderActionsColumn(Receipt $receipt): string
    {
        return view('admin.finance.receipts.partials.actions', ['receipt' => $receipt])->render();
    }

    private function renderPaymentMethodBadge(string $method): string
    {
        $badges = [
            'cash'          => '<span class="receipt-badge receipt-badge-cash"><i class="las la-money-bill-wave mr-1"></i>' . trans('admin.finance.receipts.payment_methods.cash') . '</span>',
            'bank_transfer' => '<span class="receipt-badge receipt-badge-transfer"><i class="las la-university mr-1"></i>' . trans('admin.finance.receipts.payment_methods.bank_transfer') . '</span>',
            'cheque'        => '<span class="receipt-badge receipt-badge-cheque"><i class="las la-file-alt mr-1"></i>' . trans('admin.finance.receipts.payment_methods.cheque') . '</span>',
            'online'        => '<span class="receipt-badge receipt-badge-online"><i class="las la-credit-card mr-1"></i>' . trans('admin.finance.receipts.payment_methods.online') . '</span>',
        ];

        return $badges[$method] ?? e($method);
    }

    public function generateReceiptNumber(): string
    {
        $year = now()->format('Y');
        $last = Receipt::where('receipt_number', 'like', "RCP-{$year}-%")
            ->orderByDesc('id')
            ->first();

        $sequence = $last
            ? (int) substr($last->receipt_number, strrpos($last->receipt_number, '-') + 1) + 1
            : 1;

        return "RCP-{$year}-" . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
