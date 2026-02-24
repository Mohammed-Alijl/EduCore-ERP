<?php

namespace App\Http\Requests\Admin\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('edit_teachers');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $teacher = $this->route('teacher');

        return [
            'password'          => ['required', 'string', 'min:8', 'confirmed'],
            'name.ar'           => ['required', 'string', 'max:100', 'min:3'],
            'name.en'           => ['required', 'string', 'max:100', 'min:3'],
            'email'             => ['required', 'email', 'max:100', "unique:teachers,email,{$teacher->id}"],
            'phone'             => ['nullable', 'string', 'max:20'],
            'address'           => ['nullable', 'string', 'max:500'],
            'joining_date'      => ['required', 'date'],
            'blood_type_id'     => ['required','exists:type_bloods,id'],
            'nationality_id'    => ['required','exists:nationalities,id'],
            'religion_id'       => ['required','exists:religions,id'],
            'gender_id'         => ['required', 'exists:genders,id'],
            'status'            => ['required', 'boolean'],
            'image'             => ['nullable','image','mimes:jpeg,png,jpg','max:2048'],
            'attachments'       => ['nullable','array'],
            'attachments.*'     => ['file','mimes:pdf,jpeg,png,jpg','max:2048'],
        ];
    }
}
