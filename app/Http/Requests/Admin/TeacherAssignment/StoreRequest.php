<?php

namespace App\Http\Requests\Admin\TeacherAssignment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'teacher_id' => [
                'required',
                'exists:teachers,id',
                Rule::unique('teacher_assignments')->where(function ($query) {
                    return $query->where('subject_id', $this->subject_id)
                        ->where('section_id', $this->section_id)
                        ->where('academic_year', $this->academic_year);
                }),
            ],
            'subject_id' => 'required|exists:subjects,id',
            'section_id' => 'required|exists:sections,id',
            'academic_year' => 'required|string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'teacher_id'    => trans('admin.assignments.teacher_id'),
            'subject_id'    => trans('admin.assignments.subject_id'),
            'section_id'    => trans('admin.assignments.section_id'),
            'academic_year' => trans('admin.assignments.academic_year'),
        ];
    }
}
