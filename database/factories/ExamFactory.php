<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'subject_id' => \App\Models\Subject::inRandomOrder()->first()?->id ?? 1,
            'teacher_id' => \App\Models\Teacher::inRandomOrder()->first()?->id ?? 1,
            'academic_year_id' => \App\Models\AcademicYear::inRandomOrder()->first()?->id ?? 1,
            'start_time' => $start = \Illuminate\Support\Carbon::instance($this->faker->dateTimeBetween('now', '+1 month')),
            'end_time' => $start->copy()->addHours(2),
            'duration_minutes' => 60,
            'total_questions' => 20,
            'total_marks' => 100,
            'max_attempts' => 1,
            'grading_method' => 1, // HIGHEST
            'result_visibility' => 2, // IMMEDIATE
            'is_published' => $this->faker->boolean(80),
        ];
    }
}
