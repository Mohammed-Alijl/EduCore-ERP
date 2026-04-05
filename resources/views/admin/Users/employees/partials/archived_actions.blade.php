@canany(['restore_employees','force-delete_employees'])
    <div class="teacher-actions-container">
        @can('restore_employees')
            <a class="btn btn-sm btn-teacher-restore restore-item"
               href="#"
               data-url="{{ route('admin.Users.employees.restore', $row->id) }}"
               data-id="{{ $row->id }}"
               data-name="{{ $row->name }}"
            >
                <i class="las la-store"></i> {{__('admin.global.restore')}}
            </a>
        @endcan
        @can('force-delete_employees')
            <a class="btn btn-sm btn-teacher-delete delete-item"
               href="#"
               data-id="{{ $row->id }}"
               data-url="{{ route('admin.Users.employees.forceDelete', $row->id) }}"
               data-name="{{ $row->name }}">
                <i class="las la-trash"></i> {{trans('admin.global.delete')}}
            </a>
        @endcan
    </div>
@endcanany
