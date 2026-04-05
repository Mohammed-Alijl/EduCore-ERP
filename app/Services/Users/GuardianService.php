<?php

namespace App\Services\Users;

use App\Models\Guardian;
use App\Models\Nationality;
use App\Models\TypeBlood;
use App\Models\Religion;
use Illuminate\Support\Facades\Storage;

class GuardianService
{
    /**
     * Get all guardians with relationships if needed
     */
    public function getAll()
    {
        return Guardian::with([
            'students.grade',
            'students.classroom',
            'students.section',
            'students.gender',
            'students.nationality',
            'students.bloodType',
            'students.religion'
        ])->latest()->get();
    }

    /**
     * Helper to get all lookups needed for the forms
     */
    public function getLookups()
    {
        return [
            'nationalities' => Nationality::all(),
            'blood_types' => TypeBlood::all(),
            'religions' => Religion::all(),
        ];
    }

    public function store(array $data)
    {
        $folderName = $data['national_id_father'];
        if (isset($data['image']) && $data['image']->isValid()) {
            $data['image'] = $data['image']->store("guardians/{$folderName}/profile", 'public');
        }

        if (isset($data['attachments']) && is_array($data['attachments'])) {
            $attachmentPaths = [];

            foreach ($data['attachments'] as $file) {
                if ($file->isValid()) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs("guardians/{$folderName}/attachments", $fileName, 'public');
                    $attachmentPaths[] = $path;
                }
            }
            $data['attachments'] = $attachmentPaths;
        }

        return Guardian::create($data);
    }

    public function update($guardian, array $data)
    {
        $folderName = $guardian->national_id_father;

        if (empty($data['password'])) {
            unset($data['password']);
        }

        if (isset($data['image']) && $data['image']->isValid()) {
            if ($guardian->image && Storage::disk('public')->exists($guardian->image)) {
                Storage::disk('public')->delete($guardian->image);
            }
            $data['image'] = $data['image']->store("guardians/{$folderName}/profile", 'public');
        }

        if (isset($data['attachments']) && is_array($data['attachments'])) {
            $existingAttachments = $guardian->attachments ?? [];
            $newAttachmentPaths = [];

            foreach ($data['attachments'] as $file) {
                if ($file->isValid()) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs("guardians/{$folderName}/attachments", $fileName, 'public');
                    $newAttachmentPaths[] = $path;
                }
            }
            $data['attachments'] = array_merge($existingAttachments, $newAttachmentPaths);
        }

        $guardian->update($data);
        return $guardian;
    }

    public function delete($guardian)
    {
        if ($guardian->students()->count() > 0) {
            throw new \Exception(trans('admin.Users.guardians.messages.failed.has_students'));
        }
        if ($guardian->delete())
            return true;
        else
            throw new \Exception(__('admin.Users.guardians.messages.failed.delete'));
    }

    public function archive()
    {
        return Guardian::onlyTrashed()->with([
            'students.grade',
            'students.classroom',
            'students.section',
            'students.gender',
            'students.nationality',
            'students.bloodType',
            'students.religion'
        ])->latest()->get();
    }

    public function restore($id)
    {
        $guardian = Guardian::withTrashed()->find($id);

        if (!$guardian) {
            throw new \Exception(__('admin.Users.guardians.messages.failed.restore'));
        }

        $guardian->restore();
        return true;
    }

    public function forceDelete($id)
    {
        $guardian = Guardian::withTrashed()->find($id);
        if (!$guardian)
            throw new \Exception(__('admin.Users.guardians.messages.failed.delete'));
        if ($guardian->students()->count() > 0) {
            throw new \Exception(trans('admin.Users.guardians.messages.failed.has_students'));
        }
        $folderPath = "guardians/{$guardian->national_id_father}";
        if (Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->deleteDirectory($folderPath);
        }

        $guardian->forceDelete();
        return true;
    }
}
