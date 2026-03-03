<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Grade;
use App\Models\Guardian;
use App\Models\Nationality;
use App\Models\TypeBlood;
use App\Models\Religion;
use App\Models\Gender;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StudentService
{
    public function getAll()
    {
        return Student::with(['grade', 'classroom', 'section', 'guardian'])->latest()->get();
    }

    public function getStudentsDataTable(Request $request)
    {
        $query = $this->getStudentsQuery();
        
        $query = $this->applyFilters($query, $request);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->getTranslation('name', app()->getLocale());
            })
            ->addColumn('guardian_name', function ($row) {
                return $row->guardian->name_father ?? '-';
            })
            ->addColumn('grade_name', function ($row) {
                return $row->grade ? $row->grade->getTranslation('name', app()->getLocale()) : '-';
            })
            ->addColumn('classroom_name', function ($row) {
                return $row->classroom ? $row->classroom->getTranslation('name', app()->getLocale()) : '-';
            })
            ->addColumn('section_name', function ($row) {
                return $row->section ? $row->section->getTranslation('name', app()->getLocale()) : '-';
            })
            ->addColumn('status', function ($row) {
                if ($row->status) {
                    return '<span class="badge badge-modern badge-active"><i class="las la-check-circle mr-1 ml-1"></i>' . trans('admin.global.active') . '</span>';
                }
                return '<span class="badge badge-modern badge-inactive"><i class="las la-times-circle mr-1 ml-1"></i>' . trans('admin.global.disabled') . '</span>';
            })
            ->addColumn('actions', function ($row) {
                return view('admin.students.partials._actions', compact('row'))->render();
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
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
            'academicYears' => AcademicYear::orderBy('name')->get(),
        ];
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            $data['admin_id'] = auth('admin')->id();

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

    public function getArchivedDataTable(Request $request)
    {
        $query = Student::onlyTrashed()
            ->with(['grade', 'classroom', 'section', 'guardian'])
            ->select('students.*');

        $query = $this->applyFilters($query, $request);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('student_code',     fn($row) => $row->student_code)
            ->addColumn('name',             fn($row) => $row->getTranslation('name', app()->getLocale()))
            ->addColumn('grade_name',       fn($row) => $row->grade ? $row->grade->getTranslation('name', app()->getLocale()) : '—')
            ->addColumn('classroom_name',   fn($row) => $row->classroom ? $row->classroom->getTranslation('name', app()->getLocale()) : '—')
            ->addColumn('deleted_at',       fn($row) => $row->deleted_at ? $row->deleted_at->format('d-m-Y') : '—')
            ->addColumn('actions', function ($row) {
                return view('admin.students.partials.archived_actions', compact('row'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
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

    public function getNextStudentCode()
    {
        $currentYear = date('Y');
        $lastStudent = Student::withTrashed()->where('student_code', 'like', $currentYear . '%')
            ->orderBy('student_code', 'desc')
            ->first();

        if ($lastStudent) {
            $lastSequence = (int) substr($lastStudent->student_code, 4);
            $newSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newSequence = '0001';
        }

        return $currentYear . $newSequence;
    }


    private function applyFilters($query, Request $request)
    {
        return $query->when($request->filled('filter_grade'), function ($q) use ($request) {
                $q->where('grade_id', (int) $request->filter_grade);
            })
            ->when($request->filled('filter_classroom'), function ($q) use ($request) {
                $q->where('classroom_id', (int) $request->filter_classroom);
            })
            ->when($request->filled('filter_section'), function ($q) use ($request) {
                $q->where('section_id', (int) $request->filter_section);
            })
            ->when($request->has('filter_status') && $request->filter_status !== null, function ($q) use ($request) {
                $q->where('status', (int) $request->filter_status);
            });
    }


    private function getStudentsQuery()
    {
        return Student::with(['grade', 'classroom', 'section', 'guardian'])
                      ->select('students.*'); 
    }
}
