<?php

namespace Database\Factories;

use App\Enums\EnrollmentStatus;
use App\Models\Academic\AcademicYear;
use App\Models\Admin;
use App\Models\Academic\ClassRoom;
use App\Models\Academic\Grade;
use App\Models\Academic\Section;
use App\Models\Student;
use App\Models\Academic\StudentEnrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentEnrollment>
 */
class StudentEnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fromSection = Section::inRandomOrder()->first();
        $toSection = Section::inRandomOrder()->first();

        return [
            'student_id' => Student::factory(),
            'from_grade' => $fromSection?->grade_id ?? Grade::factory(),
            'from_classroom' => $fromSection?->classroom_id ?? ClassRoom::factory(),
            'from_section' => $fromSection?->id ?? Section::factory(),
            'from_academic_year' => AcademicYear::factory(),
            'to_grade' => $toSection?->grade_id ?? Grade::factory(),
            'to_classroom' => $toSection?->classroom_id ?? ClassRoom::factory(),
            'to_section' => $toSection?->id ?? Section::factory(),
            'to_academic_year' => AcademicYear::factory(),
            'enrollment_status' => $this->faker->randomElement(EnrollmentStatus::cases())->value,
            'admin_id' => Admin::inRandomOrder()->value('id') ?? Admin::factory(),
        ];
    }

    public function promoted(): static
    {
        return $this->state(fn (array $attributes) => [
            'enrollment_status' => EnrollmentStatus::Promoted->value,
        ]);
    }

    public function repeating(): static
    {
        return $this->state(fn (array $attributes) => [
            'enrollment_status' => EnrollmentStatus::Repeating->value,
            'to_grade' => $attributes['from_grade'],
            'to_classroom' => $attributes['from_classroom'],
            'to_section' => $attributes['from_section'],
        ]);
    }

    public function graduated(): static
    {
        return $this->state(fn (array $attributes) => [
            'enrollment_status' => EnrollmentStatus::Graduated->value,
            'to_grade' => null,
            'to_classroom' => null,
            'to_section' => null,
        ]);
    }
}
