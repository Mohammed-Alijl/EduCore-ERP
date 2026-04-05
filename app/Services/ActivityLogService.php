<?php

namespace App\Services;

use App\DTOs\ActivityLogFilterDTO;
use App\Repositories\Contracts\ActivityLogRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogService
{
    public function __construct(
        protected readonly ActivityLogRepositoryInterface $repository
    ) {}

    /**
     * Get paginated activity logs with filters.
     */
    public function getPaginatedLogs(ActivityLogFilterDTO $filters): LengthAwarePaginator
    {
        return $this->repository->getPaginated(
            $filters->toArray(),
            $filters->perPage
        );
    }

    /**
     * Get all activity logs with filters.
     */
    public function getAllLogs(ActivityLogFilterDTO $filters): Collection
    {
        return $this->repository->getAll($filters->toArray());
    }

    /**
     * Get activity log by ID.
     */
    public function getLogById(int $id): ?Activity
    {
        return $this->repository->findById($id);
    }

    /**
     * Get activity logs for a specific subject (e.g., Invoice, Currency).
     */
    public function getLogsForSubject(string $subjectType, int $subjectId): Collection
    {
        return $this->repository->getForSubject($subjectType, $subjectId);
    }

    /**
     * Get activity logs by a specific user.
     */
    public function getLogsByCauser(string $causerType, int $causerId): Collection
    {
        return $this->repository->getByCauser($causerType, $causerId);
    }

    /**
     * Get activity logs by log name (e.g., "Finance - Invoices").
     */
    public function getLogsByLogName(string $logName): Collection
    {
        return $this->repository->getByLogName($logName);
    }

    /**
     * Get activity logs within a date range.
     */
    public function getLogsByDateRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): Collection
    {
        return $this->repository->getByDateRange($startDate, $endDate);
    }

    /**
     * Get activity logs by event type (created, updated, deleted).
     */
    public function getLogsByEvent(string $event): Collection
    {
        return $this->repository->getByEvent($event);
    }

    /**
     * Get activity logs by batch UUID.
     */
    public function getLogsByBatchUuid(string $batchUuid): Collection
    {
        return $this->repository->getByBatchUuid($batchUuid);
    }

    /**
     * Clean up old activity logs.
     */
    public function cleanupOldLogs(int $daysToKeep = 90): int
    {
        $date = now()->subDays($daysToKeep);

        return $this->repository->deleteOlderThan($date);
    }

    /**
     * Get available log names for filtering.
     */
    public function getAvailableLogNames(): SupportCollection
    {
        return $this->repository->getUniqueLogNames();
    }

    /**
     * Get available event types for filtering.
     */
    public function getAvailableEvents(): SupportCollection
    {
        return $this->repository->getUniqueEvents();
    }

    /**
     * Generate DataTable for activity logs.
     */
    public function datatable(ActivityLogFilterDTO $filters)
    {
        $query = $this->repository->getQuery($filters->toArray());

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('log_name', fn($row) => '<span class="badge badge-info">' . e($row->log_name) . '</span>')
            ->editColumn('event', fn($row) => $this->renderEventBadge($row->event))
            ->editColumn('description', fn($row) => '<strong>' . e($row->description) . '</strong>')
            ->addColumn('subject', fn($row) => $this->renderSubject($row))
            ->addColumn('causer', fn($row) => $this->renderCauser($row))
            ->editColumn('created_at', fn($row) => '<small class="text-muted">' . $row->created_at->format('Y-m-d H:i:s') . '</small>')
            ->addColumn('actions', fn($row) => $this->renderActionsColumn($row))
            ->addColumn('DT_RowClass', fn($row) => $this->getRowClass($row->event))
            ->rawColumns(['log_name', 'event', 'description', 'subject', 'causer', 'created_at', 'actions'])
            ->make(true);
    }

    /**
     * Get summary statistics for activity logs.
     */
    public function getSummaryStatistics(ActivityLogFilterDTO $filters): array
    {
        $logs = $this->repository->getAll($filters->toArray());

        return [
            'total_logs' => $logs->count(),
            'by_event' => $logs->groupBy('event')->map->count(),
            'by_log_name' => $logs->groupBy('log_name')->map->count(),
            'recent_activity' => $logs->take(10),
        ];
    }

    /**
     * Render event badge with appropriate styling.
     */
    protected function renderEventBadge(string $event): string
    {
        $badges = [
            'created' => 'success',
            'updated' => 'warning',
            'deleted' => 'danger',
        ];

        $class = $badges[$event] ?? 'secondary';

        return '<span class="badge badge-' . $class . '">' . ucfirst($event) . '</span>';
    }

    /**
     * Render subject information.
     */
    protected function renderSubject(Activity $activity): string
    {
        if (! $activity->subject) {
            return '<span class="text-muted">N/A</span>';
        }

        $type = class_basename($activity->subject_type);

        return '<small><strong>' . e($type) . '</strong><br>ID: ' . $activity->subject_id . '</small>';
    }

    /**
     * Render causer (user) information.
     */
    protected function renderCauser(Activity $activity): string
    {
        if (! $activity->causer) {
            return '<span class="text-muted">System</span>';
        }

        $name = $activity->causer->name ?? 'Unknown';
        $type = class_basename($activity->causer_type);

        return '<strong>' . e($name) . '</strong><br><small class="text-muted">' . e($type) . '</small>';
    }

    /**
     * Render actions column for DataTable.
     */
    protected function renderActionsColumn(Activity $activity): string
    {
        return view('admin.System.activity_logs.partials.actions', ['log' => $activity])->render();
    }

    /**
     * Get row CSS class based on event type.
     */
    protected function getRowClass(string $event): string
    {
        return match ($event) {
            'created' => 'activity-row-created',
            'updated' => 'activity-row-updated',
            'deleted' => 'activity-row-deleted',
            default => 'activity-row-default',
        };
    }
}
