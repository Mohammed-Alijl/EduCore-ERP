<?php

namespace Database\Factories;

use App\Models\Assessments\Exam;
use App\Models\Assessments\ExamAttempt;
use App\Models\Users\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ExamAttemptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExamAttempt::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startedAt = Carbon::instance($this->faker->dateTimeBetween('-1 month', 'now'));
        $completedAt = $this->faker->boolean(80) ? (clone $startedAt)->addMinutes($this->faker->numberBetween(10, 60)) : null;

        return [
            'exam_id' => Exam::inRandomOrder()->first()?->id ?? 1,
            'student_id' => Student::inRandomOrder()->first()?->id ?? 1,
            'status' => $completedAt ? ExamAttempt::STATUS_COMPLETED : ExamAttempt::STATUS_IN_PROGRESS,
            'score' => $completedAt ? $this->faker->numberBetween(0, 100) : null,
            'started_at' => $startedAt,
            'completed_at' => $completedAt,
        ];
    }
}
