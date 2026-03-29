<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $section = \App\Models\Section::inRandomOrder()->first();
        $academicYear = \App\Models\AcademicYear::inRandomOrder()->value('name') ?? '2024-2025';

        return [
            'name' => [
                'en' => $this->faker->name,
                'ar' => $this->faker->name,
            ],
            'email' => $this->faker->unique()->safeEmail,
            'password' => '123456789', 
            'national_id' => $this->faker->unique()->numerify('##########'),
            'date_of_birth' => $this->faker->date('Y-m-d', '-10 years'),
            'grade_id' => $section ? $section->grade_id : \App\Models\Grade::inRandomOrder()->value('id'),
            'classroom_id' => $section ? $section->classroom_id : \App\Models\ClassRoom::inRandomOrder()->value('id'),
            'section_id' => $section ? $section->id : \App\Models\Section::inRandomOrder()->value('id'),
            'academic_year' => $academicYear,
            'guardian_id' => \App\Models\Guardian::inRandomOrder()->value('id'),
            'blood_type_id' => \App\Models\TypeBlood::inRandomOrder()->value('id'),
            'nationality_id' => \App\Models\Nationality::inRandomOrder()->value('id'),
            'religion_id' => \App\Models\Religion::inRandomOrder()->value('id'),
            'gender_id' => \App\Models\Gender::inRandomOrder()->value('id'),
            'status' => $this->faker->randomElement([0, 1]),
            'admin_id' => \App\Models\Admin::inRandomOrder()->value('id') ?? 1,
            'student_code' => $this->faker->unique()->numerify(date('Y') . '####'),
        ];
    }
}
