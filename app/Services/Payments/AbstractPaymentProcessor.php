<?php

namespace App\Services\Payments;

use App\Contracts\PaymentProcessorInterface;
use App\DTOs\PaymentResult;
use App\Models\Finance\PaymentGateway;
use Illuminate\Support\Str;

abstract class AbstractPaymentProcessor implements PaymentProcessorInterface
{
    public function settingsSchema(): array
    {
        return [];
    }

    public function validateSettings(array $settings): bool
    {
        return true;
    }

    public function validatePayment(array $paymentData): bool
    {
        return true;
    }

    public function calculateSurcharge(float $amount, PaymentGateway $gateway): float
    {
        if ($gateway->surcharge_percentage <= 0) {
            return 0.00;
        }

        return round($amount * ($gateway->surcharge_percentage / 100), 2);
    }

    public function verifyCallback(array $payload, PaymentGateway $gateway): PaymentResult
    {
        throw new \BadMethodCallException(
            'Processor [' . static::class . '] does not support callback verification (offline gateway).'
        );
    }

    public function generateTransactionReference(PaymentGateway $gateway): string
    {
        return strtoupper($gateway->code) . '-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
    }

    public function isOnline(): bool
    {
        return false;
    }
}
