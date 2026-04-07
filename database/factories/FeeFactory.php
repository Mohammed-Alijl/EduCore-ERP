<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\FeeCategory;
use App\Models\Finance\Fee;
use App\Models\Grade;
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
                'en' => ucfirst($this->faker->words(2, true)).' Fee',
                'ar' => 'رسوم '.$this->faker->word(),
            ],
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'fee_category_id' => FeeCategory::inRandomOrder()->value('id') ?? FeeCategory::factory(),
            'academic_year_id' => AcademicYear::inRandomOrder()->value('id') ?? AcademicYear::factory(),
            'grade_id' => Grade::inRandomOrder()->value('id') ?? Grade::factory(),
            'classroom_id' => ClassRoom::inRandomOrder()->value('id') ?? ClassRoom::factory(),
            'description' => $this->faker->sentence(),
        ];
    }
}
