<?php

namespace Database\Factories;

use App\Models\Fee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fee>
 */
class FeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => [
                'en' => ucfirst($this->faker->words(2, true)) . ' Fee',
                'ar' => 'رسوم ' . $this->faker->word(),
            ],
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'fee_category_id' => \App\Models\FeeCategory::inRandomOrder()->value('id') ?? \App\Models\FeeCategory::factory(),
            'academic_year_id' => \App\Models\AcademicYear::inRandomOrder()->value('id') ?? \App\Models\AcademicYear::factory(),
            'grade_id' => \App\Models\Grade::inRandomOrder()->value('id') ?? \App\Models\Grade::factory(),
            'classroom_id' => \App\Models\ClassRoom::inRandomOrder()->value('id') ?? \App\Models\ClassRoom::factory(),
            'description' => $this->faker->sentence(),
        ];
    }
}
