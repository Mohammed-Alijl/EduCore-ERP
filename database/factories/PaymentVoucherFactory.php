<?php

namespace Database\Factories;

use App\Models\Finance\PaymentVoucher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentVoucher>
 */
class PaymentVoucherFactory extends Factory
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
            'payment_gateway_id' => \App\Models\PaymentGateway::inRandomOrder()->value('id') ?? 1,
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'currency_code' => \App\Models\Currency::inRandomOrder()->value('code') ?? 'USD',
            'exchange_rate' => 1.0000,
            'base_amount' => 100,
            'date' => $this->faker->date(),
            'reference_number' => $this->faker->unique()->bothify('VOU-####-????'),
            'description' => $this->faker->sentence(),
        ];
    }
}
