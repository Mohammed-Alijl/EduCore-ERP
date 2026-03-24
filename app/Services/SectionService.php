<?php

namespace App\Services;

use App\Models\ClassRoom;
use App\Models\Grade;
use App\Models\Section;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SectionService
{
    /**
     * get all sections (for selects/simple use)
     */
    public function getAll()
    {
        $sections = Section::with(['grade', 'classroom', 'students'])->get()->sortBy('sort_order');

        return $sections;
    }

    /**
     * Server-side Yajra DataTable
     */
    public function getSectionsDataTable(Request $request)
    {
        $query = Section::with(['grade', 'classroom'])
            ->select('sections.*');

        $query = $this->applyFilters($query, $request);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('name', fn ($row) => $row->getTranslation('name', app()->getLocale()))
            ->addColumn('grade_name', fn ($row) => $row->grade ? $row->grade->getTranslation('name', app()->getLocale()) : '-')
            ->addColumn('classroom_name', fn ($row) => $row->classroom ? $row->classroom->getTranslation('name', app()->getLocale()) : '-')
            ->addColumn('status', function ($row) {
                if ($row->status) {
                    return '<span class="badge badge-modern badge-active"><i class="las la-check-circle mr-1 ml-1"></i>'.trans('admin.global.active').'</span>';
                }

                return '<span class="badge badge-modern badge-inactive"><i class="las la-times-circle mr-1 ml-1"></i>'.trans('admin.global.disabled').'</span>';
            })
            ->addColumn('actions', fn ($row) => view('admin.sections.partials.index_actions', compact('row'))->render())
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    public function store(array $data)
    {
        if (! Classroom::find($data['classroom_id'])->status) {
            throw new \Exception(__('admin.sections.messages.failed.add'));
        }
        $section = Section::create($data);

        return $section;
    }

    public function update($section, array $data)
    {
        if (! $section->grade->status || ! $section->classroom->status) {
            throw new \Exception(__('admin.classrooms.messages.failed.update'));
        }
        $section->update($data);

        return $section;
    }

    public function delete($section)
    {
        if (! $section->grade->status || ! $section->classroom->status) {
            throw new \Exception(__('admin.sections.messages.failed.archive'));
        }
        if ($section->students->count() > 0) {
            throw new \Exception(__('admin.sections.messages.failed.has_students'));
        }
        $section->status = 0;
        $section->save();
        $section->delete();

        return true;
    }

    public function archive()
    {
        $sections = Section::with(['grade', 'classroom', 'students'])->onlyTrashed()->orderBy('sort_order')->get();

        return $sections;
    }

    public function getArchivedSectionsDataTable(Request $request)
    {
        $query = Section::with(['grade', 'classroom'])
            ->onlyTrashed()
            ->select('sections.*');

        $query = $this->applyFilters($query, $request);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('name', fn ($row) => $row->getTranslation('name', app()->getLocale()))
            ->addColumn('grade_name', fn ($row) => $row->grade ? $row->grade->getTranslation('name', app()->getLocale()) : '-')
            ->addColumn('classroom_name', fn ($row) => $row->classroom ? $row->classroom->getTranslation('name', app()->getLocale()) : '-')
            ->addColumn('deleted_at', fn ($row) => $row->deleted_at ? $row->deleted_at->format('d-m-Y') : '-')
            ->addColumn('actions', fn ($row) => view('admin.sections.partials.archived_actions', compact('row'))->render())
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getLookups()
    {
        return [
            'grades' => Grade::active()->get(),
        ];
    }

    public function restore($id)
    {
        $section = Section::withTrashed()->find($id);

        if (! $section) {
            throw new \Exception(__('admin.sections.messages.failed.restore'));
        }
        $section->restore();

        return true;
    }

    public function forceDelete($id)
    {
        $section = Section::withTrashed()->find($id);

        if (! $section) {
            throw new \Exception(__('admin.sections.messages.failed.delete'));
        }

        $section->forceDelete();

        return true;
    }

    public function getClassroomSections($id)
    {
        return Section::active()->where('classroom_id', $id)->pluck('name', 'id');
    }

    public function getGradeSections($id)
    {
        return Section::active()->where('grade_id', $id)->pluck('name', 'id');
    }

    private function applyFilters($query, Request $request)
    {
        return $query->when($request->filled('filter_grade'), function ($q) use ($request) {
            $q->where('grade_id', (int) $request->filter_grade);
        })
            ->when($request->filled('filter_classroom'), function ($q) use ($request) {
                $q->where('classroom_id', (int) $request->filter_classroom);
            })
            ->when($request->has('filter_status') && $request->filter_status !== null, function ($q) use ($request) {
                $q->where('status', (int) $request->filter_status);
            });
    }
}
