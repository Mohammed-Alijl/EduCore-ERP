<?php

namespace App\Services;

use App\Models\Fee;
use App\Models\FeeCategory;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;

class FeeCategoryService
{
    public function getFeeCategoriesQuery(): Builder
    {
        return FeeCategory::query()->latest();
    }

    public function datatable($query)
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('title', fn($row) => '<strong>' . e($row->title) . '</strong><br><small class="text-muted">' . e(str($row->description)->limit(30)) . '</small>')
            ->addColumn('actions', function ($row) {
                return view('admin.finance.fee_categories.partials.actions', ['feeCategory' => $row])->render();
            })
            ->rawColumns(['title', 'actions'])
            ->make(true);
    }

    public function store(array $data): FeeCategory
    {
        return FeeCategory::create($data);
    }

    public function update(FeeCategory $feeCategory, array $data): FeeCategory
    {
        $feeCategory->update($data);
        return $feeCategory;
    }

    public function deleteFeeCategory(FeeCategory $feeCategory): bool
    {
        // Check if there are any fees attached to this category
        if ($feeCategory->fees()->exists()) {
            throw new \Exception(trans('admin.finance.messages.failed.category_in_use'));
        }

        return $feeCategory->delete();
    }
}
