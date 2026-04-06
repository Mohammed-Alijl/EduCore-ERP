<?php

namespace Database\Seeders;

use App\Models\StudentDiscount;
use Illuminate\Database\Seeder;

class StudentDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudentDiscount::factory(5)->create();
    }
}
