<div class="assignment-actions-container">
    @can('edit_teacher_assignments')
        <a class="btn-assignment-edit edit-btn" href="#"
            data-edit-url="{{ route('admin.LMS.teacher_assignments.edit', $assignment->id) }}"
            data-update-url="{{ route('admin.LMS.teacher_assignments.update', $assignment->id) }}" data-id="{{ $assignment->id }}"
            title="{{ __('admin.actions.edit') }}">
            <i class="las la-pen"></i> {{ __('admin.global.edit') }}
        </a>
    @endcan

    @can('delete_teacher_assignments')
        <a class="modal-effect btn-assignment-delete delete-item" href="#" data-id="{{ $assignment->id }}"
            data-url="{{ route('admin.LMS.teacher_assignments.destroy', $assignment->id) }}"
            data-name="{{ __('admin.sidebar.teacher_assignments') }} #{{ $assignment->id }}">
            <i class="las la-trash"></i> {{ __('admin.global.delete') }}
        </a>
    @endcan
</div>
