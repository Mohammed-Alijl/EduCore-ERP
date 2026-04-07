<div class="d-flex justify-content-center align-items-center">

    {{-- ─── Restore to Active Status ─── --}}
    @can('restore_graduations')
        <a class="btn btn-sm btn-light shadow-sm mx-1 restore-item text-success px-2 py-1"
           href="javascript:void(0)"
           data-url="{{ route('admin.Students.graduations.restore', $row->id) }}"
           data-id="{{ $row->id }}"
           data-name="{{ $row->getTranslation('name', app()->getLocale()) }}"
           title="{{ trans('admin.Users.students.graduations.restore_btn') }}"
           style="border-radius: 6px;">
            <i class="las la-undo-alt tx-18"></i>
        </a>
    @endcan

</div>
