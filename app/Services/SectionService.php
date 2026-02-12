<?php

namespace App\Services;

use App\Models\ClassRoom;
use App\Models\Section;

class SectionService
{

    /**
     * get all classrooms
     */
    public function getAll()
    {
        $sections = Section::with(['grade','classroom'])->get()->sortBy('sort_order');
        return $sections;
    }


    public function store(array $data)
    {
        if (!Classroom::find($data['classroom_id'])->status)
            throw new \Exception(__('admin.sections.messages.failed.add'));
        $section = Section::create($data);

        return $section;
    }

    public function update($section, array $data)
    {
        if (!$section->grade->status || !$section->classroom->status)
            throw new \Exception(__('admin.classrooms.messages.failed.update'));
        $section->update($data);
        return $section;
    }

    public function delete($section)
    {
        if (!$section->grade->status || !$section->classroom->status)
            throw new \Exception(__('admin.sections.messages.failed.archive'));
        $section->status = 0;
        $section->save();
        $section->delete();
        return true;
    }

    public function archive()
    {
        $sections = Section::onlyTrashed()->orderBy('sort_order')->get();
        return $sections;
    }

    public function restore($id)
    {
            $section = Section::withTrashed()->find($id);

            if (!$section) {
                throw new \Exception(__('admin.sections.messages.failed.restore'));
            }
            $section->restore();

            return true;
    }

    public function forceDelete($id)
    {
        $section = Section::withTrashed()->find($id);

            if (!$section) {
                throw new \Exception(__('admin.sections.messages.failed.delete'));
            }

            $section->forceDelete();
            return true;
    }

}
