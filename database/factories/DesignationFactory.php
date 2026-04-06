<?php

namespace Database\Factories;

use App\Models\HumanResources\Designation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Designation>
 */
class DesignationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->jobTitle(),
            'description' => $this->faker->sentence(),
            'department_id' => \App\Models\Department::inRandomOrder()->value('id') ?? \App\Models\Department::factory(),
            'default_salary' => $this->faker->randomFloat(2, 3000, 15000),
            'can_teach' => $this->faker->boolean(50),
        ];
    }
}
