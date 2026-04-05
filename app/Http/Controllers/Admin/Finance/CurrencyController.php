<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Finance\CurrencyRequest;
use App\Models\Currency;
use App\Services\Finance\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class CurrencyController extends Controller implements HasMiddleware
{
    public function __construct(
        protected readonly CurrencyService $currencyService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_currencies',   only: ['index', 'datatable']),
            new Middleware('permission:create_currencies', only: ['store']),
            new Middleware('permission:edit_currencies',   only: ['update']),
            new Middleware('permission:delete_currencies', only: ['destroy']),
        ];
    }

    public function index()
    {
        return view('admin.Finance.currencies.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->currencyService->getCurrenciesQuery();
            return $this->currencyService->datatable($query);
        }

        abort(403, 'Unauthorized action.');
    }

    public function store(CurrencyRequest $request)
    {
        try {
            $this->currencyService->store($request->validated());

            return response()->json([
                'status'  => 'success',
                'message' => trans('admin.Finance.messages.success.currency_created'),
            ], 201);
        } catch (\Exception $e) {
            Log::error('Currency creation failed: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => trans('admin.Finance.messages.failed.currency_created'),
            ], 500);
        }
    }

    public function update(CurrencyRequest $request, Currency $currency)
    {
        try {
            $this->currencyService->update($currency, $request->validated());

            return response()->json([
                'status'  => 'success',
                'message' => trans('admin.Finance.messages.success.currency_updated'),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Currency update failed: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Currency $currency)
    {
        try {
            $deleted = $this->currencyService->deleteCurrency($currency);

            if ($deleted) {
                return response()->json([
                    'status'  => 'success',
                    'message' => trans('admin.Finance.messages.success.currency_deleted'),
                ], 200);
            }

            return response()->json([
                'status'  => 'error',
                'message' => trans('admin.Finance.messages.failed.currency_deleted'),
            ], 400);
        } catch (\Exception $e) {
            Log::error('Currency deletion failed: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
