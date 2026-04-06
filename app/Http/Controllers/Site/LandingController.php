<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Academic\ClassRoom;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\CMS\CmsService;
use App\Services\Academic\GradeService;
use Illuminate\Contracts\View\View;

class LandingController extends Controller
{
    public function __construct(
        private readonly GradeService $gradeService,
        private readonly CmsService $cmsService,
    ) {}

    public function index(): View
    {
        // Gather statistics from the system
        $stats = [
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'classrooms' => ClassRoom::count(),
            'years' => setting('foundation_year') ? (date('Y') - setting('foundation_year')) : 20,
        ];

        $grades = $this->gradeService->getActive();

        // Load CMS data for the landing page
        $cmsPage = $this->cmsService->getLandingPage();
        $cmsSections = [];

        if ($cmsPage) {
            foreach ($cmsPage->sections as $section) {
                $cmsSections[$section->section_key] = $section;
            }
        }

        return view('site.welcome', compact('stats', 'grades', 'cmsSections'));
    }
}
