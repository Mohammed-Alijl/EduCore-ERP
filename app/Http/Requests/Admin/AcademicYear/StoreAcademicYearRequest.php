<?php

namespace App\Http\Requests\Admin\AcademicYear;

use Illuminate\Foundation\Http\FormRequest;

class StoreAcademicYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check() && auth('admin')->user()->can('create_years');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:academic_years,name',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_current' => 'required|boolean',
        ];
    }
}
