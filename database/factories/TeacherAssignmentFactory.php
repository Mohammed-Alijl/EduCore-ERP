<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Scheduling\TeacherAssignment;
use App\Models\Section;
use App\Models\Subject;
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
            'teacher_id' => Employee::inRandomOrder()->value('id') ?? Employee::factory(),
            'subject_id' => Subject::inRandomOrder()->value('id') ?? Subject::factory(),
            'section_id' => Section::inRandomOrder()->value('id') ?? Section::factory(),
            'academic_year' => $this->faker->year(),
        ];
    }
}
