<?php

namespace App\Http\Controllers\Admin\Exams;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Exam\ExamDatatableRequest;
use App\Http\Requests\Admin\Exam\ResetAttemptRequest;
use App\Models\Assessments\Exam;
use App\Services\Exams\ExamService;
use App\Services\Users\StudentService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class ExamController extends Controller implements HasMiddleware
{
    protected $adminExamService;
    protected $studentService;

    public function __construct(ExamService $adminExamService, StudentService $studentService)
    {
        $this->adminExamService = $adminExamService;
        $this->studentService = $studentService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_exams', only: ['index', 'datatable']),
            new Middleware('permission:view-student-attempts_exams', only: ['showAttempts']),
            new Middleware('permission:reset-attempts_exams', only: ['resetAttempt']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lookups = $this->studentService->getLookups();

        return view('admin.Exams.exams.index', $lookups);
    }


    public function datatable(ExamDatatableRequest $request)
    {
        if ($request->ajax()) {
            $query = $this->adminExamService->getExamsQuery($request->all());

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('academic_year', function ($row) {
                    return $row->academicYear->name ?? '-';
                })
                ->addColumn('teacher', function ($row) {
                    return $row->teacher->name;
                })
                ->addColumn('subject', function ($row) {
                    return $row->subject->name;
                })
                ->addColumn('time_window', function ($row) {
                    return $row->start_time->format('Y-m-d H:i') . " <br> To <br>" . $row->end_time->format('Y-m-d H:i');
                })
                ->addColumn('status', function ($row) {
                    return $row->is_published
                        ? '<span class="badge badge-success">' . trans('admin.Exams.exams.published') . '</span>'
                        : '<span class="badge badge-warning">' . trans('admin.Exams.exams.draft') . '</span>';
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="' . route('admin.Exams.exams.attempts', $row->id) . '" class="btn btn-sm btn-info" title="Show Attemptes"><i class="las la-users"></i></a>';
                    return $btn;
                })
                ->rawColumns(['time_window', 'status', 'actions'])
                ->make(true);
        }
    }

    /**
     * Display the student attempts.
     */
    public function showAttempts(Exam $exam)
    {
        $exam->load('subject', 'academicYear');
        $attempts = $exam->attempts()->with('student')->get();

        return view('admin.Exams.exams.attempts', compact('exam', 'attempts'));
    }


    /**
     * Reset Student Attempt By The Admin.
     */
    public function resetAttempt(ResetAttemptRequest $request, Exam $exam)
    {

        $success = $this->adminExamService->resetStudentAttempt($exam->id, $request->student_id);

        if ($success) {
            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Exams.exams.messages.success.attempt_reset')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => trans('admin.Exams.exams.messages.failed.attempt_reset')
        ], 500);
    }
}
