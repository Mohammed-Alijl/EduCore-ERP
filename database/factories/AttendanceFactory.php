<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Attendance\Attendance;
use App\Models\ClassRoom;
use App\Models\Employee;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Student;
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
            'student_id' => Student::inRandomOrder()->value('id') ?? Student::factory(),
            'academic_year_id' => AcademicYear::inRandomOrder()->value('id') ?? AcademicYear::factory(),
            'grade_id' => Grade::inRandomOrder()->value('id') ?? Grade::factory(),
            'classroom_id' => ClassRoom::inRandomOrder()->value('id') ?? ClassRoom::factory(),
            'section_id' => Section::inRandomOrder()->value('id') ?? Section::factory(),
            'teacher_id' => Employee::inRandomOrder()->value('id') ?? Employee::factory(),
            'attendance_date' => $this->faker->date(),
            'attendance_status' => $this->faker->randomElement([1, 2, 3]),
        ];
    }
}
