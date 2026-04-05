<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Finance\InvoiceRequest;
use App\Models\AcademicYear;
use App\Models\Fee;
use App\Models\Grade;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller implements HasMiddleware
{
    public function __construct(protected readonly InvoiceService $invoiceService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_invoices', only: ['index', 'datatable']),
            new Middleware('permission:create_invoices', only: ['store']),
            new Middleware('permission:delete_invoices', only: ['destroy']),
            new Middleware('permission:print_invoices', only: ['print']),
        ];
    }

    public function index()
    {
        return view('admin.Finance.invoices.index', [
            'fees' => Fee::select('id', 'title', 'amount')->orderBy('title')->get(),
            'grades' => Grade::select('id', 'name')->orderBy('name')->get(),
            'academicYears' => AcademicYear::select('id', 'name')->orderByDesc('starts_at')->get(),
        ]);
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->invoiceService->getInvoicesQuery($request->all());
            return $this->invoiceService->datatable($query);
        }
        abort(403, 'Unauthorized action.');
    }

    public function store(InvoiceRequest $request)
    {
        try {
            $this->invoiceService->createInvoice($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Finance.messages.success.invoice_created')
            ]);
        } catch (\Exception $e) {
            Log::error('Invoice creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', trans('admin.global.error_occurred'));
        }
    }

    public function destroy(Invoice $invoice)
    {
        try {
            $this->invoiceService->deleteInvoice($invoice);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Finance.messages.success.invoice_deleted')
            ], 200);
        } catch (\Exception $e) {
            Log::error('Invoice deletion failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Finance.messages.failed.invoice_delete')
            ], 500);
        }
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['student', 'fee.feeCategory', 'grade', 'classroom', 'academicYear']);

        return view('admin.Finance.invoices.print', compact('invoice'));
    }
}
