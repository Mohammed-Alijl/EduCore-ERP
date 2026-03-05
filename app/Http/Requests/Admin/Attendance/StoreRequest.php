<?php

namespace App\Http\Requests\Admin\Attendance;

use App\Models\Attendance;
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
            'attendance_date' => 'required|date|before_or_equal:today',
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'attendances' => 'required|array|min:1',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.attendance_status' => 'required|in:' . implode(',', [
                Attendance::STATUS_PRESENT,
                Attendance::STATUS_ABSENT,
                Attendance::STATUS_LATE,
            ]),
        ];
    }
}
