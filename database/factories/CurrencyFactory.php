<?php

namespace Database\Factories;

use App\Models\Finance\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->currencyCode(),
            'name' => [
                'en' => ucfirst($this->faker->word()).' Currency',
                'ar' => 'عملة '.$this->faker->word(),
            ],
            'is_default' => 0,
            'exchange_rate' => $this->faker->randomFloat(4, 0.5, 5),
            'status' => 1,
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
