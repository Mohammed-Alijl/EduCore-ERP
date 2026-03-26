<?php

namespace App\Repositories;

use App\Repositories\Contracts\ActivityLogRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Spatie\Activitylog\Models\Activity;

class ActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function __construct(protected readonly Activity $model) {}

    public function getQuery(array $filters = []): Builder
    {
        $query = $this->model->with(['subject', 'causer']);

        return $this->applyFilters($query, $filters);
    }

    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->getQuery($filters)->paginate($perPage);
    }

    public function getAll(array $filters = []): Collection
    {
        return $this->getQuery($filters)->get();
    }

    public function findById(int $id): ?Activity
    {
        return $this->model->with(['subject', 'causer'])->find($id);
    }

    public function getForSubject(string $subjectType, int $subjectId): Collection
    {
        return $this->model
            ->where('subject_type', $subjectType)
            ->where('subject_id', $subjectId)
            ->with(['causer'])
            ->latest()
            ->get();
    }

    public function getByCauser(string $causerType, int $causerId): Collection
    {
        return $this->model
            ->where('causer_type', $causerType)
            ->where('causer_id', $causerId)
            ->with(['subject'])
            ->latest()
            ->get();
    }

    public function getByLogName(string $logName): Collection
    {
        return $this->model
            ->where('log_name', $logName)
            ->with(['subject', 'causer'])
            ->latest()
            ->get();
    }

    public function getByDateRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): Collection
    {
        return $this->model
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['subject', 'causer'])
            ->latest()
            ->get();
    }

    public function getByEvent(string $event): Collection
    {
        return $this->model
            ->where('event', $event)
            ->with(['subject', 'causer'])
            ->latest()
            ->get();
    }

    public function getByBatchUuid(string $batchUuid): Collection
    {
        return $this->model
            ->where('batch_uuid', $batchUuid)
            ->with(['subject', 'causer'])
            ->latest()
            ->get();
    }

    public function deleteOlderThan(\DateTimeInterface $date): int
    {
        return $this->model->where('created_at', '<', $date)->delete();
    }

    public function getUniqueLogNames(): SupportCollection
    {
        return $this->model
            ->select('log_name')
            ->distinct()
            ->orderBy('log_name')
            ->pluck('log_name');
    }

    public function getUniqueEvents(): SupportCollection
    {
        return $this->model
            ->select('event')
            ->distinct()
            ->orderBy('event')
            ->pluck('event');
    }

    /**
     * Apply filters to the query.
     */
    protected function applyFilters(Builder $query, array $filters): Builder
    {
        // Filter by log name
        $query->when(
            ! empty($filters['log_name']),
            fn ($q) => $q->where('log_name', $filters['log_name'])
        );

        // Filter by event type
        $query->when(
            ! empty($filters['event']),
            fn ($q) => $q->where('event', $filters['event'])
        );

        // Filter by subject type
        $query->when(
            ! empty($filters['subject_type']),
            fn ($q) => $q->where('subject_type', $filters['subject_type'])
        );

        // Filter by subject ID
        $query->when(
            ! empty($filters['subject_id']),
            fn ($q) => $q->where('subject_id', $filters['subject_id'])
        );

        // Filter by causer type
        $query->when(
            ! empty($filters['causer_type']),
            fn ($q) => $q->where('causer_type', $filters['causer_type'])
        );

        // Filter by causer ID
        $query->when(
            ! empty($filters['causer_id']),
            fn ($q) => $q->where('causer_id', $filters['causer_id'])
        );

        // Filter by batch UUID
        $query->when(
            ! empty($filters['batch_uuid']),
            fn ($q) => $q->where('batch_uuid', $filters['batch_uuid'])
        );

        // Filter by date range
        $query->when(
            ! empty($filters['start_date']),
            fn ($q) => $q->whereDate('created_at', '>=', $filters['start_date'])
        );

        $query->when(
            ! empty($filters['end_date']),
            fn ($q) => $q->whereDate('created_at', '<=', $filters['end_date'])
        );

        // Search in description
        $query->when(
            ! empty($filters['search']),
            fn ($q) => $q->where('description', 'like', '%'.$filters['search'].'%')
        );

        return $query->latest();
    }
}
