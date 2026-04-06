<?php

namespace Database\Factories;

use App\Models\Academic\Subject;
use App\Models\Admin;
use App\Models\ClassRoom;
use App\Models\Grade;
use App\Models\Specialization;
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
                'en' => ucfirst($this->faker->word()).' Subject',
                'ar' => 'مادة '.$this->faker->word(),
            ],
            'specialization_id' => Specialization::inRandomOrder()->value('id') ?? Specialization::factory(),
            'grade_id' => Grade::inRandomOrder()->value('id') ?? Grade::factory(),
            'classroom_id' => ClassRoom::inRandomOrder()->value('id') ?? ClassRoom::factory(),
            'status' => 1,
            'admin_id' => Admin::inRandomOrder()->value('id') ?? Admin::factory(),
        ];
    }
}
