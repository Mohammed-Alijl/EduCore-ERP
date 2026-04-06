<?php

namespace Database\Seeders;

use App\Models\Finance\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        Currency::firstOrCreate(
            ['code' => 'USD'],
            [
                'name' => ['ar' => 'دولار أمريكي', 'en' => 'US Dollar'],
                'exchange_rate' => 1.0000,
                'is_default' => true,
                'status' => true,
                'sort_order' => 0,
            ]
        );
    }
}
