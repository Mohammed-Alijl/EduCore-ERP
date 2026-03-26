<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;

interface ActivityLogRepositoryInterface
{
    /**
     * Get query builder for activity logs with applied filters.
     */
    public function getQuery(array $filters = []): Builder;

    /**
     * Get paginated activity logs with filters.
     */
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    /**
     * Get all activity logs with filters.
     */
    public function getAll(array $filters = []): Collection;

    /**
     * Find activity log by ID.
     */
    public function findById(int $id): ?Activity;

    /**
     * Get activity logs for a specific subject.
     */
    public function getForSubject(string $subjectType, int $subjectId): Collection;

    /**
     * Get activity logs by a specific causer.
     */
    public function getByCauser(string $causerType, int $causerId): Collection;

    /**
     * Get activity logs by log name.
     */
    public function getByLogName(string $logName): Collection;

    /**
     * Get activity logs within a date range.
     */
    public function getByDateRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): Collection;

    /**
     * Get activity logs by event type.
     */
    public function getByEvent(string $event): Collection;

    /**
     * Get activity logs by batch UUID.
     */
    public function getByBatchUuid(string $batchUuid): Collection;

    /**
     * Delete old activity logs.
     */
    public function deleteOlderThan(\DateTimeInterface $date): int;

    /**
     * Get unique log names.
     */
    public function getUniqueLogNames(): Collection;

    /**
     * Get unique event types.
     */
    public function getUniqueEvents(): Collection;
}
