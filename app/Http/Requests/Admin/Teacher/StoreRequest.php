<?php

namespace App\Http\Requests\Admin\Teacher;

use App\Models\Teacher;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create_teachers');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'name.ar'       => ['required', 'string', 'max:100', 'min:3', 'unique:teachers,name'],
            'name.en'       => ['required', 'string', 'max:100', 'min:3', 'unique:teachers,name'],
            'email'         => ['required', 'email', 'max:100', 'unique:teachers,email'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'address'       => ['nullable', 'string', 'max:500'],
            'joining_date'  => ['required', 'date'],
            'gender_id'     => ['required', 'exists:genders,id'],
            'status'        => ['required', 'boolean'],
            'image'         => ['nullable','image','mimes:jpeg,png,jpg','max:2048'],
            'attachments'   => ['nullable','array'],
            'attachments.*' => ['file','mimes:pdf,jpeg,png,jpg','max:2048'],
        ];
    }
}
