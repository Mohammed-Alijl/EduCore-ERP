<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use App\Models\CmsSection;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Landing Page ───
        $landingPage = CmsPage::firstOrCreate(
            ['slug' => 'landing'],
            [
                'title' => ['en' => 'Landing Page', 'ar' => 'الصفحة الرئيسية'],
                'type' => 'landing',
                'is_published' => true,
            ]
        );

        $sections = [
            [
                'section_key' => 'hero',
                'title' => ['en' => 'Hero Section', 'ar' => 'القسم الرئيسي'],
                'sort_order' => 1,
                'content' => ['tagline' => null, 'cta_primary' => null, 'cta_secondary' => null],
                'images' => ['background' => null],
                'settings' => ['show_stats' => true, 'show_scroll_indicator' => true],
            ],
            [
                'section_key' => 'features',
                'title' => ['en' => 'Features', 'ar' => 'المميزات'],
                'sort_order' => 2,
                'content' => ['items' => null],
                'settings' => [],
            ],
            [
                'section_key' => 'about',
                'title' => ['en' => 'About Us', 'ar' => 'من نحن'],
                'sort_order' => 3,
                'content' => ['values' => null, 'description' => null],
                'images' => ['main' => null, 'secondary_1' => null, 'secondary_2' => null],
                'settings' => [],
            ],
            [
                'section_key' => 'stats',
                'title' => ['en' => 'Statistics', 'ar' => 'الإحصائيات'],
                'sort_order' => 4,
                'content' => ['custom_stats' => null],
                'settings' => ['use_live_stats' => true],
            ],
            [
                'section_key' => 'programs',
                'title' => ['en' => 'Programs', 'ar' => 'البرامج'],
                'sort_order' => 5,
                'content' => [],
                'settings' => ['show_student_count' => true],
            ],
            [
                'section_key' => 'testimonials',
                'title' => ['en' => 'Testimonials', 'ar' => 'آراء العملاء'],
                'sort_order' => 6,
                'content' => ['items' => null],
                'settings' => ['autoplay_speed' => 5000],
            ],
            [
                'section_key' => 'faq',
                'title' => ['en' => 'FAQ', 'ar' => 'الأسئلة الشائعة'],
                'sort_order' => 7,
                'content' => ['items' => null],
                'settings' => [],
            ],
            [
                'section_key' => 'newsletter',
                'title' => ['en' => 'Newsletter', 'ar' => 'النشرة البريدية'],
                'sort_order' => 8,
                'content' => [],
                'settings' => [],
            ],
            [
                'section_key' => 'contact',
                'title' => ['en' => 'Contact', 'ar' => 'اتصل بنا'],
                'sort_order' => 9,
                'content' => ['social_links' => null, 'map_url' => null],
                'settings' => ['show_contact_form' => true],
            ],
            [
                'section_key' => 'footer',
                'title' => ['en' => 'Footer', 'ar' => 'التذييل'],
                'sort_order' => 10,
                'content' => ['copyright_text' => null, 'quick_links' => null],
                'settings' => [],
            ],
        ];

        foreach ($sections as $section) {
            CmsSection::firstOrCreate(
                [
                    'cms_page_id' => $landingPage->id,
                    'section_key' => $section['section_key'],
                ],
                array_merge($section, ['cms_page_id' => $landingPage->id])
            );
        }

        // ─── Legal Pages ───
        $legalPages = [
            [
                'slug' => 'privacy-policy',
                'title' => ['en' => 'Privacy Policy', 'ar' => 'سياسة الخصوصية'],
                'content' => ['en' => null, 'ar' => null],
                'meta_description' => ['en' => 'Our privacy policy', 'ar' => 'سياسة الخصوصية الخاصة بنا'],
            ],
            [
                'slug' => 'terms-of-service',
                'title' => ['en' => 'Terms of Service', 'ar' => 'شروط الخدمة'],
                'content' => ['en' => null, 'ar' => null],
                'meta_description' => ['en' => 'Our terms of service', 'ar' => 'شروط الخدمة الخاصة بنا'],
            ],
            [
                'slug' => 'cookie-policy',
                'title' => ['en' => 'Cookie Policy', 'ar' => 'سياسة ملفات تعريف الارتباط'],
                'content' => ['en' => null, 'ar' => null],
                'meta_description' => ['en' => 'Our cookie policy', 'ar' => 'سياسة ملفات تعريف الارتباط الخاصة بنا'],
            ],
        ];

        foreach ($legalPages as $page) {
            CmsPage::firstOrCreate(
                ['slug' => $page['slug']],
                array_merge($page, ['type' => 'legal', 'is_published' => true])
            );
        }
    }
}
