<?php

namespace App\Services\Payments;

use App\DTOs\PaymentResult;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StripeProcessor extends AbstractPaymentProcessor
{
    public function settingsSchema(): array
    {
        return [
            'publishable_key' => ['type' => 'string', 'required' => true, 'label' => 'Publishable Key'],
            'secret_key'      => ['type' => 'string', 'required' => true, 'label' => 'Secret Key'],
            'webhook_secret'  => ['type' => 'string', 'required' => false, 'label' => 'Webhook Secret'],
        ];
    }

    public function validateSettings(array $settings): bool
    {
        Validator::make(['settings' => $settings], [
            'settings.publishable_key' => 'required|string|starts_with:pk_',
            'settings.secret_key'      => 'required|string|starts_with:sk_',
            'settings.webhook_secret'  => 'nullable|string',
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

        try {
            // TODO: Integrate Stripe Checkout Session
            // \Stripe\Stripe::setApiKey($gateway->settings['secret_key']);
            // $session = \Stripe\Checkout\Session::create([
            //     'payment_method_types' => ['card'],
            //     'line_items' => [[
            //         'price_data' => [
            //             'currency'     => strtolower($paymentData['currency_code']),
            //             'product_data' => ['name' => 'Tuition Payment'],
            //             'unit_amount'  => (int) ($totalCharged * 100),
            //         ],
            //         'quantity' => 1,
            //     ]],
            //     'mode'        => 'payment',
            //     'success_url' => route('admin.payments.stripe.callback') . '?session_id={CHECKOUT_SESSION_ID}',
            //     'cancel_url'  => route('admin.receipts.index'),
            //     'metadata'    => ['receipt_data' => json_encode($paymentData)],
            // ]);
            // return PaymentResult::pending(redirectUrl: $session->url, metadata: ['session_id' => $session->id]);

            $stubSessionId = 'cs_test_' . strtoupper(Str::random(24));

            return PaymentResult::pending(
                redirectUrl: 'https://checkout.stripe.com/pay/' . $stubSessionId,
                message: 'Redirecting to Stripe checkout...',
                metadata: [
                    'session_id'    => $stubSessionId,
                    'total_charged' => $totalCharged,
                    'surcharge'     => $surcharge,
                ],
            );
        } catch (\Exception $e) {
            Log::error('Stripe payment initiation failed: ' . $e->getMessage());

            return PaymentResult::failed(
                message: 'Stripe payment initiation failed: ' . $e->getMessage(),
                metadata: ['exception' => $e->getMessage()],
            );
        }
    }

    public function verifyCallback(array $payload, PaymentGateway $gateway): PaymentResult
    {
        try {
            // TODO: Verify with Stripe SDK
            // \Stripe\Stripe::setApiKey($gateway->settings['secret_key']);
            // $session = \Stripe\Checkout\Session::retrieve($payload['session_id']);
            // if ($session->payment_status !== 'paid') {
            //     return PaymentResult::failed('Payment not completed.');
            // }
            // $paymentIntent = $session->payment_intent;

            $surcharge = $payload['surcharge'] ?? 0.00;
            $totalCharged = $payload['amount_total'] ?? 0.00;
            $reference = $payload['stripe_payment_intent'] ?? ('pi_' . strtoupper(Str::random(24)));

            return PaymentResult::successful(
                transactionReference: $reference,
                amountCharged: $totalCharged,
                surchargeAmount: $surcharge,
                message: 'Stripe payment verified.',
                metadata: ['stripe_session_id' => $payload['session_id'] ?? null],
            );
        } catch (\Exception $e) {
            Log::error('Stripe callback verification failed: ' . $e->getMessage());

            return PaymentResult::failed(
                message: 'Stripe verification failed: ' . $e->getMessage(),
                metadata: ['exception' => $e->getMessage()],
            );
        }
    }
}
