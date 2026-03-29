<?php

namespace Database\Factories;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $classRoom = \App\Models\ClassRoom::inRandomOrder()->first() ?? \App\Models\ClassRoom::factory()->create();
        
        return [
            'name' => [
                'en' => 'Section ' . $this->faker->numberBetween(1, 10),
                'ar' => 'شعبة ' . $this->faker->numberBetween(1, 10),
            ],
            'grade_id' => $classRoom->grade_id,
            'classroom_id' => $classRoom->id,
            'status' => $this->faker->boolean(80) ? 1 : 0,
            'sort_order' => $this->faker->numberBetween(1, 100),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
