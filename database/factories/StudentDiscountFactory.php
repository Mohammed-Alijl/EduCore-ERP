<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Finance\StudentDiscount;
use App\Models\Student;
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
            'student_id' => Student::inRandomOrder()->value('id') ?? Student::factory(),
            'academic_year_id' => AcademicYear::inRandomOrder()->value('id') ?? AcademicYear::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 500),
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
        ];
    }
}
