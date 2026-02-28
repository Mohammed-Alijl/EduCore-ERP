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
            'specializations'  => Specialization::active()->latest()->get(),
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
}
