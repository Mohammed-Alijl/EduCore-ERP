<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Currency;
use App\Models\Finance\Receipt;
use App\Models\PaymentGateway;
use App\Models\Student;
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
            'student_id' => Student::inRandomOrder()->value('id') ?? Student::factory(),
            'academic_year_id' => AcademicYear::inRandomOrder()->value('id') ?? AcademicYear::factory(),
            'paid_amount' => $this->faker->randomFloat(2, 100, 2000),
            'currency_code' => Currency::inRandomOrder()->value('code') ?? 'USD',
            'exchange_rate' => 1.0000,
            'base_amount' => 100,
            'surcharge_amount' => 0,
            'payment_gateway_id' => PaymentGateway::inRandomOrder()->value('id') ?? 1,
            'transaction_id' => $this->faker->unique()->uuid(),
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
        ];
    }
}
