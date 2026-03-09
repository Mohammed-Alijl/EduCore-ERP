<?php

namespace App\Helpers;

class PermissionHelper
{
    public static function translate(string $permissionName, string $model): string
    {
        $action = str_replace('_' . $model, '', $permissionName);

        $key = str_replace('-', '_', $action);

        $translations = [
            'view' => trans('admin.global.view'),
            'create' => trans('admin.global.add'),
            'edit' => trans('admin.global.edit'),
            'delete' => trans('admin.global.delete'),
            'force_delete' => trans('admin.global.force_delete'),
            'restore' => trans('admin.global.restore'),
            'view_archived' => trans('admin.global.view_archived'),
            'archive' => trans('admin.global.archive'),
            'promote' => trans('admin.global.promote'),
            'graduate' => trans('admin.global.graduate'),
            'print' => trans('admin.global.print'),
            'view_student_attempts' => trans('admin.exams.attempts.table.title'),
            'reset_attempts' => trans('admin.exams.attempts.reset_attempt'),
        ];

        if (app()->getLocale() == 'ar') {
            return $translations[$key] ?? $action;
        } else {
            return ucwords(str_replace('_', ' ', $key));
        }
    }
}
