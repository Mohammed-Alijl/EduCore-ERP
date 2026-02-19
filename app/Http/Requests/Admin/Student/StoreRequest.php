<?php

namespace App\Http\Requests\Admin\Student;

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
            'name'             => 'required|array',
            'name.ar'          => 'required|string|min:3|max:50',
            'name.en'          => 'required|string|min:3|max:50|pattern:[a-zA-Z\s]+',
            'email'            => 'nullable|email|unique:students,email',
            'password'         => 'required|string|min:8|confirmed',
            'national_id'      => 'required|string|max:20|unique:students,national_id',
            'date_of_birth'    => 'required|date|before:today',
            'grade_id'         => 'required|exists:grades,id',
            'classroom_id'     => 'required|exists:classrooms,id',
            'section_id'       => 'required|exists:sections,id',
            'academic_year'    => 'required|string|max:10',
            'guardian_id'      => 'required|exists:guardians,id',
            'blood_type_id'    => 'required|exists:blood_types,id',
            'nationality_id'   => 'required|exists:nationalities,id',
            'religion_id'      => 'required|exists:religions,id',
            'gender_id'        => 'required|exists:genders,id',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'attachments'      => 'nullable|array',
            'attachments.*'    => 'file|mimes:pdf,jpeg,png,jpg|max:5120',
        ];
    }
}
