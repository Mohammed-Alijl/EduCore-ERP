<?php

namespace App\Http\Requests\Admin\ClassPeriod;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->user()->can('create_classPeriods');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.ar' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|integer|min:1|max:480',
            'grade_id' => 'nullable|exists:grades,id',
            'is_break' => 'required|boolean',
            'status' => 'required|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }
}
