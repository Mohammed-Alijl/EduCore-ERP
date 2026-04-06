<?php

namespace Database\Factories;

use App\Models\Assessments\StudentExamResult;
use App\Models\Exam;
use App\Models\Student;
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
            'exam_id' => Exam::inRandomOrder()->value('id') ?? Exam::factory(),
            'student_id' => Student::inRandomOrder()->value('id') ?? Student::factory(),
            'final_score' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
