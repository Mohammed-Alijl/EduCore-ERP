<?php

namespace App\Http\Controllers\Admin\System;

use App\DTOs\ActivityLogFilterDTO;
use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ActivityLogController extends Controller implements HasMiddleware
{
    public function __construct(protected readonly ActivityLogService $activityLogService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_activityLogs', only: ['index', 'datatable', 'show']),
            new Middleware('permission:export_activityLogs', only: ['export']),
            new Middleware('permission:delete_activityLogs', only: ['cleanup']),
        ];
    }

    /**
     * Display activity logs listing page.
     */
    public function index()
    {
        $logNames = $this->activityLogService->getAvailableLogNames();
        $events = $this->activityLogService->getAvailableEvents();

        return view('admin.activity_logs.index', compact('logNames', 'events'));
    }

    /**
     * Get activity logs data for DataTable.
     */
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $filters = ActivityLogFilterDTO::fromArray($request->all());

            return $this->activityLogService->datatable($filters);
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Display a single activity log.
     */
    public function show(Request $request, int $id)
    {
        $log = $this->activityLogService->getLogById($id);

        if (! $log) {
            abort(404, 'Activity log not found.');
        }

        if ($request->ajax()) {
            return view('admin.activity_logs.partials.ajax_details', compact('log'));
        }

        return view('admin.activity_logs.show', compact('log'));
    }

    /**
     * Get activity logs for a specific subject.
     */
    public function forSubject(Request $request)
    {
        $request->validate([
            'subject_type' => 'required|string',
            'subject_id' => 'required|integer',
        ]);

        $logs = $this->activityLogService->getLogsForSubject(
            $request->input('subject_type'),
            $request->input('subject_id')
        );

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $logs,
            ]);
        }

        return view('admin.activity_logs.subject_logs', compact('logs'));
    }

    /**
     * Get activity logs by a specific user.
     */
    public function byCauser(Request $request)
    {
        $request->validate([
            'causer_type' => 'required|string',
            'causer_id' => 'required|integer',
        ]);

        $logs = $this->activityLogService->getLogsByCauser(
            $request->input('causer_type'),
            $request->input('causer_id')
        );

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $logs,
            ]);
        }

        return view('admin.activity_logs.causer_logs', compact('logs'));
    }

    /**
     * Get summary statistics.
     */
    public function statistics(Request $request)
    {
        $filters = ActivityLogFilterDTO::fromArray($request->all());
        $statistics = $this->activityLogService->getSummaryStatistics($filters);

        return response()->json([
            'status' => 'success',
            'data' => $statistics,
        ]);
    }

    /**
     * Clean up old activity logs.
     */
    public function cleanup(Request $request)
    {
        $request->validate([
            'days_to_keep' => 'required|integer|min:1|max:365',
        ]);

        try {
            $deletedCount = $this->activityLogService->cleanupOldLogs(
                $request->integer('days_to_keep')
            );

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.activity_logs.messages.success.cleanup', ['count' => $deletedCount]),
                'deleted_count' => $deletedCount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => trans('admin.activity_logs.messages.failed.cleanup'),
            ], 500);
        }
    }
}
