<?php

namespace App\Http\Requests\Admin\Finance;

use Illuminate\Foundation\Http\FormRequest;

class PaymentVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->user()->can('create_paymentVoucher');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'payment_gateway_id' => 'required|exists:payment_gateways,id',
            'currency_code' => 'required|exists:currencies,code',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'reference_number' => 'nullable|string|max:100',
            'description' => 'required|string|max:255',
        ];
    }
}
