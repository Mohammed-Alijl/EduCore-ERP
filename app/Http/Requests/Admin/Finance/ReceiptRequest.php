<?php

namespace App\Http\Requests\Admin\Finance;

use App\Models\PaymentGateway;
use App\Services\Payments\PaymentGatewayManager;
use Illuminate\Foundation\Http\FormRequest;

class ReceiptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->user()->can('create_receipts');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id'         => 'required|integer|exists:students,id',
            'academic_year_id'   => 'required|integer|exists:academic_years,id',
            'payment_gateway_id' => [
                'required',
                'integer',
                'exists:payment_gateways,id',
                function ($attribute, $value, $fail) {
                    $gateway = PaymentGateway::find($value);
                    if ($gateway && app(PaymentGatewayManager::class)->resolveFromGateway($gateway)->isOnline()) {
                        $fail(trans('admin.finance.messages.failed.online_gateway_not_allowed'));
                    }
                },
            ],
            'paid_amount'        => 'required|numeric|min:10.0|max:10000.0',
            'currency_code'      => 'required|string|size:3|exists:currencies,code',
            'transaction_id'     => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $gateway = PaymentGateway::find(request()->input('payment_gateway_id'));
                    if ($gateway && $gateway->code === 'bank_transfer' && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => trans('admin.finance.receipts.fields.transaction_id')]));
                    }
                },
            ],
            'date'               => 'nullable|date',
            'description'        => 'nullable|string|max:1000',
        ];
    }
}
