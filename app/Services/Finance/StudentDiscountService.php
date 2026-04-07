<?php

namespace App\Services\Finance;

use App\Models\Academic\AcademicYear;
use App\Models\Users\Student;
use App\Models\Finance\StudentDiscount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StudentDiscountService
{
    /**
     * Get the base query for fetching discounts with necessary relationships and filters.
     */
    public function getDiscountsQuery(array $filters): Builder
    {
        $query = StudentDiscount::with(['student', 'academicYear', 'studentAccount']);

        return $this->applyFilters($query, $filters);
    }

    /**
     * Generate the DataTable response for the given query, including custom columns and formatting.
     */
    public function datatable(Builder $query): mixed
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('student', fn($row) => '<strong>' . e($row->student->name) . '</strong>')
            ->addColumn('academic_year', function ($row) {
                return $row->academicYear
                    ? '<span class="badge bg-info">' . e($row->academicYear->name) . '</span>'
                    : '-';
            })
            ->addColumn('amount', function ($row) {
                return '<span class="text-success fw-bold">' . number_format($row->amount, 2) . '</span>';
            })
            ->addColumn('date', fn($row) => '<small class="text-muted">' . $row->date->format('Y-m-d') . '</small>')
            ->addColumn('description', fn($row) => '<small>' . e($row->description) . '</small>')
            ->addColumn('actions', fn($row) => $this->renderActionsColumn($row))
            ->rawColumns(['student', 'academic_year', 'amount', 'date', 'description', 'actions'])
            ->make(true);
    }

    /**
     * Create a discount and record the corresponding credit in the student's ledger.
     */
    public function createDiscount(array $data): StudentDiscount
    {
        $student = Student::findOrFail($data['student_id']);

        return DB::transaction(function () use ($data, $student) {

            $discount = StudentDiscount::create([
                'student_id' => $student->id,
                'academic_year_id' => $data['academic_year_id'],
                'amount' => $data['amount'],
                'date' => $data['date'],
                'description' => $data['description'],
            ]);

            $discount->studentAccount()->create([
                'student_id' => $student->id,
                'debit' => 0.00,
                'credit' => $data['amount'],
                'date' => $data['date'],
                'description' => 'Discount #' . $discount->id . ' - ' . $data['description'],
            ]);

            return $discount;
        });
    }

    /**
     * Delete the discount and its associated student account entry in a single transaction.
     */
    public function deleteDiscount(StudentDiscount $discount): bool
    {
        return DB::transaction(function () use ($discount) {
            $this->deleteStudentAccount($discount);

            return $discount->delete();
        });
    }

    /**
     * Get the required lookup data for the discount form.
     */
    public function getLookups(): array
    {
        return [
            'academic_years' => AcademicYear::select('id', 'name')->get(),
        ];
    }

    /**
     * Delete the associated student account entry.
     */
    private function deleteStudentAccount(StudentDiscount $discount): void
    {
        if ($discount->studentAccount) {
            $discount->studentAccount()->delete();
        }
    }

    /**
     * Apply filters to the query.
     */
    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query->when(! empty($filters['student_id']), fn($q) => $q->where('student_id', $filters['student_id']));
        $query->when(! empty($filters['academic_year_id']), fn($q) => $q->where('academic_year_id', $filters['academic_year_id']));

        return $query->latest();
    }

    /**
     * Render the actions column for the discount table.
     */
    private function renderActionsColumn(StudentDiscount $discount): string
    {
        return view('admin.Finance.student_discounts.partials.actions', ['discount' => $discount])->render();
    }
}
