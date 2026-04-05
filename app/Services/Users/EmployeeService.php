<?php

namespace App\Services\Users;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeAttachment;
use App\Models\Gender;
use App\Models\Nationality;
use App\Models\Religion;
use App\Models\Specialization;
use App\Models\TypeBlood;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
            'departments' => Department::all(),
            'designations' => Designation::all(),
        ];
    }

    public function getEmployeesDataTable(Request $request)
    {
        $query = Employee::with(['designation', 'attachments']);

        $query = $this->applyFilters($query, $request);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                return '<img alt="avatar" class="avatar avatar-md brround bg-white" src="' . $row->image_url . '">';
            })
            ->addColumn('name', function ($row) {
                return is_array($row->name) ? $row->getTranslation('name', app()->getLocale()) : $row->name;
            })
            ->addColumn('employee_code_link', function ($row) {
                return view('admin.Users.employees.partials.employee_code_link', compact('row'))->render();
            })
            ->addColumn('designation_name', function ($row) {
                return '<span class="badge badge-pill badge-primary-transparent">' . (optional($row->designation)->name ?? '-') . '</span>';
            })
            ->addColumn('status_badge', function ($row) {
                if ($row->status) {
                    return '<span class="label text-success d-flex">' . trans('admin.global.active') . '</span>';
                }
                return '<span class="label text-danger d-flex">' . trans('admin.global.disabled') . '</span>';
            })
            ->addColumn('actions', function ($row) {
                return view('admin.Users.employees.partials.index_actions', compact('row'))->render();
            })
            ->rawColumns(['image', 'employee_code_link', 'designation_name', 'status_badge', 'actions'])
            ->make(true);
    }

    private function applyFilters($query, Request $request)
    {
        return $query->when($request->filled('filter_department'), function ($q) use ($request) {
                $q->where('department_id', (int) $request->filter_department);
            })
            ->when($request->filled('filter_designation'), function ($q) use ($request) {
                $q->where('designation_id', (int) $request->filter_designation);
            })
            ->when($request->has('filter_status') && $request->filter_status !== null, function ($q) use ($request) {
                $q->where('status', (int) $request->filter_status);
            });
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
                        $attachment = new EmployeeAttachment;
                        $attachment->employee_id = $employee->id;
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
                    $attachment = new EmployeeAttachment;
                    $attachment->employee_id = $employee->id;
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
        throw new \Exception(__('admin.Users.employees.messages.failed.delete'));
    }

    public function archive()
    {
        return Employee::onlyTrashed()->latest()->get();
    }

    public function getArchivedDataTable(Request $request)
    {
        $query = Employee::onlyTrashed()->with(['designation']);

        $query = $this->applyFilters($query, $request);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('employee_code', fn($row) => $row->employee_code)
            ->addColumn('type', function ($row) {
                return '<span class="badge badge-pill badge-primary-transparent">' . ($row->type?->label() ?? '-') . '</span>';
            })
            ->addColumn('name', function ($row) {
                return is_array($row->name) ? $row->getTranslation('name', app()->getLocale()) : $row->name;
            })
            ->addColumn('email', fn($row) => $row->email)
            ->addColumn('phone', fn($row) => $row->phone)
            ->addColumn('status_badge', function ($row) {
                if ($row->status) {
                    return '<span class="label text-success d-flex">' . trans('admin.global.active') . '</span>';
                }
                return '<span class="label text-danger d-flex">' . trans('admin.global.disabled') . '</span>';
            })
            ->addColumn('actions', function ($row) {
                return view('admin.Users.employees.partials.archived_actions', compact('row'))->render();
            })
            ->rawColumns(['type', 'status_badge', 'actions'])
            ->make(true);
    }

    public function restore(int $id): bool
    {
        $employee = Employee::withTrashed()->find($id);

        if (! $employee) {
            throw new \Exception(__('admin.Users.employees.messages.failed.restore'));
        }

        $employee->restore();

        return true;
    }

    public function forceDelete(int $id): bool
    {
        $employee = Employee::withTrashed()->find($id);

        if (! $employee) {
            throw new \Exception(__('admin.Users.employees.messages.failed.delete'));
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

        throw new \Exception(__('admin.Users.employees.messages.failed.delete'));
    }

    public function getNextEmployeeCode(): string
    {
        $prefix = 'EMP-' . date('Y') . '-';
        $lastEmployee = Employee::withTrashed()
            ->where('employee_code', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastEmployee) {
            $lastNumber = str_replace($prefix, '', $lastEmployee->employee_code);
            $newSequence = str_pad((int) $lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newSequence = '0001';
        }

        return $prefix . $newSequence;
    }

    public function deleteAttachment(int $id): bool
    {
        $attachment = EmployeeAttachment::findOrFail($id);

        if (Storage::disk('public')->exists($attachment->attachment_path)) {
            Storage::disk('public')->delete($attachment->attachment_path);
        }

        return $attachment->delete();
    }
}
