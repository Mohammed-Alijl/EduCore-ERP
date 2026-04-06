<?php

namespace Database\Factories;

use App\Models\Assessments\AttemptQuestion;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AttemptQuestion>
 */
class AttemptQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isCorrect = $this->faker->boolean();

        return [
            'exam_attempt_id' => ExamAttempt::factory(),
            'question_id' => Question::factory(),
            'selected_option_id' => QuestionOption::inRandomOrder()->value('id') ?? QuestionOption::factory(),
            'is_correct' => $isCorrect,
            'points_awarded' => $isCorrect ? $this->faker->randomFloat(2, 1, 5) : 0,
            'question_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
