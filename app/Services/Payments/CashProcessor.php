<?php

namespace App\Services\Payments;

use App\DTOs\PaymentResult;
use App\Models\PaymentGateway;

class CashProcessor extends AbstractPaymentProcessor
{
    public function initiatePayment(array $paymentData, PaymentGateway $gateway): PaymentResult
    {
        $surcharge = $this->calculateSurcharge($paymentData['paid_amount'], $gateway);
        $totalCharged = $paymentData['paid_amount'] + $surcharge;
        $reference = $this->generateTransactionReference($gateway);

        return PaymentResult::successful(
            transactionReference: $reference,
            amountCharged: $totalCharged,
            surchargeAmount: $surcharge,
            message: 'Cash payment recorded.',
        );
    }
}
