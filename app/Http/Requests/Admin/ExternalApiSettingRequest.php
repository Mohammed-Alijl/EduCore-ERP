<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ExternalApiSettingRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.ar' => 'required|string|max:255',
            'description' => 'nullable|array',
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
            'credentials' => 'required|array',
            'is_active' => 'boolean',
        ];

        // Specific validation for slug-based credentials
        $slug = $this->route('external_api_setting')?->slug;

        if ($slug === 'mailgun') {
            $rules['credentials.domain'] = 'required|string';
            $rules['credentials.secret'] = 'required|string';
            $rules['credentials.endpoint'] = 'required|string';
        } elseif ($slug === 'zoom') {
            $rules['credentials.client_id'] = 'required|string';
            $rules['credentials.client_secret'] = 'required|string';
            $rules['credentials.account_id'] = 'required|string';
        }

        return $rules;
    }
}
