<?php

namespace Database\Factories;

use App\Models\Assessments\StudentExamResult;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentExamResult>
 */
class StudentExamResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exam_id' => \App\Models\Exam::inRandomOrder()->value('id') ?? \App\Models\Exam::factory(),
            'student_id' => \App\Models\Student::inRandomOrder()->value('id') ?? \App\Models\Student::factory(),
            'final_score' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
