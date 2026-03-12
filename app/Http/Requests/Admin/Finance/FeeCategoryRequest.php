<?php

namespace App\Http\Requests\Admin\Finance;

use Illuminate\Foundation\Http\FormRequest;

class FeeCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->user()->can('create_fees') || auth('admin')->user()->can('edit_fees');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'             => ['required', 'array'],
            'title.ar'          => ['required', 'string', 'max:255'],
            'title.en'          => ['required', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
        ];
    }
}
