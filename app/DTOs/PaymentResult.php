<?php

namespace App\DTOs;

class PaymentResult
{
    public function __construct(
        public readonly bool $success,
        public readonly string $transactionReference,
        public readonly string $message,
        public readonly float $amountCharged,
        public readonly float $surchargeAmount = 0.00,
        public readonly array $metadata = [],
        public readonly ?string $redirectUrl = null,
        public readonly bool $isPending = false,
    ) {}

    public static function successful(
        string $transactionReference,
        float $amountCharged,
        float $surchargeAmount = 0.00,
        string $message = 'Payment processed successfully.',
        array $metadata = [],
        ?string $redirectUrl = null,
    ): self {
        return new self(
            success: true,
            transactionReference: $transactionReference,
            message: $message,
            amountCharged: $amountCharged,
            surchargeAmount: $surchargeAmount,
            metadata: $metadata,
            redirectUrl: $redirectUrl,
            isPending: false,
        );
    }

    public static function pending(
        string $redirectUrl,
        string $message = 'Redirecting to payment gateway...',
        array $metadata = [],
    ): self {
        return new self(
            success: false,
            transactionReference: '',
            message: $message,
            amountCharged: 0.00,
            surchargeAmount: 0.00,
            metadata: $metadata,
            redirectUrl: $redirectUrl,
            isPending: true,
        );
    }

    public static function failed(string $message, array $metadata = []): self
    {
        return new self(
            success: false,
            transactionReference: '',
            message: $message,
            amountCharged: 0.00,
            surchargeAmount: 0.00,
            metadata: $metadata,
        );
    }
}
