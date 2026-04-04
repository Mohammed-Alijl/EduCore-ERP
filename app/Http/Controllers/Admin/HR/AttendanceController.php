<?php

namespace App\Http\Controllers\Admin\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Attendance\ShowRequest;
use App\Http\Requests\Admin\Attendance\StoreRequest;
use App\Services\AttendanceService;
use App\Services\StudentService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AttendanceController extends Controller implements HasMiddleware
{
    protected $attendanceService;

    protected $studentService;

    public function __construct(AttendanceService $attendanceService, StudentService $studentService)
    {
        $this->attendanceService = $attendanceService;
        $this->studentService = $studentService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_attendances', only: ['index', 'getStudents']),
            new Middleware('permission:create_attendances', only: ['store']),
            new Middleware('permission:print_attendances', only: ['printSectionAttendance']),
        ];
    }

    /**
     * Show the filter page (Grade, Classroom and Section)
     */
    public function index()
    {
        $lookups = $this->studentService->getLookups();

        return view('admin.attendances.index', $lookups);
    }

    /**
     * Get Students in the section selected
     */
    public function getStudents(ShowRequest $request)
    {

        $students = $this->attendanceService->getStudentsForAttendance(
            $request->section_id,
            $request->attendance_date,
            $request->academic_year_id
        );

        $html = view('admin.attendances.partials._students_grid', compact('students'))->render();

        return response()->json(['status' => 'success', 'html' => $html]);
    }

    /**
     * Store the attendance sheet
     */
    public function store(StoreRequest $request)
    {
        try {
            $teacherId = null;

            $this->attendanceService->storeAttendance($request->validated(), $teacherId);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.attendances.messages.success.add'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?? trans('admin.attendances.messages.failed.add'),
            ], 500);
        }
    }

    /**
     * Print section attendance report
     */
    public function printSectionAttendance(ShowRequest $request)
    {
        try {
            $students = $this->attendanceService->getStudentsForAttendance(
                $request->section_id,
                $request->attendance_date,
                $request->academic_year_id
            );

            $html = view('admin.attendances.partials._print_attendance', compact('students'))->render();

            return response()->json([
                'status' => 'success',
                'html' => $html,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?? trans('admin.attendances.messages.error_print') ?? 'Error generating print document',
            ], 500);
        }
    }
}
