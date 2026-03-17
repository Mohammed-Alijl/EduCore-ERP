<?php

namespace App\Contracts;

use App\DTOs\PaymentResult;
use App\Models\PaymentGateway;

interface PaymentProcessorInterface
{
    /**
     * Return the schema for this gateway's required settings.
     *
     * @return array<string, array{type: string, required: bool, label: string}>
     */
    public function settingsSchema(): array;

    /**
     * Validate the gateway-specific settings stored in the DB.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateSettings(array $settings): bool;

    /**
     * Validate payment-specific data before processing.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validatePayment(array $paymentData): bool;

    /**
     * Calculate the surcharge for a given amount.
     *
     * @return float The surcharge amount
     */
    public function calculateSurcharge(float $amount, PaymentGateway $gateway): float;

    /**
     * Initiate the payment.
     *
     * For offline gateways (Cash, BankTransfer): processes immediately and returns a successful result.
     * For online gateways (Stripe, PayTabs): returns a pending result with redirect_url.
     */
    public function initiatePayment(array $paymentData, PaymentGateway $gateway): PaymentResult;

    /**
     * Verify a callback/webhook from an online payment gateway.
     *
     * Called when the gateway posts back (webhook or return URL).
     *
     * @throws \BadMethodCallException if called on an offline processor
     */
    public function verifyCallback(array $payload, PaymentGateway $gateway): PaymentResult;

    /**
     * Generate a transaction reference.
     */
    public function generateTransactionReference(PaymentGateway $gateway): string;

    /**
     * Whether this processor supports online/real-time payment.
     */
    public function isOnline(): bool;
}
