<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralSettingRequest extends FormRequest
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
            'school_name' => 'required|array',
            'school_name.ar' => 'required|string|min:3|max:255',
            'school_name.en' => 'required|string|min:3|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|array',
            'address.ar' => 'nullable|string|max:500',
            'address.en' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'current_academic_year_id' => 'nullable|exists:academic_years,id',
            'social_media' => 'nullable|array',
            'social_media.facebook' => 'nullable|url|max:255',
            'social_media.twitter' => 'nullable|url|max:255',
            'social_media.instagram' => 'nullable|url|max:255',
            'social_media.linkedin' => 'nullable|url|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'school_name.required' => trans('admin.general_settings.validation.school_name_required'),
            'school_name.ar.required' => trans('admin.general_settings.validation.school_name_ar_required'),
            'school_name.en.required' => trans('admin.general_settings.validation.school_name_en_required'),
            'email.email' => trans('admin.general_settings.validation.email_invalid'),
            'logo.image' => trans('admin.general_settings.validation.logo_image'),
            'logo.max' => trans('admin.general_settings.validation.logo_max'),
            'website.url' => trans('admin.general_settings.validation.website_url'),
        ];
    }
}
