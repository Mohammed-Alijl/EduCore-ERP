<?php

namespace App\Services\Payments;

use App\Contracts\PaymentProcessorInterface;
use App\Models\PaymentGateway;
use InvalidArgumentException;

class PaymentGatewayManager
{
    /** @var array<string, PaymentProcessorInterface> */
    private array $resolvedProcessors = [];

    /**
     * Resolve a processor by gateway code.
     *
     * @throws InvalidArgumentException
     */
    public function resolve(string $code): PaymentProcessorInterface
    {
        if (isset($this->resolvedProcessors[$code])) {
            return $this->resolvedProcessors[$code];
        }

        $processors = config('payment-gateways.processors', []);

        if (!isset($processors[$code])) {
            throw new InvalidArgumentException("No payment processor registered for code: [{$code}]");
        }

        $processorInfo = $processors[$code];
        $processorClass = is_array($processorInfo) ? ($processorInfo['class'] ?? null) : $processorInfo;

        if (!$processorClass || !class_exists($processorClass)) {
            throw new InvalidArgumentException("Payment processor class not found for code: [{$code}]");
        }

        $processor = app($processorClass);

        if (!$processor instanceof PaymentProcessorInterface) {
            throw new InvalidArgumentException(
                "Class [{$processorClass}] must implement PaymentProcessorInterface."
            );
        }

        $this->resolvedProcessors[$code] = $processor;

        return $processor;
    }

    /**
     * Resolve a processor from a PaymentGateway model instance.
     */
    public function resolveFromGateway(PaymentGateway $gateway): PaymentProcessorInterface
    {
        return $this->resolve($gateway->code);
    }

    /**
     * Get all registered processor codes.
     *
     * @return array<string, class-string>
     */
    public function getRegisteredProcessors(): array
    {
        return config('payment-gateways.processors', []);
    }

    /**
     * Check whether a code has a registered processor.
     */
    public function hasProcessor(string $code): bool
    {
        return array_key_exists($code, config('payment-gateways.processors', []));
    }
}
