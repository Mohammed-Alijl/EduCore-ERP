<?php

namespace App\Http\Requests\Export;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AttendanceReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->user()->can('export_attendance-reports');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'academic_year_id' => ['required', 'numeric', 'exists:academic_years,id'],
            'grade_id' => ['nullable', 'numeric', 'exists:grades,id'],
            'section_id' => ['nullable', 'numeric', 'exists:sections,id'],
        ];
    }
}
