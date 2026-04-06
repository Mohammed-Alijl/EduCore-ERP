<?php

namespace Database\Factories;

use App\Models\Academic\AcademicYear;
use App\Models\Academic\ClassRoom;
use App\Models\Academic\Grade;
use App\Models\Academic\Section;
use App\Models\SystemData\Gender;
use App\Models\SystemData\Nationality;
use App\Models\SystemData\Religion;
use App\Models\SystemData\TypeBlood;
use App\Models\Users\Admin;
use App\Models\Users\Guardian;
use App\Models\Users\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
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
        $section = Section::inRandomOrder()->first();
        $academicYear = AcademicYear::inRandomOrder()->value('name') ?? '2024-2025';

        return [
            'name' => [
                'en' => $this->faker->name,
                'ar' => $this->faker->name,
            ],
            'email' => $this->faker->unique()->safeEmail,
            'password' => '123456789',
            'national_id' => $this->faker->unique()->numerify('##########'),
            'date_of_birth' => $this->faker->date('Y-m-d', '-10 years'),
            'grade_id' => $section?->grade_id ?? Grade::inRandomOrder()->value('id'),
            'classroom_id' => $section?->classroom_id ?? ClassRoom::inRandomOrder()->value('id'),
            'section_id' => $section?->id ?? Section::inRandomOrder()->value('id'),
            'academic_year' => $academicYear,
            'guardian_id' => Guardian::inRandomOrder()->value('id'),
            'blood_type_id' => TypeBlood::inRandomOrder()->value('id'),
            'nationality_id' => Nationality::inRandomOrder()->value('id'),
            'religion_id' => Religion::inRandomOrder()->value('id'),
            'gender_id' => Gender::inRandomOrder()->value('id'),
            'status' => 1,
            'is_graduated' => false,
            'graduated_at' => null,
            'graduation_academic_year_id' => null,
            'admin_id' => Admin::inRandomOrder()->value('id') ?? 1,
            'student_code' => $this->faker->unique()->numerify(date('Y').'####'),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 1,
            'is_graduated' => false,
            'graduated_at' => null,
            'graduation_academic_year_id' => null,
        ]);
    }

    public function graduated(): static
    {
        return $this->state(fn (array $attributes) => [
            'grade_id' => null,
            'classroom_id' => null,
            'section_id' => null,
            'status' => 0,
            'is_graduated' => true,
            'graduated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'graduation_academic_year_id' => AcademicYear::inRandomOrder()->value('id'),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 0,
            'is_graduated' => false,
        ]);
    }
}
