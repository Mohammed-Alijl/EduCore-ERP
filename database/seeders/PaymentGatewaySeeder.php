<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    public function run(): void
    {
        $gateways = [
            [
                'name'                 => ['en' => 'Cash', 'ar' => 'نقدي'],
                'code'                 => 'cash',
                'settings'             => null,
                'surcharge_percentage' => 0.00,
                'status'               => true,
            ],
            [
                'name'                 => ['en' => 'Bank Transfer', 'ar' => 'تحويل بنكي'],
                'code'                 => 'bank_transfer',
                'settings'             => ['bank_name' => '', 'account_number' => '', 'iban' => ''],
                'surcharge_percentage' => 0.00,
                'status'               => true,
            ],
            [
                'name'                 => ['en' => 'Stripe', 'ar' => 'سترايب'],
                'code'                 => 'stripe',
                'settings'             => ['publishable_key' => '', 'secret_key' => '', 'webhook_secret' => ''],
                'surcharge_percentage' => 2.90,
                'status'               => false,
            ],
        ];

        foreach ($gateways as $gateway) {
            PaymentGateway::updateOrCreate(
                ['code' => $gateway['code']],
                $gateway,
            );
        }
    }
}
