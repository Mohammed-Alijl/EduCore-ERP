<?php

namespace App\Http\Controllers\Admin\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClassPeriod\StoreRequest;
use App\Http\Requests\Admin\ClassPeriod\UpdateRequest;
use App\Models\Scheduling\ClassPeriod;
use App\Models\Academic\Grade;
use App\Services\Schedule\ClassPeriodService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ClassPeriodController extends Controller implements HasMiddleware
{
    public function __construct(protected ClassPeriodService $classPeriodService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_classPeriods', only: ['index', 'datatable']),
            new Middleware('permission:create_classPeriods', only: ['store']),
            new Middleware('permission:edit_classPeriods', only: ['update']),
            new Middleware('permission:delete_classPeriods', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $grades = Grade::query()->active()->get(['id', 'name']);

        return view('admin.Schedule.class_periods.index', compact('grades'));
    }

    /**
     * Get DataTable data.
     */
    public function datatable(Request $request): mixed
    {
        if ($request->ajax()) {
            $query = $this->classPeriodService->getQuery($request->only([
                'grade_id',
                'is_break',
                'status',
            ]));

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    $icon = $row->is_break
                        ? '<i class="las la-coffee text-warning mr-1 ml-1"></i>'
                        : '<i class="las la-clock text-primary mr-1 ml-1"></i>';

                    return $icon . '<span class="font-weight-bold">' . e($row->name) . '</span>';
                })
                ->addColumn('grade', function ($row) {
                    if ($row->grade) {
                        return '<span class="badge badge-primary-light">' . e($row->grade->name) . '</span>';
                    }

                    return '<span class="badge badge-secondary-light">' . trans('admin.Schedule.class_periods.all_grades') . '</span>';
                })
                ->addColumn('time_range', function ($row) {
                    return '<span class="time-badge">'
                        . '<i class="las la-hourglass-start"></i> '
                        . $row->start_time->format('H:i')
                        . ' <i class="las la-arrow-right mx-1"></i> '
                        . $row->end_time->format('H:i')
                        . '</span>';
                })
                ->addColumn('duration', function ($row) {
                    return '<span class="duration-badge">' . $row->duration . ' ' . trans('admin.Schedule.class_periods.minutes') . '</span>';
                })
                ->addColumn('type', function ($row) {
                    if ($row->is_break) {
                        return '<span class="badge badge-warning-light"><i class="las la-coffee mr-1 ml-1"></i>' . trans('admin.Schedule.class_periods.break') . '</span>';
                    }

                    return '<span class="badge badge-success-light"><i class="las la-book mr-1 ml-1"></i>' . trans('admin.Schedule.class_periods.class') . '</span>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status) {
                        return '<span class="badge badge-success">' . trans('admin.global.active') . '</span>';
                    }

                    return '<span class="badge badge-danger">' . trans('admin.global.disabled') . '</span>';
                })
                ->addColumn('actions', function ($row) {
                    $actions = '';

                    if (auth('admin')->user()->can('edit_classPeriods')) {
                        $actions .= '<a class="btn btn-outline-info btn-sm action-btn edit-btn" href="#"
                            data-toggle="modal" data-target="#editClassPeriodModal"
                            data-url="' . route('admin.schedule.class_periods.update', $row->id) . '"
                            data-name_en="' . e($row->getTranslation('name', 'en')) . '"
                            data-name_ar="' . e($row->getTranslation('name', 'ar')) . '"
                            data-start_time="' . $row->start_time->format('H:i') . '"
                            data-end_time="' . $row->end_time->format('H:i') . '"
                            data-duration="' . $row->duration . '"
                            data-grade_id="' . $row->grade_id . '"
                            data-is_break="' . $row->is_break . '"
                            data-status="' . $row->status . '"
                            data-sort_order="' . $row->sort_order . '"
                            title="' . trans('admin.Schedule.class_periods.edit') . '">
                            <i class="las la-pen"></i>
                        </a>';
                    }

                    if (auth('admin')->user()->can('delete_classPeriods')) {
                        $actions .= '<a class="btn btn-outline-danger btn-sm action-btn delete-item" href="#"
                            data-id="' . $row->id . '"
                            data-url="' . route('admin.schedule.class_periods.destroy', $row->id) . '"
                            data-name="' . e($row->name) . '"
                            title="' . trans('admin.Schedule.class_periods.delete') . '">
                            <i class="las la-trash"></i>
                        </a>';
                    }

                    return '<div class="action-buttons">' . $actions . '</div>';
                })
                ->rawColumns(['name', 'grade', 'time_range', 'duration', 'type', 'status', 'actions'])
                ->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $this->classPeriodService->store($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Schedule.class_periods.messages.success.add'),
            ]);
        } catch (\Exception $e) {
            Log::error('ClassPeriod store failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Schedule.class_periods.messages.failed.add'),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, ClassPeriod $classPeriod): JsonResponse
    {
        try {
            $this->classPeriodService->update($classPeriod, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Schedule.class_periods.messages.success.update'),
            ]);
        } catch (\Exception $e) {
            Log::error('ClassPeriod update failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Schedule.class_periods.messages.failed.update'),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassPeriod $classPeriod): JsonResponse
    {
        try {
            $this->classPeriodService->delete($classPeriod);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Schedule.class_periods.messages.success.delete'),
            ]);
        } catch (\Exception $e) {
            Log::error('ClassPeriod delete failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Schedule.class_periods.messages.failed.delete'),
            ], 500);
        }
    }
}
