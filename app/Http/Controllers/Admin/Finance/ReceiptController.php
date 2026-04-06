<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Finance\ReceiptRequest;
use App\DTOs\PaymentResult;
use App\Models\Finance\Receipt;
use App\Services\Finance\ReceiptService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class ReceiptController extends Controller implements HasMiddleware
{
    public function __construct(
        protected readonly ReceiptService $receiptService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_receipts', only: ['index', 'datatable']),
            new Middleware('permission:create_receipts', only: ['store']),
            new Middleware('permission:delete_receipts', only: ['destroy']),
            new Middleware('permission:print_receipts', only: ['print']),
        ];
    }

    public function index()
    {
        $lookups = $this->receiptService->getLookups();

        return view('admin.Finance.receipts.index', $lookups);
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->receiptService->getReceiptsQuery($request->all());
            return $this->receiptService->datatable($query);
        }

        abort(403, 'Unauthorized action.');
    }

    public function store(ReceiptRequest $request)
    {
        try {
            $result = $this->receiptService->createReceipt($request->validated());

            // Online gateway — return redirect URL for the frontend
            if ($result instanceof PaymentResult && $result->isPending) {
                return response()->json([
                    'status'       => 'pending',
                    'message'      => $result->message,
                    'redirect_url' => $result->redirectUrl,
                ]);
            }

            return response()->json([
                'status'  => 'success',
                'message' => trans('admin.Finance.messages.success.receipt_created'),
            ]);
        } catch (\Exception $e) {
            Log::error('Receipt creation failed: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage() ?? trans('admin.Finance.messages.failed.receipt_created'),
            ],500);
        }
    }

    public function destroy(Receipt $receipt)
    {
        try {
            $deleted = $this->receiptService->deleteReceipt($receipt);

            if ($deleted) {
                return response()->json([
                    'status'  => 'success',
                    'message' => trans('admin.Finance.messages.success.receipt_deleted')
                ], 200);
            }

            return response()->json([
                'status'  => 'error',
                'message' => trans('admin.Finance.messages.failed.receipt_delete')
            ], 400);
        } catch (\Exception $e) {
            Log::error('Receipt deletion failed: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => trans('admin.Finance.messages.failed.receipt_delete')
            ], 500);
        }
    }

    public function print(Receipt $receipt)
    {
        $receipt->load(['student.grade', 'student.classroom', 'academicYear', 'currency', 'paymentGateway']);

        return view('admin.Finance.receipts.print', compact('receipt'));
    }
}
