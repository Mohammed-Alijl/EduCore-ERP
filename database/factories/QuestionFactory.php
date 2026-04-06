<?php

namespace Database\Factories;

use App\Models\Assessments\Question;
use App\Models\Employee;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject_id' => Subject::inRandomOrder()->value('id') ?? Subject::factory(),
            'teacher_id' => Employee::inRandomOrder()->value('id') ?? Employee::factory(),
            'content' => $this->faker->sentence().'?',
            'type' => $this->faker->randomElement([1, 2]),
            'points' => $this->faker->randomFloat(2, 1, 10),
        ];
    }
}
