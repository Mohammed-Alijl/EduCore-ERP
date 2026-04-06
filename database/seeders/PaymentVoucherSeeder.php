<?php

namespace Database\Seeders;

use App\Models\PaymentVoucher;
use Illuminate\Database\Seeder;

class PaymentVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentVoucher::factory(10)->create();
    }
}
