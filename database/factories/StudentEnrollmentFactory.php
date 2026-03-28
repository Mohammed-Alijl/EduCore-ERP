<?php

namespace Database\Factories;

use App\Models\StudentEnrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentEnrollment>
 */
class StudentEnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => \App\Models\Student::factory(),
            'academic_year_id' => \App\Models\AcademicYear::factory(),
            'grade_id' => \App\Models\Grade::inRandomOrder()->value('id') ?? \App\Models\Grade::factory(),
            'classroom_id' => \App\Models\ClassRoom::inRandomOrder()->value('id') ?? \App\Models\ClassRoom::factory(),
            'section_id' => \App\Models\Section::inRandomOrder()->value('id') ?? \App\Models\Section::factory(),
            'enrollment_status' => $this->faker->randomElement(['promoted', 'repeating', 'graduated']),
            'admin_id' => \App\Models\Admin::inRandomOrder()->value('id') ?? \App\Models\Admin::factory(),
        ];
    }
}
