<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Finance\ReceiptRequest;
use App\Models\Receipt;
use App\Services\ReceiptService;
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

        return view('admin.finance.receipts.index', $lookups);
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
            $this->receiptService->createReceipt($request->validated());

            return response()->json([
                'status'  => 'success',
                'message' => trans('admin.finance.messages.success.receipt_created')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => trans('admin.finance.messages.failed.receipt_created')
            ]);
            Log::error('Receipt creation failed: ' . $e->getMessage());
        }
    }

    public function destroy(Receipt $receipt)
    {
        try {
            $deleted = $this->receiptService->deleteReceipt($receipt);

            if ($deleted) {
                return response()->json([
                    'status'  => 'success',
                    'message' => trans('admin.finance.messages.success.receipt_deleted')
                ], 200);
            }

            return response()->json([
                'status'  => 'error',
                'message' => trans('admin.finance.messages.failed.receipt_delete')
            ], 400);
        } catch (\Exception $e) {
            Log::error('Receipt deletion failed: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => trans('admin.finance.messages.failed.receipt_delete')
            ], 500);
        }
    }

    public function print(Receipt $receipt)
    {
        $receipt->load(['student.grade', 'student.classroom', 'academicYear', 'currency', 'paymentGateway']);

        return view('admin.finance.receipts.print', compact('receipt'));
    }
}
