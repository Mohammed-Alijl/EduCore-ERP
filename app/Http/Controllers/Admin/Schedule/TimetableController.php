<?php

namespace App\Http\Controllers\Admin\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Timetable\StoreRequest;
use App\Http\Requests\Admin\Timetable\UpdateRequest;
use App\Models\Grade;
use App\Models\Timetable;
use App\Services\AcademicYearService;
use App\Services\GradeService;
use App\Services\TimetableService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TimetableController extends Controller implements HasMiddleware
{
    public function __construct(
        protected TimetableService $timetableService,
        protected AcademicYearService $academicYearService,
        protected GradeService $gradeService,

    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_timetables', only: ['index', 'matrix', 'getClassrooms', 'getSections', 'getSubjects', 'getTeachers']),
            new Middleware('permission:create_timetables', only: ['store']),
            new Middleware('permission:edit_timetables', only: ['update']),
            new Middleware('permission:delete_timetables', only: ['destroy']),
        ];
    }

    /**
     * Display the timetable management page.
     */
    public function index(): View
    {
        $grades = Grade::query()->active()->orderBy('sort_order')->get(['id', 'name']);
        $currentAcademicYear = $this->academicYearService->getCurrent();

        return view('admin.schedule.timetables.index', compact('grades', 'currentAcademicYear'));
    }

    /**
     * Get timetable matrix data for a section.
     */
    public function matrix(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'section_id' => 'required|exists:sections,id',
                'academic_year_id' => 'required|exists:academic_years,id',
            ]);

            $data = $this->timetableService->getMatrixData(
                $request->integer('section_id'),
                $request->integer('academic_year_id')
            );

            // Format periods for JSON response
            $periods = $data['periods']->map(function ($period) {
                return [
                    'id' => $period->id,
                    'name' => $period->name,
                    'start_time' => $period->start_time->format('H:i'),
                    'end_time' => $period->end_time->format('H:i'),
                    'formatted_time_range' => $period->formatted_time_range,
                    'is_break' => $period->is_break,
                    'duration' => $period->duration,
                ];
            });

            // Format days for JSON response
            $days = $data['days']->map(function ($day) {
                return [
                    'id' => $day->id,
                    'name' => $day->name,
                    'day_number' => $day->day_number,
                ];
            });

            return response()->json([
                'success' => true,
                'section' => [
                    'id' => $data['section']->id,
                    'name' => $data['section']->name,
                    'grade' => $data['section']->grade->name,
                    'classroom' => $data['section']->classroom->name,
                ],
                'periods' => $periods,
                'days' => $days,
                'slots' => $data['slots'],
            ]);
        } catch (\Exception $e) {
            Log::error('Timetable matrix error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => trans('admin.timetables.errors.fetch_failed'),
            ], 500);
        }
    }

    /**
     * Store a new timetable slot.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $timetable = $this->timetableService->assignSlot($request->validated());

            return response()->json([
                'success' => true,
                'message' => trans('admin.timetables.messages.success.created'),
                'data' => $timetable->load(['subject', 'teacher']),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Timetable store error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => trans('admin.timetables.errors.save_failed'),
            ], 500);
        }
    }

    /**
     * Update an existing timetable slot.
     */
    public function update(UpdateRequest $request, Timetable $timetable): JsonResponse
    {
        try {
            $data = $request->validated();

            // Add the fixed fields from the existing timetable
            $data['day_of_week_id'] = $timetable->day_of_week_id;
            $data['class_period_id'] = $timetable->class_period_id;
            $data['section_id'] = $timetable->section_id;
            $data['academic_year_id'] = $timetable->academic_year_id;

            $timetable = $this->timetableService->updateSlot($timetable, $data);

            return response()->json([
                'success' => true,
                'message' => trans('admin.timetables.messages.success.updated'),
                'data' => $timetable->load(['subject', 'teacher']),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Timetable update error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => trans('admin.timetables.errors.update_failed'),
            ], 500);
        }
    }

    /**
     * Remove a timetable slot.
     */
    public function destroy(Timetable $timetable): JsonResponse
    {
        try {
            $this->timetableService->deleteSlot($timetable);

            return response()->json([
                'success' => true,
                'message' => trans('admin.timetables.messages.success.deleted'),
            ]);
        } catch (\Exception $e) {
            Log::error('Timetable delete error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => trans('admin.timetables.errors.delete_failed'),
            ], 500);
        }
    }

    /**
     * Get subjects for a section (AJAX endpoint).
     */
    public function getSubjects(Request $request): JsonResponse
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
        ]);

        $subjects = $this->timetableService->getAvailableSubjects($request->integer('section_id'));

        return response()->json([
            'success' => true,
            'data' => $subjects,
        ]);
    }

    /**
     * Get teachers for a subject (AJAX endpoint).
     */
    public function getTeachers(Request $request): JsonResponse
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $teachers = $this->timetableService->getAvailableTeachers($request->integer('subject_id'));

        return response()->json([
            'success' => true,
            'data' => $teachers,
        ]);
    }
}
