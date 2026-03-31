<?php

namespace App\Http\Requests\Admin\Designation;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->user()->can('edit_designations');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:designations,name,' . $this->route('designation')->id,
            'description' => 'nullable|string|max:500',
            'department_id' => 'required|exists:departments,id',
            'default_salary' => 'nullable|numeric|min:0|max:9999.99',
            'can_teach' => 'required|boolean',
        ];
    }
}
