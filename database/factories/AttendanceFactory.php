<?php

namespace Database\Factories;

use App\Models\Attendance\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => \App\Models\Student::inRandomOrder()->value('id') ?? \App\Models\Student::factory(),
            'academic_year_id' => \App\Models\AcademicYear::inRandomOrder()->value('id') ?? \App\Models\AcademicYear::factory(),
            'grade_id' => \App\Models\Grade::inRandomOrder()->value('id') ?? \App\Models\Grade::factory(),
            'classroom_id' => \App\Models\ClassRoom::inRandomOrder()->value('id') ?? \App\Models\ClassRoom::factory(),
            'section_id' => \App\Models\Section::inRandomOrder()->value('id') ?? \App\Models\Section::factory(),
            'teacher_id' => \App\Models\Employee::inRandomOrder()->value('id') ?? \App\Models\Employee::factory(),
            'attendance_date' => $this->faker->date(),
            'attendance_status' => $this->faker->randomElement([1, 2, 3]),
        ];
    }
}
