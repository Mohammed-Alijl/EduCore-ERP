<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralSetting::updateOrCreate(
            ['id' => 1],
            [
                'school_name' => [
                    'en' => 'School Management System',
                    'ar' => 'نظام إدارة المدرسة',
                ],
                'email' => 'info@school.example.com',
                'phone' => '+1234567890',
                'address' => [
                    'en' => '123 Education Street, City',
                    'ar' => '123 شارع التعليم، المدينة',
                ],
                'social_media' => [
                    'facebook' => null,
                    'twitter' => null,
                    'instagram' => null,
                    'linkedin' => null,
                ],
            ]
        );
    }
}
