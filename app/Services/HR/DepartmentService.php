<?php

namespace App\Services\HR;

use App\Models\HumanResources\Department;

class DepartmentService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Department>
     */
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Department::query()
            ->withCount(['employees', 'designations'])
            ->with(['designations' => function ($query) {
                $query->withCount('employees');
            }])
            ->latest()
            ->get();
    }

    public function store(array $data): Department
    {
        return Department::create($data);
    }

    public function update(Department $department, array $data): Department
    {
        $department->update($data);

        return $department;
    }

    /**
     * @throws \Exception
     */
    public function delete(Department $department): bool
    {
        if ($department->employees()->count() > 0) {
            throw new \Exception(__('admin.HR.departments.messages.failed.has_employees'));
        }

        if ($department->designations()->count() > 0) {
            throw new \Exception(__('admin.HR.departments.messages.failed.has_designations'));
        }

        if ($department->delete()) {
            return true;
        }

        throw new \Exception(__('admin.HR.departments.messages.failed.delete'));
    }
}
