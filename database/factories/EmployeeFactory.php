<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Gender;
use App\Models\Nationality;
use App\Models\Religion;
use App\Models\Specialization;
use App\Models\TypeBlood;
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
                'ar' => 'موظف '.$this->faker->firstName(),
            ],
            'email' => $this->faker->unique()->safeEmail(),
            'national_id' => $this->faker->unique()->numerify('10########'),
            'password' => 'password', // Employee mutator handles hashing
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'joining_date' => $this->faker->date(),
            'gender_id' => Gender::inRandomOrder()->value('id') ?? 1,
            'specialization_id' => Specialization::inRandomOrder()->value('id') ?? Specialization::factory(),
            'blood_type_id' => TypeBlood::inRandomOrder()->value('id') ?? 1,
            'nationality_id' => Nationality::inRandomOrder()->value('id') ?? 1,
            'religion_id' => Religion::inRandomOrder()->value('id') ?? 1,
            'status' => $this->faker->boolean(90) ? 1 : 0,
            'designation_id' => Designation::inRandomOrder()->value('id') ?? Designation::factory(),
            'department_id' => Department::inRandomOrder()->value('id') ?? Department::factory(),
            'contract_type' => $this->faker->randomElement(['full_time', 'part_time', 'contract']),
            'basic_salary' => $this->faker->randomFloat(2, 3000, 15000),
            'bank_account_number' => $this->faker->numerify('SA######################'),
            'employee_code' => $this->faker->unique()->numerify('E########'),
        ];
    }
}
