<?php

namespace App\Services;

use App\Models\ClassRoom;
use App\Models\Grade;
use App\Models\Specialization;
use App\Models\Subject;
use Exception;

class SubjectService
{
    /**
     * Return all subjects with eager-loaded relationships.
     */
    public function getAll()
    {
        return Subject::with(['specialization', 'grade', 'classroom'])->latest()->get();
    }

    /**
     * Return all active subjects with eager-loaded relationships.
     */
    public function getActive()
    {
        return Subject::active()->with(['specialization', 'grade', 'classroom'])->latest()->get();
    }

    /**
     * Return lookup data for the create/edit forms.
     */
    public function getLookups(): array
    {
        return [
            'grades'           => Grade::active()->get(),
            'specializations'  => Specialization::latest()->get(),
        ];
    }

    /**
     * Store a new subject.
     */
    public function store(array $data): Subject
    {
        $data['admin_id'] = auth('admin')->id();

        return Subject::create($data);
    }

    /**
     * Update an existing subject.
     */
    public function update(Subject $subject, array $data): Subject
    {
        $subject->update($data);

        return $subject;
    }

    /**
     * Soft-delete a subject.
     *
     * @throws Exception
     */
    public function delete(Subject $subject): bool
    {
        if ($subject->delete())
            return true;

        throw new \Exception(__('admin.subjects.messages.failed.delete'));
    }

    public function archive()
    {
        return Subject::onlyTrashed()->latest()->get();
    }

    public function restore($id)
    {
        $subject = Subject::withTrashed()->find($id);

        if (!$subject) {
            throw new \Exception(__('admin.subjects.messages.failed.restore'));
        }

        $subject->restore();
        return true;
    }

    public function forceDelete($id)
    {
        $subject = Subject::withTrashed()->find($id);

        if (!$subject)
            throw new \Exception(__('admin.subjects.messages.failed.delete'));

        if($subject->forceDelete())
            return true;

        throw new \Exception(__('admin.subjects.messages.failed.delete'));
    }
}
