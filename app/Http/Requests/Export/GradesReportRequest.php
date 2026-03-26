<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class GradesReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->user()->can('export_grades-reports');
    }

    public function rules(): array
    {
        return [
            'academic_year_id' => ['required', 'numeric', 'exists:academic_years,id'],
            'grade_id' => ['required', 'numeric', 'exists:grades,id'],
            'classroom_id' => ['nullable', 'numeric', 'exists:class_rooms,id'],
            'section_id' => ['nullable', 'numeric', 'exists:sections,id'],
            'subject_id' => ['nullable', 'numeric', 'exists:subjects,id'],
            'exam_id' => ['nullable', 'numeric', 'exists:exams,id'],
        ];
    }
}
