<?php

namespace App\Services\Payments;

use App\DTOs\PaymentResult;
use App\Models\Finance\PaymentGateway;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;
use UnexpectedValueException;

class StripeProcessor extends AbstractPaymentProcessor
{
    public function settingsSchema(): array
    {
        return [
            'publishable_key' => ['type' => 'string', 'required' => true, 'label' => 'Publishable Key'],
            'secret_key' => ['type' => 'string', 'required' => true, 'label' => 'Secret Key'],
            'webhook_secret' => ['type' => 'string', 'required' => true, 'label' => 'Webhook Secret'],
        ];
    }

    public function validateSettings(array $settings): bool
    {
        Validator::make(['settings' => $settings], [
            'settings.publishable_key' => 'required|string|starts_with:pk_',
            'settings.secret_key' => 'required|string|starts_with:sk_',
            'settings.webhook_secret' => 'required|string|starts_with:whsec_',
        ])->validate();

        return true;
    }

    public function isOnline(): bool
    {
        return true;
    }

    public function initiatePayment(array $paymentData, PaymentGateway $gateway): PaymentResult
    {
        $surcharge = $this->calculateSurcharge($paymentData['paid_amount'], $gateway);
        $totalCharged = $paymentData['paid_amount'] + $surcharge;

        $amountInCents = (int) round($totalCharged * 100);

        try {
            Stripe::setApiKey($gateway->settings['secret_key']);

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => strtolower($paymentData['currency_code']),
                        'product_data' => [
                            'name' => $paymentData['description'] ?? 'Pay the invoice',
                        ],
                        'unit_amount' => $amountInCents,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'payment_intent_data' => [
                    'metadata' => [
                        'student_id' => $paymentData['student_id'] ?? null,
                        'academic_year_id' => $paymentData['academic_year_id'] ?? null,
                        'surcharge' => $surcharge,
                        'original_amount' => $paymentData['paid_amount'],
                    ],
                ],
                'success_url' => route('admin.Finance.receipts.index').'?status=success',
                'cancel_url' => route('admin.Finance.receipts.index').'?status=cancelled',
            ]);

            return PaymentResult::pending(
                redirectUrl: $session->url,
                message: 'we are redirecting you to Stripe to complete the payment.',
                metadata: ['session_id' => $session->id]
            );
        } catch (\Exception $e) {
            Log::error('Stripe payment initiation failed: '.$e->getMessage());

            return PaymentResult::failed(
                message: 'Failed to initiate payment with Stripe: '.$e->getMessage(),
                metadata: ['exception' => $e->getMessage()]
            );
        }
    }

    public function verifyCallback(array $payload, PaymentGateway $gateway): PaymentResult
    {
        $endpointSecret = $gateway->settings['webhook_secret'];
        $signature = $payload['signature'] ?? '';
        $rawPayload = $payload['raw_body'] ?? '';

        try {
            $event = Webhook::constructEvent($rawPayload, $signature, $endpointSecret);
        } catch (UnexpectedValueException|SignatureVerificationException $e) {
            Log::error('Stripe Webhook Signature Failed: '.$e->getMessage());

            return PaymentResult::failed('Failed to verify Stripe webhook signature.');
        }

        if ($event->type !== 'payment_intent.succeeded') {
            Log::info("Stripe webhook event acknowledged but not processed: {$event->type}");

            return PaymentResult::successful(
                transactionReference: '',
                amountCharged: 0.0,
                message: "Event type acknowledged: {$event->type}",
            );
        }

        $paymentIntent = $event->data->object;

        $metadata = $paymentIntent->metadata->toArray();
        $surcharge = (float) ($metadata['surcharge'] ?? 0.00);

        $totalCharged = $paymentIntent->amount_received / 100;

        return PaymentResult::successful(
            transactionReference: $paymentIntent->id,
            amountCharged: $totalCharged,
            surchargeAmount: $surcharge,
            message: 'The payment has been confirmed successfully via Stripe.',
            metadata: $metadata
        );
    }
}
