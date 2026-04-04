<?php

namespace App\Http\Controllers\Admin\LMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OnlineClass\DatatableRequest;
use App\Models\OnlineClass;
use App\Services\OnlineClassService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class OnlineClassController extends Controller implements HasMiddleware
{
    public function __construct(protected OnlineClassService $onlineClassService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_online_classes', only: ['index', 'datatable', 'show']),
            new Middleware('permission:delete_online_classes', only: ['destroy']),
        ];
    }


    public function index()
    {
        $lookups = $this->onlineClassService->getLookups();

        return view('admin.online_classes.index', $lookups);
    }


    public function datatable(DatatableRequest $request)
    {
        if ($request->ajax()) {
            $query = $this->onlineClassService->getOnlineClassesQuery($request->validated());

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('academic_year', fn($row) => $row->academicYear->name ?? '-')
                ->addColumn('grade_info', fn($row) => $row->grade->name . ' - ' . $row->classroom->name . ' - ' . $row->section->name)
                ->addColumn('teacher', fn($row) => $row->teacher->name)
                ->addColumn('subject', fn($row) => $row->subject->name)
                ->addColumn('timing', fn($row) => $row->start_at->format('Y-m-d h:i A') . ' (' . $row->duration . trans('admin.online_classes.minutes') . ')')
                ->addColumn('integration', function ($row) {
                    return $row->integration_type == OnlineClass::INTEGRATION_ZOOM
                        ? '<span class="badge badge-primary"><i class="las la-video"></i> Zoom</span>'
                        : '<span class="badge badge-secondary"><i class="las la-link"></i> redirect link</span>';
                })
                ->addColumn('join_link', function ($row) {
                    return '<a href="' . $row->join_url . '" target="_blank" class="btn btn-sm btn-success" title="Join"><i class="las la-sign-in-alt"></i></a>';
                })
                ->addColumn('actions', function ($row) {
                    return view('admin.online_classes.partials.index_actions', compact('row'))->render();
                })
                ->rawColumns(['integration', 'join_link', 'actions'])
                ->make(true);
        }
    }


    public function show(OnlineClass $onlineClass)
    {
        $onlineClass->load(['academicYear', 'grade', 'classroom', 'section', 'teacher', 'subject']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $onlineClass->id,
                'academic_year' => $onlineClass->academicYear->name ?? '-',
                'grade' => $onlineClass->grade->name ?? '-',
                'classroom' => $onlineClass->classroom->name ?? '-',
                'section' => $onlineClass->section->name ?? '-',
                'teacher' => $onlineClass->teacher->name ?? '-',
                'subject' => $onlineClass->subject->name ?? '-',
                'integration' => $onlineClass->integration_type == OnlineClass::INTEGRATION_ZOOM ? 'Zoom' : 'Manual',
                'start_at' => $onlineClass->start_at?->format('Y-m-d h:i A') ?? '-',
                'duration' => $onlineClass->duration,
                'join_url' => $onlineClass->join_url,
            ],
        ]);
    }


    public function destroy(OnlineClass $onlineClass)
    {
        $success = $this->onlineClassService->deleteOnlineClass($onlineClass);

        if ($success) {
            return response()->json([
                'status' => 'success',
                'message' => trans('admin.online_classes.message.success.delete')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => trans('admin.online_classes.message.failed.delete')
        ], 500);
    }
}
