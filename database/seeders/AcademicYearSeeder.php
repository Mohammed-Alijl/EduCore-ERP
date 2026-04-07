<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $years = [
            [
                'name' => '2024-2025',
                'starts_at' => '2024-09-01',
                'ends_at' => '2025-06-30',
                'is_current' => false,
            ],
            [
                'name' => '2025-2026',
                'starts_at' => '2025-09-01',
                'ends_at' => '2026-06-30',
                'is_current' => true,
            ],
            [
                'name' => '2026-2027',
                'starts_at' => '2026-09-01',
                'ends_at' => '2027-06-30',
                'is_current' => false,
            ],
        ];

        foreach ($years as $year) {
            DB::table('academic_years')->updateOrInsert(
                ['name' => $year['name']],
                array_merge($year, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
