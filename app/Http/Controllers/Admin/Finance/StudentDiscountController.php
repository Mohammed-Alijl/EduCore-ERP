<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Finance\StudentDiscountRequest;
use App\Models\StudentDiscount;
use App\Services\Finance\StudentDiscountService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class StudentDiscountController extends Controller implements HasMiddleware
{
    public function __construct(
        protected readonly StudentDiscountService $discountService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_studentDiscounts', only: ['index', 'datatable']),
            new Middleware('permission:create_studentDiscounts', only: ['store']),
            new Middleware('permission:delete_studentDiscounts', only: ['destroy']),
        ];
    }

    public function index()
    {
        $lookups = $this->discountService->getLookups();

        return view('admin.Finance.student_discounts.index', $lookups);
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->discountService->getDiscountsQuery($request->all());

            return $this->discountService->datatable($query);
        }

        abort(403, 'Unauthorized action.');
    }

    public function store(StudentDiscountRequest $request)
    {
        try {
            $this->discountService->createDiscount($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Finance.messages.success.student_discount_created'),
            ]);
        } catch (\Exception $e) {
            Log::error('Student Discount creation failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => __('admin.Finance.messages.failed.student_discount_created'),
            ], 500);
        }
    }

    public function destroy(StudentDiscount $studentDiscount)
    {
        try {
            $deleted = $this->discountService->deleteDiscount($studentDiscount);

            if ($deleted) {
                return response()->json([
                    'status' => 'success',
                    'message' => __('admin.Finance.messages.success.student_discount_deleted'),
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => __('admin.Finance.messages.failed.student_discount_delete'),
            ], 400);
        } catch (\Exception $e) {
            Log::error('Student Discount deletion failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => __('admin.Finance.messages.failed.student_discount_delete'),
            ], 500);
        }
    }
}
