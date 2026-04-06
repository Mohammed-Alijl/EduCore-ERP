<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Finance\PaymentGatewayRequest;
use App\Models\Finance\PaymentGateway;
use App\Services\Finance\PaymentGatewayService;
use App\Services\Payments\PaymentGatewayManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class PaymentGatewayController extends Controller implements HasMiddleware
{
    public function __construct(
        protected readonly PaymentGatewayService $paymentGatewayService,
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_payment_gateways', only: ['index']),
            new Middleware('permission:create_payment_gateways', only: ['activate']),
            new Middleware('permission:edit_payment_gateways', only: ['update', 'toggleStatus']),
            new Middleware('permission:create_payment_gateways|edit_payment_gateways', only: ['settingsSchema']),
        ];
    }

    public function index()
    {
        $gateways = $this->paymentGatewayService->getGatewaysForManagement();

        return view('admin.Finance.payment_gateways.index', compact('gateways'));
    }

    public function activate(Request $request)
    {
        $validatedData = $request->validate([
            'code'                 => ['required', 'string', 'max:50', 'regex:/^[a-z_]+$/', 'unique:payment_gateways,code'],
            'name'                 => ['required', 'array'],
            'name.ar'              => ['required', 'string', 'max:100'],
            'name.en'              => ['required', 'string', 'max:100'],
            'settings'             => ['nullable', 'array'],
            'settings.*'           => ['nullable', 'string', 'max:500'],
            'surcharge_percentage' => ['nullable', 'numeric', 'min:0', 'max:99.99'],
            'status'               => ['nullable', 'boolean'],
        ]);

        try {
            $this->paymentGatewayService->activateGateway($request->input('code'), $validatedData);

            return response()->json([
                'status'  => 'success',
                'message' => trans('admin.Finance.messages.success.payment_gateway_activated'),
            ]);
        } catch (\Exception $e) {
            Log::error('Payment gateway activation failed: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage() ?? trans('admin.Finance.messages.failed.payment_gateway_created'),
            ], 500);
        }
    }

    public function update(PaymentGatewayRequest $request, PaymentGateway $paymentGateway)
    {
        try {
            $this->paymentGatewayService->update($paymentGateway, $request->validated());

            return response()->json([
                'status'  => 'success',
                'message' => trans('admin.Finance.messages.success.payment_gateway_updated'),
            ]);
        } catch (\Exception $e) {
            Log::error('Payment gateway update failed: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => trans('admin.Finance.messages.failed.payment_gateway_updated'),
            ], 500);
        }
    }

    public function toggleStatus(PaymentGateway $paymentGateway)
    {
        try {
            $gateway = $this->paymentGatewayService->toggleStatus($paymentGateway);

            return response()->json([
                'status'  => 'success',
                'message' => $gateway->status
                    ? trans('admin.Finance.messages.success.payment_gateway_enabled')
                    : trans('admin.Finance.messages.success.payment_gateway_disabled'),
                'new_status' => $gateway->status,
            ]);
        } catch (\Exception $e) {
            Log::error('Payment gateway toggle failed: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function settingsSchema(Request $request)
    {
        $code = $request->input('code');

        if (!$code) {
            return response()->json(['schema' => []]);
        }

        $manager = app(PaymentGatewayManager::class);

        if (!$manager->hasProcessor($code)) {
            return response()->json(['schema' => []]);
        }

        $processor = $manager->resolve($code);

        return response()->json(['schema' => $processor->settingsSchema()]);
    }
}
