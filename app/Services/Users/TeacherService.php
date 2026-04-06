<?php

namespace App\Services\Users;

use App\Models\HumanResources\Department;
use App\Models\HumanResources\Designation;
use App\Models\HumanResources\EmployeeAttachment;
use App\Models\SystemData\Gender;
use App\Models\SystemData\Nationality;
use App\Models\SystemData\Religion;
use App\Models\Specialization;
use App\Models\Teacher;
use App\Models\SystemData\TypeBlood;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeacherService
{
    public function getAll()
    {
        return Teacher::with(['attachments'])->latest()->get();
    }

    public function getLookups()
    {
        return [
            'nationalities' => Nationality::all(),
            'blood_types' => TypeBlood::all(),
            'religions' => Religion::all(),
            'genders' => Gender::all(),
            'specializations' => Specialization::all(),
            'departments' => Department::all(),
            'designations' => Designation::all(),
        ];
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            $data['admin_id'] = Auth::id();

            $image = $data['image'] ?? null;
            $attachments = $data['attachments'] ?? null;
            unset($data['image'], $data['attachments']);

            $teacher = Teacher::create($data);

            $folderName = $teacher->employee_code;

            if ($image && $image->isValid()) {
                $image_path = $image->store("teachers/{$folderName}/profile", 'public');
                $teacher->update(['image' => $image_path]);
            }

            if ($attachments && is_array($attachments)) {
                foreach ($attachments as $file) {
                    if ($file->isValid()) {
                        $path = $file->store("teachers/{$folderName}/attachments", 'public');
                        $attachment = new EmployeeAttachment;
                        $attachment->employee_id = $teacher->id;
                        $attachment->attachment_path = $path;
                        $attachment->save();
                    }
                }
            }

            return $teacher;
        });
    }

    public function update($teacher, array $data)
    {
        $folderName = $teacher->employee_code;

        if (empty($data['password'])) {
            unset($data['password']);
        }

        if (isset($data['image']) && $data['image']->isValid()) {
            if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
                Storage::disk('public')->delete($teacher->image);
            }
            $data['image'] = $data['image']->store("teachers/{$folderName}/profile", 'public');
        }

        if (isset($data['attachments']) && is_array($data['attachments'])) {
            foreach ($data['attachments'] as $file) {
                if ($file->isValid()) {
                    $path = $file->store("teachers/{$folderName}/attachments", 'public');
                    $attachment = new EmployeeAttachment;
                    $attachment->employee_id = $teacher->id;
                    $attachment->attachment_path = $path;
                    $attachment->save();
                }
            }
            unset($data['attachments']);
        }

        $teacher->update($data);

        return $teacher;
    }

    public function delete($teacher)
    {
        if ($teacher->delete()) {
            return true;
        }
        throw new \Exception(__('admin.Users.teachers.messages.failed.delete'));
    }

    public function archive()
    {
        return Teacher::onlyTrashed()->latest()->get();
    }

    public function restore($id)
    {
        $teacher = Teacher::withTrashed()->find($id);

        if (! $teacher) {
            throw new \Exception(__('admin.Users.teachers.messages.failed.restore'));
        }

        $teacher->restore();

        return true;
    }

    public function forceDelete($id)
    {
        $teacher = Teacher::withTrashed()->find($id);

        if (! $teacher) {
            throw new \Exception(__('admin.Users.teachers.messages.failed.delete'));
        }

        if ($teacher->attachments()->count() > 0) {
            foreach ($teacher->attachments as $attachment) {
                $attachment->delete();
            }
        }

        $folderPath = "teachers/{$teacher->employee_code}";
        if (Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->deleteDirectory($folderPath);
        }

        if ($teacher->forceDelete()) {
            return true;
        }

        throw new \Exception(__('admin.Users.teachers.messages.failed.delete'));
    }

    public function getNextTeacherCode()
    {
        $prefix = 'TCH-' . date('Y') . '-';
        $lastTeacher = Teacher::withTrashed()
            ->where('employee_code', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastTeacher) {
            $lastNumber = str_replace($prefix, '', $lastTeacher->employee_code);
            $newSequence = str_pad((int) $lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newSequence = '0001';
        }

        return $prefix . $newSequence;
    }

    public function deleteAttachment($id)
    {
        $attachment = EmployeeAttachment::findOrFail($id);

        if (Storage::disk('public')->exists($attachment->attachment_path)) {
            Storage::disk('public')->delete($attachment->attachment_path);
        }

        return $attachment->delete();
    }
}
