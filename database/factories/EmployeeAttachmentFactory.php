<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\HumanResources\EmployeeAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmployeeAttachment>
 */
class EmployeeAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::inRandomOrder()->value('id') ?? Employee::factory(),
            'attachment_path' => 'attachments/fake_'.$this->faker->uuid().'.pdf',
        ];
    }
}
