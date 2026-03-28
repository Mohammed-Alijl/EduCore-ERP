<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subject>
 */
class SubjectFactory extends Factory
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
                'en' => ucfirst($this->faker->word()) . ' Subject',
                'ar' => 'مادة ' . $this->faker->word(),
            ],
            'specialization_id' => \App\Models\Specialization::inRandomOrder()->value('id') ?? \App\Models\Specialization::factory(),
            'grade_id' => \App\Models\Grade::inRandomOrder()->value('id') ?? \App\Models\Grade::factory(),
            'classroom_id' => \App\Models\ClassRoom::inRandomOrder()->value('id') ?? \App\Models\ClassRoom::factory(),
            'status' => 1,
            'admin_id' => \App\Models\Admin::inRandomOrder()->value('id') ?? \App\Models\Admin::factory(),
        ];
    }
}
