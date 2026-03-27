<?php

namespace App\Http\Requests\Admin\Library;

use Illuminate\Foundation\Http\FormRequest;

class BookDatatableRequest extends FormRequest
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
            'grade_id' => 'nullable|numeric|integer|exists:grades,id',
            'classroom_id' => 'nullable|numeric|integer|exists:class_rooms,id',
            'section_id' => 'nullable|numeric|integer|exists:sections,id',
            'teacher_id' => 'nullable|numeric|integer|exists:employees,id',
            'subject_id' => 'nullable|numeric|integer|exists:subjects,id',
        ];
    }
}
