<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Finance\FeeRequest;
use App\Models\Fee;
use App\Services\Finance\FeeService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class FeeController extends Controller implements HasMiddleware
{
    public function __construct(
        protected readonly FeeService $feeService,
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_fees', only: ['index', 'datatable']),
            new Middleware('permission:create_fees', only: ['create', 'store']),
            new Middleware('permission:edit_fees', only: ['edit', 'update']),
            new Middleware('permission:delete_fees', only: ['destroy']),
        ];
    }

    public function index()
    {
        $lookups = $this->feeService->getLookups();

        return view('admin.Finance.fees.index', compact('lookups'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->feeService->getFeesQuery($request->all());
            return $this->feeService->datatable($query);
        }

        abort(403, 'Unauthorized action.');
    }

    public function store(FeeRequest $request)
    {
        try {
            $fee = $this->feeService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Finance.messages.success.store'),
            ], 201);
        } catch (\Exception $e) {
            Log::error('Fee creation failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Finance.messages.failed.store')
            ], 500);
        }
    }

    public function update(FeeRequest $request, Fee $fee)
    {
        try {
            $updatedFee = $this->feeService->update($fee, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Finance.messages.success.update')
            ], 200);
        } catch (\Exception $e) {
            Log::error('Fee update failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Finance.messages.failed.update')
            ], 500);
        }
    }

    public function destroy(Fee $fee)
    {
        try {
            $deleted = $this->feeService->deleteFee($fee);

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
            Log::error('Fee deletion failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Finance.messages.failed.delete')
            ], 500);
        }
    }
}
