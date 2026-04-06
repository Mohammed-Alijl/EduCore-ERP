<?php

namespace Database\Seeders;

use App\Models\SystemData\Gender;
use App\Models\SystemData\Nationality;
use App\Models\SystemData\Religion;
use App\Models\SystemData\TypeBlood;
use Illuminate\Database\Seeder;

class LookupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ==========================================
        // 1. Blood Types
        // ==========================================
        $bloodTypes = ['O-', 'O+', 'A-', 'A+', 'B-', 'B+', 'AB-', 'AB+'];

        foreach ($bloodTypes as $type) {
            TypeBlood::firstOrCreate(['name' => $type]);
        }

        // ==========================================
        // 2. Religions
        // ==========================================
        $religions = [
            ['en' => 'Muslim', 'ar' => 'مسلم'],
            ['en' => 'Christian', 'ar' => 'مسيحي'],
            ['en' => 'Other', 'ar' => 'غير ذلك'],
        ];

        foreach ($religions as $religion) {
            Religion::firstOrCreate(
                ['name->en' => $religion['en']],
                ['name' => $religion]
            );
        }

        // ==========================================
        // 3. Nationalities
        // ==========================================
        $nationalities = [
            ['en' => 'Palestinian', 'ar' => 'فلسطيني'],
            ['en' => 'Egyptian', 'ar' => 'مصري'],
            ['en' => 'Saudi', 'ar' => 'سعودي'],
            ['en' => 'Jordanian', 'ar' => 'أردني'],
            ['en' => 'Syrian', 'ar' => 'سوري'],
            ['en' => 'Lebanese', 'ar' => 'لبناني'],
            ['en' => 'Iraqi', 'ar' => 'عراقي'],
            ['en' => 'Emirati', 'ar' => 'إماراتي'],
            ['en' => 'Qatari', 'ar' => 'قطري'],
            ['en' => 'Kuwaiti', 'ar' => 'كويتي'],
            ['en' => 'Omani', 'ar' => 'عماني'],
            ['en' => 'Yemeni', 'ar' => 'يمني'],
            ['en' => 'Sudanese', 'ar' => 'سوداني'],
            ['en' => 'Moroccan', 'ar' => 'مغربي'],
            ['en' => 'Algerian', 'ar' => 'جزائري'],
            ['en' => 'Tunisian', 'ar' => 'تونسي'],
            ['en' => 'Libyan', 'ar' => 'ليبي'],
            ['en' => 'American', 'ar' => 'أمريكي'],
            ['en' => 'British', 'ar' => 'بريطاني'],
            ['en' => 'Other', 'ar' => 'أخرى'],
        ];

        foreach ($nationalities as $nationality) {
            Nationality::firstOrCreate(
                ['name->en' => $nationality['en']],
                ['name' => $nationality]
            );
        }

        // ==========================================
        // 4. Gender
        // ==========================================
        $genders = [
            ['en' => 'Male', 'ar' => 'ذكر'],
            ['en' => 'Female', 'ar' => 'أنثى'],
            ['en' => 'Other', 'ar' => 'أخرى'],
        ];

        foreach ($genders as $gender) {
            Gender::firstOrCreate(
                ['name->en' => $gender['en']],
                ['name' => $gender]
            );
        }
    }
}
