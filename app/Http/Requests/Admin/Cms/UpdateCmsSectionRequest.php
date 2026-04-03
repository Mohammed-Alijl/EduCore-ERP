<?php

namespace App\Http\Requests\Admin\Cms;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCmsSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'array'],
            'title.en' => ['sometimes', 'nullable', 'string', 'max:255'],
            'title.ar' => ['sometimes', 'nullable', 'string', 'max:255'],
            'subtitle' => ['sometimes', 'array'],
            'subtitle.en' => ['sometimes', 'nullable', 'string', 'max:500'],
            'subtitle.ar' => ['sometimes', 'nullable', 'string', 'max:500'],
            'content' => ['sometimes', 'array'],
            'content.items' => ['sometimes', 'nullable', 'array'],
            'content.items.*' => ['sometimes', 'array'],
            'settings' => ['sometimes', 'array'],
            'is_visible' => ['sometimes', 'boolean'],
            'images' => ['sometimes', 'array'],
            'image_uploads' => ['sometimes', 'array'],
            'image_uploads.*' => ['sometimes', 'nullable', 'image', 'max:5120'],
        ];
    }
}
