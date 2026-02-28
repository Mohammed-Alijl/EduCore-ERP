<?php

namespace App\Http\Requests\Admin\Subject;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'               => ['required', 'array'],
            'name.ar'            => ['required', 'string', 'max:255'],
            'name.en'            => ['required', 'string', 'max:255'],
            'specialization_id'  => ['required', 'exists:specializations,id'],
            'grade_id'           => ['required', 'exists:grades,id'],
            'classroom_id'       => ['required', 'exists:class_rooms,id'],
            'status'             => ['nullable', 'in:0,1'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'              => trans('admin.subjects.fields.name'),
            'name.ar'           => trans('admin.subjects.fields.name_ar'),
            'name.en'           => trans('admin.subjects.fields.name_en'),
            'specialization_id' => trans('admin.subjects.fields.specialization_id'),
            'grade_id'          => trans('admin.subjects.fields.grade_id'),
            'classroom_id'      => trans('admin.subjects.fields.classroom_id'),
            'status'            => trans('admin.subjects.fields.status'),
        ];
    }
}
