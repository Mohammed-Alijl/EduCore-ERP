<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\GradeService;
use Illuminate\Contracts\View\View;

class LandingController extends Controller
{
    public function __construct(private readonly GradeService $gradeService) {}

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

        return view('site.welcome', compact('stats', 'grades'));
    }
}
