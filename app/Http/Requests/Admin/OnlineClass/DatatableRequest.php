<?php

namespace App\Http\Requests\Admin\OnlineClass;

use Illuminate\Foundation\Http\FormRequest;

class DatatableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->user()->can('view_online_classes');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'academic_year_id' => 'nullable|numeric|integer|exists:academic_years,id',
            'grade_id'         => 'nullable|numeric|integer|exists:grades,id',
            'classroom_id'     => 'nullable|numeric|integer|exists:classrooms,id',
            'section_id'       => 'nullable|numeric|integer|exists:sections,id',
            'teacher_id'       => 'nullable|numeric|integer|exists:teachers,id',
        ];
    }
}
