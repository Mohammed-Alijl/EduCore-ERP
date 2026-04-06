<?php

namespace Database\Factories;

use App\Models\Finance\StudentDiscount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentDiscount>
 */
class StudentDiscountFactory extends Factory
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
            'academic_year_id' => \App\Models\AcademicYear::inRandomOrder()->value('id') ?? \App\Models\AcademicYear::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 500),
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
        ];
    }
}
