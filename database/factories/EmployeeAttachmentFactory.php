<?php

namespace Database\Factories;

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
            'employee_id' => \App\Models\Employee::inRandomOrder()->value('id') ?? \App\Models\Employee::factory(),
            'attachment_path' => 'attachments/fake_' . $this->faker->uuid() . '.pdf',
        ];
    }
}
