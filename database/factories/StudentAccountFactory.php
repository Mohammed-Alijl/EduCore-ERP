<?php

namespace Database\Factories;

use App\Models\Finance\StudentAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentAccount>
 */
class StudentAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => \App\Models\Student::inRandomOrder()->value('id') ?? \App\Models\Student::factory(),
            'transactionable_type' => \App\Models\Receipt::class,
            'transactionable_id' => \App\Models\Receipt::inRandomOrder()->value('id') ?? \App\Models\Receipt::factory(),
            'debit' => $this->faker->randomFloat(2, 0, 1000),
            'credit' => $this->faker->randomFloat(2, 0, 1000),
            'description' => $this->faker->sentence(),
            'date' => $this->faker->date(),
        ];
    }
}
