<?php

namespace App\Services;

use App\Models\Designation;

class DesignationService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Designation>
     */
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Designation::query()
            ->withCount('employees')
            ->with('department')
            ->latest()
            ->get();
    }

    public function store(array $data): Designation
    {
        return Designation::create($data);
    }

    public function update(Designation $designation, array $data): Designation
    {
        $designation->update($data);

        return $designation;
    }

    /**
     * @throws \Exception
     */
    public function delete(Designation $designation): bool
    {
        if ($designation->employees()->count() > 0) {
            throw new \Exception(__('admin.designations.messages.failed.has_employees'));
        }

        if ($designation->delete()) {
            return true;
        }

        throw new \Exception(__('admin.designations.messages.failed.delete'));
    }
}
