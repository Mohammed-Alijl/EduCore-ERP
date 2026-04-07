<?php

namespace Database\Factories;

use App\Models\Academic\ClassRoom;
use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ClassRoom>
 */
class ClassRoomFactory extends Factory
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
                'en' => 'Class '.strtoupper($this->faker->lexify('?')),
                'ar' => 'فصل '.$this->faker->randomLetter(),
            ],
            'grade_id' => Grade::inRandomOrder()->value('id') ?? Grade::factory(),
            'status' => $this->faker->boolean(80) ? 1 : 0,
            'sort_order' => $this->faker->numberBetween(1, 100),
            'notes' => $this->faker->sentence(),
        ];
    }
}
