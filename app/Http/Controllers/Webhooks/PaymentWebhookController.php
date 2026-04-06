<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Finance\Currency;
use App\Models\Finance\PaymentGateway;
use App\Models\Finance\Receipt;
use App\Models\Users\Student;
use App\Services\Payments\PaymentGatewayManager;
use App\Services\Finance\ReceiptService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function __construct(
        private readonly PaymentGatewayManager $gatewayManager,
        private readonly ReceiptService $receiptService,
    ) {}

    public function __invoke(Request $request, PaymentGateway $gateway): JsonResponse
    {
        Log::info("Webhook initiated for gateway: {$gateway->code}", ['ip' => $request->ip()]);

        $processor = $this->gatewayManager->resolveFromGateway($gateway);

        if (! $processor->isOnline()) {
            Log::warning("Webhook hit for offline gateway: {$gateway->code}");

            return response()->json(['message' => 'Offline gateways do not support webhooks.'], 400);
        }

        $payload = [
            'raw_body' => $request->getContent(),
            'headers' => $request->headers->all(),
            'signature' => $request->header('Stripe-Signature') ?? $request->header('Signature') ?? '',
        ];

        $result = $processor->verifyCallback($payload, $gateway);

        if (! $result->success) {
            Log::warning("Webhook verification failed for {$gateway->code}: {$result->message}");

            return response()->json(['message' => $result->message], 400);
        }

        if (empty($result->transactionReference)) {
            return response()->json(['message' => $result->message], 200);
        }

        if (Receipt::where('transaction_id', $result->transactionReference)->exists()) {
            Log::info("Duplicate webhook ignored for TXN: {$result->transactionReference}");

            return response()->json(['message' => 'Already processed'], 200);
        }

        try {
            $this->createReceiptFromWebhook($result, $gateway);

            Log::info("Webhook processed successfully for TXN: {$result->transactionReference}");

            return response()->json(['message' => 'Webhook handled successfully'], 200);

        } catch (\Exception $e) {
            Log::error('Webhook DB Transaction Failed: '.$e->getMessage());

            return response()->json(['message' => 'Internal server error processing receipt.'], 500);
        }
    }

    /**
     * create receipt from webhook
     */
    private function createReceiptFromWebhook(\App\DTOs\PaymentResult $result, PaymentGateway $gateway): void
    {
        $metadata = $result->metadata;

        $student = Student::findOrFail($metadata['student_id']);
        $currencyCode = $metadata['currency_code'] ?? null;
        $currency = $currencyCode
            ? Currency::where('code', $currencyCode)->firstOrFail()
            : Currency::where('is_default', true)->firstOrFail();

        $data = [
            'student_id' => $metadata['student_id'],
            'academic_year_id' => $metadata['academic_year_id'],
            'payment_gateway_id' => $gateway->id,
            'paid_amount' => (float) ($metadata['original_amount'] ?? $result->amountCharged),
            'currency_code' => $currency->code,
            'date' => now()->toDateString(),
            'description' => "Automated payment via {$gateway->name} - Transaction ID: {$result->transactionReference}",
        ];

        $this->receiptService->createReceiptFromResult($data, $result, $student, $currency, $gateway);
    }
}
