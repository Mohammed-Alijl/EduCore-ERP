<?php

namespace App\Services;

use App\Models\StudentEnrollment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PromotionHistoryService
{
    public function getPromotionHistoryDataTable(Request $request)
    {
        $query = StudentEnrollment::with([
            'student',
            'fromGrade',
            'fromClassroom',
            'fromSection',
            'fromAcademicYear',
            'toGrade',
            'toClassroom',
            'toSection',
            'toAcademicYear',
            'admin',
        ])->latest();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('student_name', function ($enrollment) {
                return $enrollment->student?->name ?? '-';
            })
            ->addColumn('student_code', function ($enrollment) {
                return $enrollment->student?->student_code ?? '-';
            })
            ->addColumn('from_details', function ($enrollment) {
                $fromYear = $enrollment->fromAcademicYear?->name ?? '-';
                $fromGrade = $enrollment->fromGrade?->name ?? '-';
                $fromClassroom = $enrollment->fromClassroom?->name ?? '-';
                $fromSection = $enrollment->fromSection?->name ?? '-';

                return '<span class="badge badge-secondary p-2">
                            <i class="fas fa-calendar-alt mr-1"></i>'.$fromYear.'<br>
                            <i class="fas fa-layer-group mr-1"></i>'.$fromGrade.' / '.$fromClassroom.' / '.$fromSection.'
                        </span>';
            })
            ->addColumn('to_details', function ($enrollment) {
                $toYear = $enrollment->toAcademicYear?->name ?? '-';
                $toGrade = $enrollment->toGrade?->name ?? '-';
                $toClassroom = $enrollment->toClassroom?->name ?? '-';
                $toSection = $enrollment->toSection?->name ?? '-';

                return '<span class="badge badge-success p-2">
                            <i class="fas fa-calendar-alt mr-1"></i>'.$toYear.'<br>
                            <i class="fas fa-layer-group mr-1"></i>'.$toGrade.' / '.$toClassroom.' / '.$toSection.'
                        </span>';
            })
            ->addColumn('enrollment_status', function ($enrollment) {
                $statusBadges = [
                    'promoted' => '<span class="badge badge-success"><i class="fas fa-arrow-up mr-1"></i>'.trans('admin.promotions.status_promoted').'</span>',
                    'graduated' => '<span class="badge badge-danger"><i class="fas fa-graduation-cap mr-1"></i>'.trans('admin.promotions.status_graduated').'</span>',
                    'repeating' => '<span class="badge badge-warning"><i class="fas fa-redo mr-1"></i>'.trans('admin.promotions.status_repeating').'</span>',
                ];

                return $statusBadges[$enrollment->enrollment_status->value] ?? '<span class="badge badge-secondary">'.trans('admin.global.unknown').'</span>';
            })
            ->addColumn('admin_name', function ($enrollment) {
                return $enrollment->admin?->name ?? '-';
            })
            ->addColumn('promotion_date', function ($enrollment) {
                return $enrollment->created_at?->format('Y-m-d H:i') ?? '-';
            })
            ->addColumn('actions', function ($enrollment) {
                return '<button class="btn btn-sm btn-danger btn-rollback" data-id="'.$enrollment->id.'" title="'.trans('admin.promotions.rollback_tooltip').'">
                            <i class="fas fa-undo mr-1"></i>'.trans('admin.promotions.rollback_btn').'
                        </button>';
            })
            ->rawColumns(['from_details', 'to_details', 'enrollment_status', 'actions'])
            ->make(true);
    }
}
