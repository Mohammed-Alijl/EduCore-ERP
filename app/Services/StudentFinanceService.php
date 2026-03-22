<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\PaymentVoucher;
use App\Models\Receipt;
use App\Models\Student;
use App\Models\StudentAccount;
use App\Models\StudentDiscount;
use Illuminate\Support\Collection;

/**
 * Service for retrieving and structuring student financial data.
 */
class StudentFinanceService
{
    /**
     * Get complete financial overview for a student.
     */
    public function getFinancialOverview(Student $student): array
    {
        $ledgerEntries = $this->getLedgerEntries($student);

        $summary = $this->calculateSummaryFromLedger($ledgerEntries);

        $groupedEntries = $this->groupEntriesByType($ledgerEntries);

        return [
            'student' => $this->getStudentInfo($student),
            'summary' => $summary,
            'invoices' => $groupedEntries['invoices'],
            'receipts' => $groupedEntries['receipts'],
            'discounts' => $groupedEntries['discounts'],
            'vouchers' => $groupedEntries['vouchers'],
            'ledger' => $this->formatLedgerForDisplay($ledgerEntries),
        ];
    }

    /**
     * Get basic student information for the modal header.
     */
    private function getStudentInfo(Student $student): array
    {
        return [
            'id' => $student->id,
            'name' => $student->name,
            'student_code' => $student->student_code,
            'image_url' => $student->image_url,
            'grade' => optional($student->grade)->name,
            'classroom' => optional($student->classroom)->name,
            'section' => optional($student->section)->name,
        ];
    }

    /**
     * Get all ledger entries with eager-loaded transactionable data.
     *
     */
    private function getLedgerEntries(Student $student): Collection
    {
        return $student->studentAccounts()
            ->with(['transactionable' => function ($morphTo) {
                $morphTo->morphWith([
                    Invoice::class => ['fee', 'academicYear'],
                    Receipt::class => ['paymentGateway', 'academicYear'],
                    StudentDiscount::class => ['academicYear'],
                    PaymentVoucher::class => ['paymentGateway', 'academicYear'],
                ]);
            }])
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->get();
    }

    /**
     * Calculate financial summary directly from ledger entries.
     */
    private function calculateSummaryFromLedger(Collection $ledgerEntries): array
    {
        $totalDebit = $ledgerEntries->sum('debit');
        $totalCredit = $ledgerEntries->sum('credit');
        $balance = $totalDebit - $totalCredit;

        $counts = $ledgerEntries->groupBy('transactionable_type')->map->count();

        // Calculate totals by type
        $totalPaid = $ledgerEntries
            ->where('transactionable_type', Receipt::class)
            ->sum('credit');

        $totalDiscounts = $ledgerEntries
            ->where('transactionable_type', StudentDiscount::class)
            ->sum('credit');

        $totalVouchers = $ledgerEntries
            ->where('transactionable_type', PaymentVoucher::class)
            ->sum('debit');

        return [
            'total_invoiced' => $this->formatAmount($totalDebit),
            'total_paid' => $this->formatAmount($totalPaid),
            'total_discounts' => $this->formatAmount($totalDiscounts),
            'total_vouchers' => $this->formatAmount($totalVouchers),
            'balance' => $this->formatAmount($balance),
            'balance_raw' => $balance,
            'status' => $this->determinePaymentStatus($balance),
            'invoice_count' => $counts[Invoice::class] ?? 0,
            'receipt_count' => $counts[Receipt::class] ?? 0,
            'discount_count' => $counts[StudentDiscount::class] ?? 0,
        ];
    }

    /**
     * Group ledger entries by transaction type and format for display.
     */
    private function groupEntriesByType(Collection $ledgerEntries): array
    {
        return [
            'invoices' => $this->formatInvoices($ledgerEntries),
            'receipts' => $this->formatReceipts($ledgerEntries),
            'discounts' => $this->formatDiscounts($ledgerEntries),
            'vouchers' => $this->formatVouchers($ledgerEntries),
        ];
    }

    /**
     * Format invoice entries from ledger.
     */
    private function formatInvoices(Collection $ledgerEntries): Collection
    {
        return $ledgerEntries
            ->where('transactionable_type', Invoice::class)
            ->filter(fn($entry) => $entry->transactionable !== null)
            ->map(function (StudentAccount $entry) {
                $invoice = $entry->transactionable;

                return [
                    'id' => $invoice->id,
                    'fee_title' => optional($invoice->fee)->title ?? trans('admin.global.no_description'),
                    'academic_year' => optional($invoice->academicYear)->name,
                    'grade' => optional($invoice->grade)->name,
                    'classroom' => optional($invoice->classroom)->name,
                    'amount' => $this->formatAmount($entry->debit),
                    'amount_raw' => $entry->debit,
                    'date' => $entry->date->format('Y-m-d'),
                    'description' => $entry->description,
                ];
            })
            ->values();
    }

    /**
     * Format receipt entries from ledger.
     */
    private function formatReceipts(Collection $ledgerEntries): Collection
    {
        return $ledgerEntries
            ->where('transactionable_type', Receipt::class)
            ->filter(fn($entry) => $entry->transactionable !== null)
            ->map(function (StudentAccount $entry) {
                $receipt = $entry->transactionable;

                return [
                    'id' => $receipt->id,
                    'payment_gateway' => optional($receipt->paymentGateway)->name,
                    'academic_year' => optional($receipt->academicYear)->name,
                    'paid_amount' => $this->formatAmount($receipt->paid_amount ?? $entry->credit),
                    'currency' => $receipt->currency_code ?? null,
                    'exchange_rate' => $receipt->exchange_rate ?? null,
                    'base_amount' => $this->formatAmount($entry->credit),
                    'base_amount_raw' => $entry->credit,
                    'date' => $entry->date->format('Y-m-d'),
                    'description' => $entry->description,
                    'transaction_id' => $receipt->transaction_id ?? null,
                ];
            })
            ->values();
    }

    /**
     * Format discount entries from ledger.
     */
    private function formatDiscounts(Collection $ledgerEntries): Collection
    {
        return $ledgerEntries
            ->where('transactionable_type', StudentDiscount::class)
            ->filter(fn($entry) => $entry->transactionable !== null)
            ->map(function (StudentAccount $entry) {
                $discount = $entry->transactionable;

                return [
                    'id' => $discount->id,
                    'academic_year' => optional($discount->academicYear)->name,
                    'amount' => $this->formatAmount($entry->credit),
                    'amount_raw' => $entry->credit,
                    'date' => $entry->date->format('Y-m-d'),
                    'description' => $entry->description,
                ];
            })
            ->values();
    }

    /**
     * Format payment voucher entries from ledger.
     */
    private function formatVouchers(Collection $ledgerEntries): Collection
    {
        return $ledgerEntries
            ->where('transactionable_type', PaymentVoucher::class)
            ->filter(fn($entry) => $entry->transactionable !== null)
            ->map(function (StudentAccount $entry) {
                $voucher = $entry->transactionable;

                return [
                    'id' => $voucher->id,
                    'payment_gateway' => optional($voucher->paymentGateway)->name,
                    'academic_year' => optional($voucher->academicYear)->name,
                    'amount' => $this->formatAmount($voucher->amount ?? $entry->debit),
                    'currency' => $voucher->currency_code ?? null,
                    'base_amount' => $this->formatAmount($entry->debit),
                    'base_amount_raw' => $entry->debit,
                    'date' => $entry->date->format('Y-m-d'),
                    'reference_number' => $voucher->reference_number ?? null,
                    'description' => $entry->description,
                ];
            })
            ->values();
    }

    /**
     * Format ledger entries for the main ledger table display.
     */
    private function formatLedgerForDisplay(Collection $ledgerEntries): Collection
    {
        return $ledgerEntries->map(fn(StudentAccount $entry) => [
            'id' => $entry->id,
            'type' => $this->getTransactionType($entry),
            'type_class' => $this->getTransactionTypeClass($entry),
            'debit' => $entry->debit > 0 ? $this->formatAmount($entry->debit) : null,
            'credit' => $entry->credit > 0 ? $this->formatAmount($entry->credit) : null,
            'debit_raw' => $entry->debit,
            'credit_raw' => $entry->credit,
            'date' => $entry->date->format('Y-m-d'),
            'description' => $entry->description,
        ]);
    }

    /**
     * Determine the payment status based on balance.
     */
    private function determinePaymentStatus(float $balance): array
    {
        if ($balance <= 0) {
            return [
                'label' => trans('admin.students.finance.status.paid'),
                'class' => 'success',
                'icon' => 'la-check-circle',
            ];
        }

        return [
            'label' => trans('admin.students.finance.status.outstanding'),
            'class' => 'danger',
            'icon' => 'la-exclamation-circle',
        ];
    }

    /**
     * Get the transaction type label based on the polymorphic relationship.
     */
    private function getTransactionType(StudentAccount $entry): string
    {
        return match ($entry->transactionable_type) {
            Invoice::class => trans('admin.students.finance.types.invoice'),
            Receipt::class => trans('admin.students.finance.types.receipt'),
            StudentDiscount::class => trans('admin.students.finance.types.discount'),
            PaymentVoucher::class => trans('admin.students.finance.types.voucher'),
            default => trans('admin.students.finance.types.other'),
        };
    }

    /**
     * Get the CSS class for transaction type badge.
     */
    private function getTransactionTypeClass(StudentAccount $entry): string
    {
        return match ($entry->transactionable_type) {
            Invoice::class => 'danger',
            Receipt::class => 'success',
            StudentDiscount::class => 'info',
            PaymentVoucher::class => 'warning',
            default => 'secondary',
        };
    }

    /**
     * Format amount with currency symbol.
     */
    private function formatAmount(float $amount): string
    {
        return number_format($amount, 2);
    }
}
