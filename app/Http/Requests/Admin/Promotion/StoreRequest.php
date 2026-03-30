<?php

namespace App\Http\Requests\Admin\Promotion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

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
            'from_grade_id' => 'required|exists:grades,id',
            'from_classroom_id' => 'required|exists:class_rooms,id',
            'from_section_id' => 'required|exists:sections,id',
            'from_academic_year_id' => 'required|exists:academic_years,id',
            'to_grade_id' => 'required_with:promote_student_ids|nullable|exists:grades,id',
            'to_classroom_id' => 'required_with:promote_student_ids|nullable|exists:class_rooms,id',
            'to_section_id' => 'required_with:promote_student_ids|nullable|exists:sections,id',
            'to_academic_year_id' => 'required_with:promote_student_ids|nullable|exists:academic_years,id',
            'promote_student_ids' => 'nullable|array',
            'promote_student_ids.*' => 'required|integer|exists:students,id',
            'graduate_student_ids' => 'nullable|array',
            'graduate_student_ids.*' => 'required|integer|exists:students,id',
        ];
    }
}
