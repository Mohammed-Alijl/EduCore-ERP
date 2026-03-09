<?php

namespace App\Http\Requests\Admin\AcademicYear;

use Illuminate\Foundation\Http\FormRequest;

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
            'name'       => 'required|string|max:255|unique:academic_years,name',
            'starts_at'  => 'required|date',
            'ends_at'    => 'required|date|after:starts_at',
            'is_current' => 'required|boolean',
        ];
    }
}
