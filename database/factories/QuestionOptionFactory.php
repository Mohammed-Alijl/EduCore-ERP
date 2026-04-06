<?php

namespace Database\Factories;

use App\Models\Assessments\QuestionOption;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuestionOption>
 */
class QuestionOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_id' => Question::inRandomOrder()->value('id') ?? Question::factory(),
            'content' => $this->faker->word(),
            'is_correct' => $this->faker->boolean(25),
        ];
    }
}
