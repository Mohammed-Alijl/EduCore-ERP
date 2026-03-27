<?php

namespace App\Http\Requests\Admin\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->user()->can('create_employees');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'min:8', 'max:30', 'confirmed'],
            'name.ar' => ['required', 'string', 'max:100', 'min:3'],
            'name.en' => ['required', 'string', 'max:100', 'min:3'],
            'email' => ['required', 'email', 'max:100', 'unique:employees,email'],
            'national_id' => ['required', 'string', 'max:50', 'unique:employees,national_id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'joining_date' => ['required', 'date'],
            'blood_type_id' => ['required', 'exists:type_bloods,id'],
            'nationality_id' => ['required', 'exists:nationalities,id'],
            'religion_id' => ['required', 'exists:religions,id'],
            'gender_id' => ['required', 'exists:genders,id'],
            'specialization_id' => ['nullable', 'exists:specializations,id'],
            'designation_id' => ['required', 'exists:designations,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'contract_type' => ['required', 'in:full_time,part_time,contract'],
            'basic_salary' => ['required', 'numeric', 'min:0'],
            'bank_account_number' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'mimes:pdf,jpeg,png,jpg', 'max:2048'],
        ];
    }
}
