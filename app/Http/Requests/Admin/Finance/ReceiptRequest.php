<?php

namespace App\Http\Requests\Admin\Finance;

use Illuminate\Foundation\Http\FormRequest;

class ReceiptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->user()->can('create_receipts');
    }

    public function rules(): array
    {
        return [
            'invoice_id'     => 'required|integer|exists:invoices,id',
            'payment_method' => 'required|in:cash,bank_transfer,cheque,online',
            'description'    => 'nullable|string|max:500',
        ];
    }
}
