<?php

namespace App\Services\Finance;

use App\Models\Fee;
use App\Models\Invoice;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InvoiceService
{
    public function __construct(protected readonly AcademicYearService $academicYearService) {}

    public function getInvoicesQuery(array $filters): Builder
    {
        $query = Invoice::with(['student', 'fee.feeCategory', 'grade', 'classroom', 'academicYear']);

        return $this->applyFilters($query, $filters);
    }

    public function datatable(Builder $query)
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('student', fn($row) => '<strong>' . e($row->student->name) . '</strong>')
            ->addColumn('fee_details', fn($row) => '<span class="badge badge-light">' . e($row->fee->title) . '</span>')
            ->addColumn('amount', fn($row) => '<span class="text-danger fw-bold">$' . number_format($row->amount, 2) . '</span>')
            ->addColumn('date', fn($row) => '<small class="text-muted">' . $row->invoice_date->format('Y-m-d') . '</small>')
            ->addColumn('actions', fn($row) => $this->renderActionsColumn($row))
            ->rawColumns(['student', 'fee_details', 'amount', 'date', 'actions'])
            ->make(true);
    }

    public function createInvoice(array $data): Invoice
    {
        return DB::transaction(function () use ($data) {
            $student = Student::findOrFail($data['student_id']);
            $fee = Fee::findOrFail($data['fee_id']);

            $description = $this->resolveDescription($data, $fee);
            $date = now()->toDateString();

            $invoice = Invoice::create($this->buildInvoicePayload($student, $fee, $description, $date));

            $invoice->studentAccount()->create(
                $this->buildStudentAccountPayload($student, $fee, $description, $date)
            );

            return $invoice;
        });
    }


    public function deleteInvoice(Invoice $invoice): bool
    {
        return DB::transaction(function () use ($invoice) {
            $this->deleteStudentAccount($invoice);

            return $invoice->delete();
        });
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query->when(!empty($filters['student_id']), fn($q) => $q->where('student_id', $filters['student_id']));
        $query->when(!empty($filters['grade_id']), fn($q) => $q->where('grade_id', $filters['grade_id']));
        $query->when(!empty($filters['classroom_id']), fn($q) => $q->where('classroom_id', $filters['classroom_id']));
        $query->when(!empty($filters['academic_year_id']), fn($q) => $q->where('academic_year_id', $filters['academic_year_id']));
        $query->when(!empty($filters['fee_id']), fn($q) => $q->where('fee_id', $filters['fee_id']));

        return $query->latest();
    }

    private function renderActionsColumn(Invoice $invoice): string
    {
        return view('admin.Finance.invoices.partials.actions', ['invoice' => $invoice])->render();
    }

    private function resolveDescription(array $data, Fee $fee): string
    {
        return $data['description'] ?? $fee->title;
    }

    private function buildInvoicePayload(Student $student, Fee $fee, string $description, string $date): array
    {
        $currentAcademicYear = $this->academicYearService->getCurrent();

        if (!$currentAcademicYear) {
            throw new \RuntimeException(trans('admin.Finance.messages.failed.no_current_academic_year'));
        }

        return [
            'student_id'   => $student->id,
            'academic_year_id' => $currentAcademicYear->id,
            'grade_id'     => $student->grade_id,
            'classroom_id' => $student->classroom_id,
            'fee_id'       => $fee->id,
            'amount'       => $fee->amount,
            'invoice_date' => $date,
            'description'  => $description,
        ];
    }

    private function buildStudentAccountPayload(Student $student, Fee $fee, string $description, string $date): array
    {
        return [
            'student_id'  => $student->id,
            'debit'       => $fee->amount,
            'credit'      => 0.00,
            'date'        => $date,
            'description' => 'create invoice: ' . $description,
        ];
    }

    private function deleteStudentAccount(Invoice $invoice): void
    {
        if ($invoice->studentAccount) {
            $invoice->studentAccount()->delete();
        }
    }
}
