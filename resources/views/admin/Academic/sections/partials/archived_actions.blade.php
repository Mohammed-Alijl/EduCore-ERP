<div class="d-flex justify-content-center align-items-center">

    {{-- ─── View ─── --}}
    <a class="btn btn-sm btn-light shadow-sm mx-1 show-btn text-info px-2 py-1"
       href="javascript:void(0)"
       data-id="{{ $row->id }}"
       data-name_ar="{{ $row->getTranslation('name', 'ar') }}"
       data-name_en="{{ $row->getTranslation('name', 'en') }}"
       data-grade_name="{{ optional($row->grade)->getTranslation('name', app()->getLocale()) }}"
       data-classroom_name="{{ optional($row->classroom)->getTranslation('name', app()->getLocale()) }}"
       data-notes="{{ $row->notes }}"
       data-status="{{ $row->status }}"
       data-status_text="{{ $row->status ? trans('admin.global.active') : trans('admin.global.disabled') }}"
       data-students_url="{{ route('admin.Academic.sections.students', $row->id) }}"
       data-toggle="modal" data-target="#showModal"
       title="{{ trans('admin.global.view') }}"
       style="border-radius: 6px;">
        <i class="las la-eye tx-18"></i>
    </a>

    {{-- ─── Restore ─── --}}
    @can('restore_sections')
        <a class="btn btn-sm btn-light shadow-sm mx-1 restore-item text-success px-2 py-1"
           href="javascript:void(0)"
           data-url="{{ route('admin.Academic.sections.restore', $row->id) }}"
           data-id="{{ $row->id }}"
           data-name="{{ $row->getTranslation('name', app()->getLocale()) }}"
           title="{{ trans('admin.global.restore') }}"
           style="border-radius: 6px;">
            <i class="las la-trash-restore tx-18"></i>
        </a>
    @endcan

    {{-- ─── Force Delete ─── --}}
    @can('force-delete_sections')
        <a class="btn btn-sm btn-light shadow-sm mx-1 delete-item text-danger px-2 py-1"
           href="javascript:void(0)"
           data-url="{{ route('admin.Academic.sections.forceDelete', $row->id) }}"
           data-id="{{ $row->id }}"
           data-name="{{ $row->getTranslation('name', app()->getLocale()) }}"
           title="{{ trans('admin.global.delete') }}"
           style="border-radius: 6px;">
            <i class="las la-skull-crossbones tx-18"></i>
        </a>
    @endcan

</div>
