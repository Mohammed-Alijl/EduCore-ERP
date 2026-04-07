<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Finance\FeeCategoryRequest;
use App\Models\Finance\FeeCategory;
use App\Services\Finance\FeeCategoryService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class FeeCategoryController extends Controller implements HasMiddleware
{
    public function __construct(
        protected readonly FeeCategoryService $feeCategoryService,
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_fee_categories', only: ['index', 'datatable']),
            new Middleware('permission:create_fee_categories', only: ['create', 'store']),
            new Middleware('permission:edit_fee_categories', only: ['edit', 'update']),
            new Middleware('permission:delete_fee_categories', only: ['destroy']),
        ];
    }

    public function index()
    {
        return view('admin.Finance.fee_categories.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->feeCategoryService->getFeeCategoriesQuery();
            return $this->feeCategoryService->datatable($query);
        }

        abort(403, 'Unauthorized action.');
    }

    public function store(FeeCategoryRequest $request)
    {
        try {
            $feeCategory = $this->feeCategoryService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Finance.messages.success.store'),
            ], 201);
        } catch (\Exception $e) {
            Log::error('Fee category creation failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Finance.messages.failed.store')
            ], 500);
        }
    }

    public function update(FeeCategoryRequest $request, FeeCategory $feeCategory)
    {
        try {
            $updatedFeeCategory = $this->feeCategoryService->update($feeCategory, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Finance.messages.success.update')
            ], 200);
        } catch (\Exception $e) {
            Log::error('Fee category update failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Finance.messages.failed.update')
            ], 500);
        }
    }

    public function destroy(FeeCategory $feeCategory)
    {
        try {
            $deleted = $this->feeCategoryService->deleteFeeCategory($feeCategory);

            if ($deleted) {
                return response()->json([
                    'status' => 'success',
                    'message' => trans('admin.Finance.messages.success.delete')
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Finance.messages.failed.delete')
            ], 400);
        } catch (\Exception $e) {
            Log::error('Fee category deletion failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?? trans('admin.Finance.messages.failed.delete')
            ], 500);
        }
    }
}
