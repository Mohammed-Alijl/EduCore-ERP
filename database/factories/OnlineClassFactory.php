<?php

namespace Database\Factories;

use App\Models\Academic\AcademicYear;
use App\Models\Academic\ClassRoom;
use App\Models\Academic\Grade;
use App\Models\Academic\Section;
use App\Models\Academic\Subject;
use App\Models\Scheduling\OnlineClass;
use App\Models\Users\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\OnlineClass>
 */
class OnlineClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = OnlineClass::class;

    public function definition(): array
    {
        $integrationType = $this->faker->randomElement([OnlineClass::INTEGRATION_ZOOM, OnlineClass::INTEGRATION_MANUAL]);

        return [
            'integration_type' => $integrationType,
            // نأخذ ID عشوائي من الجداول، وإذا كانت فارغة نضع 1 كـ Fallback
            'academic_year_id' => AcademicYear::inRandomOrder()->first()->id ?? 1,
            'grade_id' => Grade::inRandomOrder()->first()->id ?? 1,
            'classroom_id' => ClassRoom::inRandomOrder()->first()->id ?? 1,
            'section_id' => Section::inRandomOrder()->first()->id ?? 1,
            'teacher_id' => Teacher::inRandomOrder()->first()->id ?? 1,
            'subject_id' => Subject::inRandomOrder()->first()->id ?? 1,

            'topic' => $this->faker->sentence(4).' (بيانات تجريبية)',
            'start_at' => $this->faker->dateTimeBetween('-1 week', '+2 weeks'), // حصص سابقة وقادمة
            'duration' => $this->faker->randomElement([30, 40, 45, 60]),

            // اللوجيك الذكي للروابط بناءً على نوع الربط
            'meeting_id' => $integrationType == OnlineClass::INTEGRATION_ZOOM ? $this->faker->numerify('###-###-####') : null,
            'start_url' => $integrationType == OnlineClass::INTEGRATION_ZOOM ? 'https://zoom.us/s/'.$this->faker->uuid : null,
            'join_url' => $integrationType == OnlineClass::INTEGRATION_ZOOM
                ? 'https://zoom.us/j/'.$this->faker->uuid
                : 'https://meet.google.com/'.$this->faker->lexify('???-????-???'),
        ];
    }
}
