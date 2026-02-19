<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Grade;
use App\Models\Guardian;
use App\Models\Nationality;
use App\Models\TypeBlood;
use App\Models\Religion;
use App\Models\Gender;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentService
{
    public function getAll()
    {
        return Student::with(['grade', 'classroom', 'section', 'guardian'])->latest()->get();
    }

    public function getLookups()
    {
        return [
            'grades'        => Grade::all(),
            'guardians'     => Guardian::all(),
            'nationalities' => Nationality::all(),
            'blood_types'   => TypeBlood::all(),
            'religions'     => Religion::all(),
            'genders'       => Gender::all(),
        ];
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            $data['admin_id'] = Auth::id();

            $image = $data['image'] ?? null;
            $attachments = $data['attachments'] ?? null;
            unset($data['image'], $data['attachments']);

            $student = Student::create($data);

            $folderName = $student->student_code;
            $filesToUpdate = [];

            if ($image && $image->isValid()) {
                $filesToUpdate['image'] = $image->store("students/{$folderName}/profile", 'public');
            }

            if ($attachments && is_array($attachments)) {
                $attachmentPaths = [];
                foreach ($attachments as $file) {
                    if ($file->isValid()) {
                        $path = $file->store("students/{$folderName}/attachments", 'public');
                        $attachmentPaths[] = $path;
                    }
                }
                $filesToUpdate['attachments'] = $attachmentPaths;
            }

            if (!empty($filesToUpdate)) {
                $student->update($filesToUpdate);
            }

            return $student;
        });
    }

    public function update($student, array $data)
    {
        $folderName = $student->student_code;

        if (empty($data['password'])) {
            unset($data['password']);
        }

        if (isset($data['image']) && $data['image']->isValid()) {
            if ($student->image && Storage::disk('public')->exists($student->image)) {
                Storage::disk('public')->delete($student->image);
            }
            $data['image'] = $data['image']->store("students/{$folderName}/profile", 'public');
        }

        if (isset($data['attachments']) && is_array($data['attachments'])) {
            $existingAttachments = $student->attachments ?? [];
            $newAttachmentPaths = [];

            foreach ($data['attachments'] as $file) {
                if ($file->isValid()) {
                    $path = $file->store("students/{$folderName}/attachments", 'public');
                    $newAttachmentPaths[] = $path;
                }
            }
            $data['attachments'] = array_merge($existingAttachments, $newAttachmentPaths);
        }

        $student->update($data);
        return $student;
    }

    public function delete($student)
    {
        if ($student->delete()) {
            return true;
        }
        throw new \Exception(__('admin.students.messages.failed.delete'));
    }

    public function archive()
    {
        return Student::onlyTrashed()->latest()->get();
    }

    public function restore($id)
    {
        $student = Student::withTrashed()->find($id);

        if (!$student) {
            throw new \Exception(__('admin.students.messages.failed.restore'));
        }

        $student->restore();
        return true;
    }

    public function forceDelete($id)
    {
        $student = Student::withTrashed()->find($id);

        if (!$student) {
            throw new \Exception(__('admin.students.messages.failed.delete'));
        }

        $folderPath = "students/{$student->student_code}";
        if (Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->deleteDirectory($folderPath);
        }

        $student->forceDelete();
        return true;
    }
}
