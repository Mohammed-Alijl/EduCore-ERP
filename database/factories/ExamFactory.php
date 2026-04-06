<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Exam>
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
            'subject_id' => Subject::inRandomOrder()->first()?->id ?? 1,
            'teacher_id' => Teacher::inRandomOrder()->first()?->id ?? 1,
            'academic_year_id' => AcademicYear::inRandomOrder()->first()?->id ?? 1,
            'start_time' => $start = Carbon::instance($this->faker->dateTimeBetween('now', '+1 month')),
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
