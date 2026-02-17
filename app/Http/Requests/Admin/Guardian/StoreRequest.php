<?php

namespace App\Http\Requests\Admin\Guardian;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'    => 'required|email|max:50|unique:guardians,email',
            'password' => 'required|string|min:8|max:30|confirmed',
            'name_father'    => 'required|array',
            'name_father.ar' => 'required|string|min:3|max:30',
            'name_father.en' => 'required|string|min:3|max:30',
            'job_father'     => 'required|array',
            'job_father.ar'  => 'required|string|min:3|max:30',
            'job_father.en'  => 'required|string|min:3|max:30',
            'national_id_father' => 'required|string|min:9|max:10|unique:guardians,national_id_father',
            'passport_id_father' => 'nullable|string|min:8|max:10',
            'phone_father'       => 'required|string|max:20',
            'nationality_father_id' => 'required|integer|exists:nationalities,id',
            'blood_type_father_id'  => 'required|integer|exists:type_bloods,id',
            'religion_father_id'    => 'required|integer|exists:religions,id',
            'address_father'        => 'required|string|max:100',
            'name_mother'    => 'required|array',
            'name_mother.ar' => 'required|string|min:3|max:30',
            'name_mother.en' => 'required|string|min:3|max:30',
            'job_mother'     => 'nullable|array',
            'job_mother.ar'  => 'nullable|string|min:3|max:30',
            'job_mother.en'  => 'nullable|string|min:3|max:30',
            'national_id_mother' => 'nullable|string|min:9|max:10|unique:guardians,national_id_mother',
            'passport_id_mother' => 'nullable|string|min:8|max:10',
            'phone_mother'       => 'nullable|string|max:20',
            'nationality_mother_id' => 'required|integer|exists:nationalities,id',
            'blood_type_mother_id'  => 'required|integer|exists:type_bloods,id',
            'religion_mother_id'    => 'required|integer|exists:religions,id',
            'address_mother'        => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'attachments'   => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,jpeg,png,jpg|max:2048',
        ];
    }
}
