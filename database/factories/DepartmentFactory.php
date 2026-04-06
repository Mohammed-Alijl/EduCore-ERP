<?php

namespace Database\Factories;

use App\Models\HumanResources\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->word()).' Department',
            'description' => $this->faker->sentence(),
        ];
    }
}
