<?php

namespace App\Http\Requests\Admin\Timetable;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->user()->can('create_timetables');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'section_id' => 'required|exists:sections,id',
            'day_of_week_id' => 'required|exists:days_of_week,id',
            'class_period_id' => 'required|exists:class_periods,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:employees,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ];
    }
}
