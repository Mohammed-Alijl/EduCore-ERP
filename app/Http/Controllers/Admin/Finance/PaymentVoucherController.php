<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Finance\PaymentVoucherRequest;
use App\Models\PaymentVoucher;
use App\Services\Finance\PaymentVoucherService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class PaymentVoucherController extends Controller implements HasMiddleware
{
    public function __construct(
        protected readonly PaymentVoucherService $voucherService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_paymentVoucher', only: ['index', 'datatable']),
            new Middleware('permission:create_paymentVoucher', only: ['store']),
            new Middleware('permission:delete_paymentVoucher', only: ['destroy']),
            new Middleware('permission:print_paymentVoucher', only: ['print']),
        ];
    }

    public function index()
    {
        $lookups = $this->voucherService->getLookups();

        return view('admin.Finance.payment_vouchers.index', $lookups);
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->voucherService->getVouchersQuery($request->all());

            return $this->voucherService->datatable($query);
        }

        abort(403, 'Unauthorized action.');
    }

    public function store(PaymentVoucherRequest $request)
    {
        try {
            $this->voucherService->create($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Finance.messages.success.payment_voucher_created'),
            ]);
        } catch (\Exception $e) {
            Log::error('Payment Voucher creation failed: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => __('admin.Finance.messages.failed.payment_voucher_created'),
            ], 500);
        }
    }

    public function destroy(PaymentVoucher $paymentVoucher)
    {
        try {
            $deleted = $this->voucherService->delete($paymentVoucher);

            if ($deleted) {
                return response()->json([
                    'status' => 'success',
                    'message' => __('admin.Finance.messages.success.payment_voucher_deleted'),
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => __('admin.Finance.messages.failed.payment_voucher_delete'),
            ], 400);
        } catch (\Exception $e) {
            Log::error('Payment Voucher deletion failed: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => __('admin.Finance.messages.failed.payment_voucher_delete'),
            ], 500);
        }
    }

    public function print(PaymentVoucher $paymentVoucher)
    {
        $paymentVoucher->load(['student.grade', 'student.classroom', 'academicYear', 'paymentGateway']);

        return view('admin.Finance.payment_vouchers.print', compact('paymentVoucher'));
    }
}
