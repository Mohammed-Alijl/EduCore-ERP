<?php

namespace Database\Seeders;

use App\Models\Settings\ExternalApiSetting;
use Illuminate\Database\Seeder;

class ExternalApiSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apis = [
            [
                'name' => ['en' => 'Mailgun', 'ar' => 'ميل جن'],
                'slug' => 'mailgun',
                'credentials' => [
                    'domain' => '',
                    'secret' => '',
                    'endpoint' => 'api.mailgun.net',
                ],
                'is_active' => true,
                'description' => ['en' => 'Transactional email service.', 'ar' => 'خدمة البريد الإلكتروني للمعاملات.'],
            ],
            [
                'name' => ['en' => 'Zoom', 'ar' => 'زووم'],
                'slug' => 'zoom',
                'credentials' => [
                    'client_id' => '',
                    'client_secret' => '',
                    'account_id' => '',
                ],
                'is_active' => true,
                'description' => ['en' => 'Video conferencing and online classes.', 'ar' => 'مؤتمرات الفيديو والفصول الدراسية عبر الإنترنت.'],
            ],
            [
                'name' => ['en' => 'Firebase', 'ar' => 'فايربيس'],
                'slug' => 'firebase',
                'credentials' => [
                    'api_key' => '',
                    'project_id' => '',
                    'messaging_sender_id' => '',
                    'app_id' => '',
                ],
                'is_active' => false,
                'description' => ['en' => 'Cloud messaging and push notifications.', 'ar' => 'رسائل السحابة وإشعارات الدفع.'],
            ],
        ];

        foreach ($apis as $api) {
            ExternalApiSetting::updateOrCreate(['slug' => $api['slug']], $api);
        }
    }
}
