<?php

namespace Database\Factories;

use App\Models\PaymentGateway;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentGateway>
 */
class PaymentGatewayFactory extends Factory
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
                'en' => $this->faker->company() . ' Gateway',
                'ar' => 'بوابة دفع ' . $this->faker->company(),
            ],
            'code' => $this->faker->unique()->word(),
            'settings' => ['public_key' => 'test', 'secret_key' => 'test'],
            'surcharge_percentage' => $this->faker->randomFloat(2, 0, 5),
            'status' => 1,
        ];
    }
}
