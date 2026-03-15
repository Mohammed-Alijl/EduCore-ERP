<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Finance\ReceiptRequest;
use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\Invoice;
use App\Models\Receipt;
use App\Services\ReceiptService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class ReceiptController extends Controller implements HasMiddleware
{
    public function __construct(protected readonly ReceiptService $receiptService) {}

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
        return view('admin.finance.receipts.index', [
            'grades'        => Grade::select('id', 'name')->orderBy('name')->get(),
            'academicYears' => AcademicYear::select('id', 'name')->orderByDesc('starts_at')->get(),
            'invoices'      => Invoice::with('student')->select('id', 'student_id', 'amount')->latest()->get(),
        ]);
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
                'message' => trans('admin.finance.receipts.messages.success.store'),
            ]);
        } catch (\Exception $e) {
            Log::error('Receipt creation failed: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => trans('admin.finance.receipts.messages.failed.store'),
            ], 500);
        }
    }

    public function destroy(Receipt $receipt)
    {
        try {
            $this->receiptService->deleteReceipt($receipt);
            return response()->json([
                'status'  => 'success',
                'message' => trans('admin.finance.receipts.messages.success.delete'),
            ]);
        } catch (\Exception $e) {
            Log::error('Receipt deletion failed: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => trans('admin.finance.receipts.messages.failed.delete'),
            ], 500);
        }
    }

    public function print(Receipt $receipt)
    {
        $receipt->load(['student', 'invoice.fee.feeCategory', 'grade', 'classroom', 'academicYear']);

        return view('admin.finance.receipts.print', compact('receipt'));
    }
}
