<?php

namespace App\Services\Academic;

use App\Models\Grade;

class GradeService
{
    /**
     * get all grades
     */
    public function getAll()
    {
        return Grade::with('classrooms')->get()->sortBy('sort_order');
    }

    /**
     * get all grades with classrooms
     */
    public function getAllWithClassrooms ()
    {
        return Grade::with('classrooms')->active()->get()->sortBy('sort_order');
    }


    /**
     * get all active grades
     */
    public function getActive()
    {
        return Grade::active()->get();
    }

    public function store(array $data)
    {
        $grade = Grade::create($data);

        return $grade;
    }

    public function update($grade, array $data)
    {
        $grade->update($data);
        return $grade;
    }

    public function delete($grade)
    {
        if ($grade->classrooms->count())
            throw new \Exception(__('admin.Academic.grades.messages.failed.has_classrooms'));

        $grade->status = 0;
        $grade->save();
        if ($grade->delete())
            return true;
        throw new \Exception(__('admin.Academic.grades.messages.failed.archive'));
    }
    public function archive()
    {
        $grades = Grade::onlyTrashed()->with('classrooms')->orderBy('sort_order')->get();
        return $grades;
    }

    public function restore($id)
    {
        $grade = Grade::withTrashed()->find($id);

        if (!$grade) {
            throw new \Exception(__('admin.Academic.grades.messages.failed.restore'));
        }
        $grade->restore();

        return true;
    }

    public function forceDelete($id)
    {
        $grade = Grade::withTrashed()->find($id);

        if (!$grade) {
            throw new \Exception(__('admin.Academic.grades.messages.failed.delete'));
        }

        $grade->forceDelete();
        return true;
    }

}
