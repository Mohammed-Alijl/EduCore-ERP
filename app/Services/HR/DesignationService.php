<?php

namespace App\Services\HR;

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
            throw new \Exception(__('admin.HR.designations.messages.failed.has_employees'));
        }

        if ($designation->delete()) {
            return true;
        }

        throw new \Exception(__('admin.HR.designations.messages.failed.delete'));
    }

    public function getByDepartment(int $departmentId): \Illuminate\Database\Eloquent\Collection
    {
        return Designation::where('department_id', $departmentId)->get(['id', 'name', 'can_teach']);
    }
}
