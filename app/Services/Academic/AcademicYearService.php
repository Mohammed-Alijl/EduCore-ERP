<?php

namespace App\Services\Academic;

use App\Models\AcademicYear;
use Exception;

class AcademicYearService
{
    /**
     * get all Academic Years
     */
    public function getAll()
    {
        return AcademicYear::orderBy('starts_at')->get();
    }


    /**
     * get all Current Year
     */
    public function getCurrent()
    {
        return AcademicYear::where('is_current', true)->first();
    }

    public function store(array $data)
    {
        if (($data['is_current'] ?? false) && $this->getCurrent()) {
            throw new Exception(__('admin.Academic.academic_years.messages.failed.is_current'));
        }

        return AcademicYear::create($data);
    }

    public function update($academicYear, array $data)
    {
        if (!$academicYear->is_current && ($data['is_current'] ?? false) && $this->getCurrent()) {
            throw new Exception(__('admin.Academic.academic_years.messages.failed.is_current'));
        }

        $academicYear->update($data);
        return $academicYear;
    }
}
