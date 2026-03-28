<?php

namespace Database\Factories;

use App\Models\AttemptQuestion;
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
            'exam_attempt_id' => \App\Models\ExamAttempt::factory(), 
            'question_id' => \App\Models\Question::factory(),
            'selected_option_id' => \App\Models\QuestionOption::inRandomOrder()->value('id') ?? \App\Models\QuestionOption::factory(),
            'is_correct' => $isCorrect,
            'points_awarded' => $isCorrect ? $this->faker->randomFloat(2, 1, 5) : 0,
            'question_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
