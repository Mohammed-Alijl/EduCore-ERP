<?php

namespace Database\Seeders;

use App\Models\Assessments\Exam;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Exam::factory(50)->create();
    }
}
