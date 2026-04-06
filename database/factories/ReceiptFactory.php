<?php

namespace Database\Factories;

use App\Models\Finance\Receipt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Receipt>
 */
class ReceiptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => \App\Models\Student::inRandomOrder()->value('id') ?? \App\Models\Student::factory(),
            'academic_year_id' => \App\Models\AcademicYear::inRandomOrder()->value('id') ?? \App\Models\AcademicYear::factory(),
            'paid_amount' => $this->faker->randomFloat(2, 100, 2000),
            'currency_code' => \App\Models\Currency::inRandomOrder()->value('code') ?? 'USD',
            'exchange_rate' => 1.0000,
            'base_amount' => 100,
            'surcharge_amount' => 0,
            'payment_gateway_id' => \App\Models\PaymentGateway::inRandomOrder()->value('id') ?? 1,
            'transaction_id' => $this->faker->unique()->uuid(),
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
        ];
    }
}
