<?php

namespace App\Http\Requests\Admin\Finance;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
{
    public function authorize(): bool
    {
        $admin = auth('admin')->user();
        return $admin->can('create_currencies') || $admin->can('edit_currencies');
    }

    public function rules(): array
    {
        $currencyId = $this->route('currency')?->id;

        return [
            'code'          => ['required', 'string', 'size:3', 'regex:/^[A-Za-z]+$/', 'unique:currencies,code,' . ($currencyId ?? 'NULL')],
            'name'          => ['required', 'array'],
            'name.ar'       => ['required', 'string', 'max:100'],
            'name.en'       => ['required', 'string', 'max:100'],
            'exchange_rate' => ['required', 'numeric', 'min:0.0001', 'max:999999'],
            'status'        => ['nullable', 'boolean'],
            'sort_order'    => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }
}
