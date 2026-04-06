<?php

namespace Database\Factories;

use App\Models\Academic\AcademicYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AcademicYear>
 */
class AcademicYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = $this->faker->unique()->year();
        return [
            'name' => $year . '/' . ($year + 1),
            'starts_at' => $year . '-09-01',
            'ends_at' => ($year + 1) . '-06-30',
            'is_current' => 0,
        ];
    }
}
