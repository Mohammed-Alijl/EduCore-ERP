<?php

namespace Database\Seeders;

use App\Models\EmployeeAttachment;
use Illuminate\Database\Seeder;

class EmployeeAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeAttachment::factory(5)->create();
    }
}
