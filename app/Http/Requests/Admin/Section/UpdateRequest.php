<?php

namespace App\Http\Requests\Admin\Section;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => 'required|array',
            'name.ar' => [
                'required', 'string', 'max:30',
                Rule::unique('sections', 'name->ar')->where(function ($query) {
                    return $query->where('classroom_id', $this->classroom_id);
                })->ignore($this->section)
            ],
            'name.en' => [
                'required', 'string', 'max:255',
                Rule::unique('sections', 'name->en')->where(function ($query) {
                    return $query->where('classroom_id', $this->classroom_id);
                })->ignore($this->section)
            ],
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:class_rooms,id',
            'status' => 'required|boolean',
            'sort_order' => 'nullable|integer|min:0|max:1000',
            'notes' => 'nullable|string|max:100',
        ];
    }
}
