<?php

namespace App\Http\Requests\Admin\AcademicYear;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAcademicYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check() && auth('admin')->user()->can('edit_years');
    }

    public function rules(): array
    {
        $academicYear = $this->route('academic_year');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('academic_years', 'name')->ignore($academicYear?->id),
            ],
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_current' => 'required|boolean',
        ];
    }
}
