<?php

namespace App\Services;

use App\Models\ClassRoom;
use App\Models\Grade;

class ClassroomService
{

    /**
     * get all classrooms
     */
    public function getAll()
    {
        $classrooms = Classroom::with('grade')->orderBy('grade_id')->get()->sortBy('sort_order');
        return $classrooms;
    }

    /**
     * get all active classrooms
     */
    public function getActive()
    {
        return ClassRoom::active()->get();
    }

    public function store(array $data)
    {
        $classroom = ClassRoom::create($data);

        return $classroom;
    }

    public function update($classroom, array $data)
    {
        if (!$classroom->grade->status)
            throw new \Exception(__('admin.classrooms.messages.failed.update'));
        $classroom->update($data);
        return $classroom;
    }

    public function delete($classroom)
    {
        if (!$classroom->grade->status)
            throw new \Exception(__('admin.classrooms.messages.failed.archive'));
        $classroom->status = 0;
        $classroom->save();
        $classroom->delete();
        return true;
    }

    public function archive()
    {
        $classrooms = ClassRoom::onlyTrashed()->orderBy('sort_order')->get();
        return $classrooms;
    }

    public function restore($id)
    {
            $classroom = ClassRoom::withTrashed()->find($id);

            if (!$classroom) {
                throw new \Exception(__('admin.classrooms.messages.failed.restore'));
            }
            $classroom->restore();

            return true;
    }

    public function forceDelete($id)
    {
            $classroom = ClassRoom::withTrashed()->find($id);

            if (!$classroom) {
                throw new \Exception(__('admin.classrooms.messages.failed.delete'));
            }

            $classroom->forceDelete();
            return true;
    }

    public function getGradeClassrooms($id) {
        return Classroom::where('grade_id', $id)->pluck('name', 'id');
    }

}
