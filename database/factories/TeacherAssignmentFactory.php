<?php

namespace Database\Factories;

use App\Models\Scheduling\TeacherAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeacherAssignment>
 */
class TeacherAssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => \App\Models\Employee::inRandomOrder()->value('id') ?? \App\Models\Employee::factory(),
            'subject_id' => \App\Models\Subject::inRandomOrder()->value('id') ?? \App\Models\Subject::factory(),
            'section_id' => \App\Models\Section::inRandomOrder()->value('id') ?? \App\Models\Section::factory(),
            'academic_year' => $this->faker->year(),
        ];
    }
}
