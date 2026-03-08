<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\OnlineClass;
use Illuminate\Database\Seeder;

class OnlineClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OnlineClass::factory()->count(50)->create();
    }
}
