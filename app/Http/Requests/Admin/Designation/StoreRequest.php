<?php

namespace App\Http\Requests\Admin\Designation;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->user()->can('create_designation');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:designations,name',
            'description' => 'nullable|string|max:500',
            'department_id' => 'required|exists:departments,id',
            'default_salary' => 'nullable|numeric|min:0|max:9999.99',
            'can_teach' => 'required|boolean',
        ];
    }
}
