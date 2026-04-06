<?php

namespace App\Services\Payments;

use App\DTOs\PaymentResult;
use App\Models\Finance\PaymentGateway;
use Illuminate\Support\Facades\Validator;

class BankTransferProcessor extends AbstractPaymentProcessor
{
    public function settingsSchema(): array
    {
        return [
            'bank_name'      => ['type' => 'string', 'required' => true, 'label' => 'Bank Name'],
            'account_number' => ['type' => 'string', 'required' => true, 'label' => 'Account Number'],
            'iban'           => ['type' => 'string', 'required' => false, 'label' => 'IBAN'],
        ];
    }

    public function validateSettings(array $settings): bool
    {
        $rules = [];
        foreach ($this->settingsSchema() as $key => $schema) {
            $rules["settings.{$key}"] = $schema['required'] ? 'required|string' : 'nullable|string';
        }

        Validator::make(['settings' => $settings], $rules)->validate();

        return true;
    }

    public function validatePayment(array $paymentData): bool
    {
        Validator::make($paymentData, [
            'transaction_id' => 'required|string|max:255',
        ], [
            'transaction_id.required' => trans('admin.Finance.messages.failed.bank_transfer_ref_required'),
        ])->validate();

        return true;
    }

    public function initiatePayment(array $paymentData, PaymentGateway $gateway): PaymentResult
    {
        $surcharge = $this->calculateSurcharge($paymentData['paid_amount'], $gateway);
        $totalCharged = $paymentData['paid_amount'] + $surcharge;
        $reference = $paymentData['transaction_id'];

        return PaymentResult::successful(
            transactionReference: $reference,
            amountCharged: $totalCharged,
            surchargeAmount: $surcharge,
            message: 'Bank transfer recorded.',
        );
    }
}
