<?php

namespace App\Services;

use App\Enums\EmployeeType;
use App\Models\Departments;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Gender;
use App\Models\Nationality;
use App\Models\Religion;
use App\Models\Specialization;
use App\Models\TeacherAttachment;
use App\Models\TypeBlood;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployeeService
{
    public function getAll()
    {
        return Employee::with(['attachments'])->latest()->get();
    }

    public function getLookups(): array
    {
        return [
            'nationalities' => Nationality::all(),
            'blood_types' => TypeBlood::all(),
            'religions' => Religion::all(),
            'genders' => Gender::all(),
            'specializations' => Specialization::all(),
            'departments' => Departments::all(),
            'designations' => Designation::all(),
            'employee_types' => EmployeeType::cases(),
        ];
    }

    public function store(array $data): Employee
    {
        return DB::transaction(function () use ($data) {
            $data['admin_id'] = Auth::id();

            $image = $data['image'] ?? null;
            $attachments = $data['attachments'] ?? null;
            unset($data['image'], $data['attachments']);

            $employee = Employee::create($data);

            $folderName = $employee->employee_code;

            if ($image && $image->isValid()) {
                $imagePath = $image->store("employees/{$folderName}/profile", 'public');
                $employee->update(['image' => $imagePath]);
            }

            if ($attachments && is_array($attachments)) {
                foreach ($attachments as $file) {
                    if ($file->isValid()) {
                        $path = $file->store("employees/{$folderName}/attachments", 'public');
                        $attachment = new TeacherAttachment;
                        $attachment->teacher_id = $employee->id;
                        $attachment->attachment_path = $path;
                        $attachment->save();
                    }
                }
            }

            return $employee;
        });
    }

    public function update(Employee $employee, array $data): Employee
    {
        $folderName = $employee->employee_code;

        if (empty($data['password'])) {
            unset($data['password']);
        }

        if (isset($data['image']) && $data['image']->isValid()) {
            if ($employee->image && Storage::disk('public')->exists($employee->image)) {
                Storage::disk('public')->delete($employee->image);
            }
            $data['image'] = $data['image']->store("employees/{$folderName}/profile", 'public');
        }

        if (isset($data['attachments']) && is_array($data['attachments'])) {
            foreach ($data['attachments'] as $file) {
                if ($file->isValid()) {
                    $path = $file->store("employees/{$folderName}/attachments", 'public');
                    $attachment = new TeacherAttachment;
                    $attachment->teacher_id = $employee->id;
                    $attachment->attachment_path = $path;
                    $attachment->save();
                }
            }
            unset($data['attachments']);
        }

        $employee->update($data);

        return $employee;
    }

    public function delete(Employee $employee): bool
    {
        if ($employee->delete()) {
            return true;
        }
        throw new \Exception(__('admin.employees.messages.failed.delete'));
    }

    public function archive()
    {
        return Employee::onlyTrashed()->latest()->get();
    }

    public function restore(int $id): bool
    {
        $employee = Employee::withTrashed()->find($id);

        if (! $employee) {
            throw new \Exception(__('admin.employees.messages.failed.restore'));
        }

        $employee->restore();

        return true;
    }

    public function forceDelete(int $id): bool
    {
        $employee = Employee::withTrashed()->find($id);

        if (! $employee) {
            throw new \Exception(__('admin.employees.messages.failed.delete'));
        }

        if ($employee->attachments()->count() > 0) {
            foreach ($employee->attachments as $attachment) {
                $attachment->delete();
            }
        }

        $folderPath = "employees/{$employee->employee_code}";
        if (Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->deleteDirectory($folderPath);
        }

        if ($employee->forceDelete()) {
            return true;
        }

        throw new \Exception(__('admin.employees.messages.failed.delete'));
    }

    public function getNextEmployeeCode(): string
    {
        $prefix = 'EMP-'.date('Y').'-';
        $lastEmployee = Employee::withTrashed()
            ->where('employee_code', 'like', $prefix.'%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastEmployee) {
            $lastNumber = str_replace($prefix, '', $lastEmployee->employee_code);
            $newSequence = str_pad((int) $lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newSequence = '0001';
        }

        return $prefix.$newSequence;
    }

    public function deleteAttachment(int $id): bool
    {
        $attachment = TeacherAttachment::findOrFail($id);

        if (Storage::disk('public')->exists($attachment->attachment_path)) {
            Storage::disk('public')->delete($attachment->attachment_path);
        }

        return $attachment->delete();
    }
}
