<?php

namespace Database\Factories;

use App\Models\Users\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
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
                'en' => $this->faker->name(),
                'ar' => 'موظف ' . $this->faker->firstName(),
            ],
            'email' => $this->faker->unique()->safeEmail(),
            'national_id' => $this->faker->unique()->numerify('10########'),
            'password' => 'password', // Employee mutator handles hashing
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'joining_date' => $this->faker->date(),
            'gender_id' => \App\Models\Gender::inRandomOrder()->value('id') ?? 1,
            'specialization_id' => \App\Models\Specialization::inRandomOrder()->value('id') ?? \App\Models\Specialization::factory(),
            'blood_type_id' => \App\Models\TypeBlood::inRandomOrder()->value('id') ?? 1,
            'nationality_id' => \App\Models\Nationality::inRandomOrder()->value('id') ?? 1,
            'religion_id' => \App\Models\Religion::inRandomOrder()->value('id') ?? 1,
            'status' => $this->faker->boolean(90) ? 1 : 0,
            'designation_id' => \App\Models\Designation::inRandomOrder()->value('id') ?? \App\Models\Designation::factory(),
            'department_id' => \App\Models\Department::inRandomOrder()->value('id') ?? \App\Models\Department::factory(),
            'contract_type' => $this->faker->randomElement(['full_time', 'part_time', 'contract']),
            'basic_salary' => $this->faker->randomFloat(2, 3000, 15000),
            'bank_account_number' => $this->faker->numerify('SA######################'),
            'employee_code' => $this->faker->unique()->numerify('E########'),
        ];
    }
}
