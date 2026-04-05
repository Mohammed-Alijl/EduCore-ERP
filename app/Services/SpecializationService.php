<?php
namespace App\Services;

use App\Models\Specialization;

class SpecializationService
{
    public function getAll()
    {
        return Specialization::latest()->get();
    }

    public function store(array $data)
    {
        return Specialization::create($data);
    }

    public function update(Specialization $specialization, array $data)
    {
        $specialization->update($data);
        return $specialization;
    }

    public function delete(Specialization $specialization)
    {
        if ($specialization->teachers()->count() > 0) {
            throw new \Exception(__('admin.HR.specializations.messages.failed.has_teachers'));
        }

        if ($specialization->delete()) {
            return true;
        }

        throw new \Exception(__('admin.HR.specializations.messages.failed.delete'));
    }
}
