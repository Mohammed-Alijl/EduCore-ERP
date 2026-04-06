<?php

namespace Database\Factories;

use App\Models\Academic\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => [
                'en' => ucfirst($this->faker->words(2, true)).' Grade',
                'ar' => 'المرحلة '.$this->faker->randomDigitNotNull(),
            ],
            'notes' => $this->faker->sentence(),
            'status' => $this->faker->boolean(80) ? 1 : 0,
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
