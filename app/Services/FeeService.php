<?php

namespace App\Services;

use App\Models\AcademicYear;
use App\Models\Fee;
use App\Models\FeeCategory;
use App\Models\Grade;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;

class FeeService
{
    public function getFeesQuery(array $filters): Builder
    {
        $query = Fee::with(['feeCategory', 'academicYear', 'grade', 'classroom']);

        return $this->applyFilters($query, $filters);
    }

    public function datatable($query)
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('title', fn($row) => '<strong>' . e($row->title) . '</strong><br><small class="text-muted">' . e(str($row->description)->limit(30)) . '</small>')
            ->addColumn('amount', fn($row) => '<span class="text-success fw-bold">$' . number_format($row->amount, 2) . '</span>')
            ->addColumn('category', fn($row) => '<span class="badge badge-primary">' . e($row->feeCategory->title) . '</span>')
            ->addColumn('academic_target', function ($row) {
                $target = '<span class="badge badge-info">' . e($row->academicYear->name) . '</span> - ';
                $target .= '<span class="badge badge-light">' . e($row->grade->name) . '</span>';
                if ($row->classroom) {
                    $target .= ' <i class="las la-angle-left tx-10"></i> <span class="badge badge-light">' . e($row->classroom->name) . '</span>';
                }
                return $target;
            })
            ->addColumn('actions', function ($row) {
                return view('admin.finance.fees.partials.actions', ['fee' => $row])->render();
            })
            ->rawColumns(['title', 'amount', 'category', 'academic_target', 'actions'])
            ->make(true);
    }

    public function store(array $data): Fee
    {
        return Fee::create($data);
    }

    public function update(Fee $fee, array $data): Fee
    {
        $fee->update($data);
        return $fee;
    }

    public function deleteFee(Fee $fee): bool
    {
        // *note*: Here we should implement a check here to prevent deletion if the fee is linked to any "Student Invoice".
        return $fee->delete();
    }

    public function getLookups()
    {
        return [
            'grades'        => Grade::all(),
            'academicYears' => AcademicYear::orderBy('name')->get(),
            'feeCategories' => FeeCategory::all(),
        ];
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query->when(!empty($filters['fee_category_id']), fn($q) => $q->where('fee_category_id', $filters['fee_category_id']));
        $query->when(!empty($filters['academic_year_id']), fn($q) => $q->where('academic_year_id', $filters['academic_year_id']));
        $query->when(!empty($filters['grade_id']), fn($q) => $q->where('grade_id', $filters['grade_id']));

        return $query->latest();
    }
}
