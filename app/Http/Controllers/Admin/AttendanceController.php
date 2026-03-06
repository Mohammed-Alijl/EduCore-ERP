<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Attendance\StoreRequest;
use App\Http\Requests\Admin\Attendance\ShowRequest;
use App\Services\AttendanceService;
use App\Services\StudentService;

class AttendanceController extends Controller
{
    protected $attendanceService;
    protected $studentService;

    public function __construct(AttendanceService $attendanceService, StudentService $studentService)
    {
        $this->attendanceService = $attendanceService;
        $this->studentService = $studentService;
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
            $request->attendance_date
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
                'message' => trans('admin.attendances.messages.success.add')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?? trans('admin.attendances.messages.failed.add')
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
                $request->attendance_date
            );

            $html = view('admin.attendances.partials._print_attendance', compact('students'))->render();

            return response()->json([
                'status' => 'success',
                'html' => $html
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?? trans('admin.attendances.messages.error_print') ?? 'Error generating print document'
            ], 500);
        }
    }
}
