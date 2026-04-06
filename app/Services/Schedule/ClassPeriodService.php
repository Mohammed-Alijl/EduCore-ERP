<?php

namespace App\Services\Schedule;

use App\Models\Scheduling\ClassPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ClassPeriodService
{
    /**
     * Get query builder with filters applied.
     *
     * @param  array<string, mixed>  $filters
     */
    public function getQuery(array $filters = []): Builder
    {
        $query = ClassPeriod::query()->with('grade');

        if (! empty($filters['grade_id'])) {
            $query->where('grade_id', $filters['grade_id']);
        }

        if (isset($filters['is_break']) && $filters['is_break'] !== '') {
            $query->where('is_break', (bool) $filters['is_break']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', (bool) $filters['status']);
        }

        return $query->ordered();
    }

    /**
     * Get all class periods.
     *
     * @return Collection<int, ClassPeriod>
     */
    public function getAll(): Collection
    {
        return ClassPeriod::query()
            ->with('grade')
            ->ordered()
            ->get();
    }

    /**
     * Get active class periods.
     *
     * @return Collection<int, ClassPeriod>
     */
    public function getActive(): Collection
    {
        return ClassPeriod::query()
            ->active()
            ->with('grade')
            ->ordered()
            ->get();
    }

    /**
     * Get class periods for a specific grade.
     *
     * @return Collection<int, ClassPeriod>
     */
    public function getByGrade(?int $gradeId): Collection
    {
        return ClassPeriod::query()
            ->active()
            ->forGrade($gradeId)
            ->ordered()
            ->get();
    }

    /**
     * Store a new class period.
     *
     * @param  array<string, mixed>  $data
     */
    public function store(array $data): ClassPeriod
    {
        if (! isset($data['sort_order'])) {
            $data['sort_order'] = ClassPeriod::max('sort_order') + 1;
        }

        return ClassPeriod::create($data);
    }

    /**
     * Update an existing class period.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(ClassPeriod $classPeriod, array $data): ClassPeriod
    {
        $classPeriod->update($data);

        return $classPeriod->fresh();
    }

    /**
     * Delete a class period.
     *
     * @throws \Exception
     */
    public function delete(ClassPeriod $classPeriod): bool
    {
        if ($classPeriod->delete()) {
            return true;
        }

        throw new \Exception(__('admin.Schedule.class_periods.messages.failed.delete'));
    }

    /**
     * Calculate end time based on start time and duration.
     */
    public function calculateEndTime(string $startTime, int $duration): string
    {
        $start = \Carbon\Carbon::createFromFormat('H:i', $startTime);

        return $start->addMinutes($duration)->format('H:i');
    }

    /**
     * Check for overlapping periods.
     */
    public function hasOverlap(string $startTime, string $endTime, ?int $gradeId = null, ?int $excludeId = null): bool
    {
        $query = ClassPeriod::query()
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where(function ($inner) use ($startTime, $endTime) {
                    $inner->whereRaw('TIME(start_time) < ?', [$endTime])
                        ->whereRaw('TIME(end_time) > ?', [$startTime]);
                });
            });

        if ($gradeId) {
            $query->where(function ($q) use ($gradeId) {
                $q->where('grade_id', $gradeId)->orWhereNull('grade_id');
            });
        } else {
            $query->whereNull('grade_id');
        }

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
