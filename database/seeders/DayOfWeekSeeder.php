<?php

namespace Database\Seeders;

use App\Models\Scheduling\DayOfWeek;
use Illuminate\Database\Seeder;

class DayOfWeekSeeder extends Seeder
{
    public function run(): void
    {
        $days = [
            [
                'key' => 'sunday',
                'day_number' => 0,
                'name' => ['en' => 'Sunday', 'ar' => 'الأحد'],
                'is_active' => true,
                'is_weekend' => false,
            ],
            [
                'key' => 'monday',
                'day_number' => 1,
                'name' => ['en' => 'Monday', 'ar' => 'الإثنين'],
                'is_active' => true,
                'is_weekend' => false,
            ],
            [
                'key' => 'tuesday',
                'day_number' => 2,
                'name' => ['en' => 'Tuesday', 'ar' => 'الثلاثاء'],
                'is_active' => true,
                'is_weekend' => false,
            ],
            [
                'key' => 'wednesday',
                'day_number' => 3,
                'name' => ['en' => 'Wednesday', 'ar' => 'الأربعاء'],
                'is_active' => true,
                'is_weekend' => false,
            ],
            [
                'key' => 'thursday',
                'day_number' => 4,
                'name' => ['en' => 'Thursday', 'ar' => 'الخميس'],
                'is_active' => true,
                'is_weekend' => false,
            ],
            [
                'key' => 'friday',
                'day_number' => 5,
                'name' => ['en' => 'Friday', 'ar' => 'الجمعة'],
                'is_active' => false,
                'is_weekend' => true,
            ],
            [
                'key' => 'saturday',
                'day_number' => 6,
                'name' => ['en' => 'Saturday', 'ar' => 'السبت'],
                'is_active' => true,
                'is_weekend' => false,
            ],
        ];

        foreach ($days as $day) {
            DayOfWeek::updateOrCreate(
                ['key' => $day['key']],
                $day
            );
        }
    }
}
