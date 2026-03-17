<?php

namespace App\Http\Requests\Admin\Finance;

use Illuminate\Foundation\Http\FormRequest;

class PaymentGatewayRequest extends FormRequest
{
    public function authorize(): bool
    {
        $admin = auth('admin')->user();
        return $admin->can('create_payment_gateways') || $admin->can('edit_payment_gateways');
    }

    public function rules(): array
    {
        return [
            'code'                 => ['sometimes', 'string', 'max:50', 'regex:/^[a-z_]+$/'],
            'name'                 => ['required', 'array'],
            'name.ar'              => ['required', 'string', 'max:100'],
            'name.en'              => ['required', 'string', 'max:100'],
            'settings'             => ['nullable', 'array'],
            'settings.*'           => ['nullable', 'string', 'max:500'],
            'surcharge_percentage' => ['nullable', 'numeric', 'min:0', 'max:99.99'],
            'status'               => ['nullable', 'boolean'],
        ];
    }
}
