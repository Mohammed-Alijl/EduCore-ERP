<div class="btn-icon-list">
    {{-- View --}}
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

    @if($row->grade && $row->grade->status && $row->classroom && $row->classroom->status)
        @can('edit_sections')
            <a href="javascript:void(0)" class="btn btn-info btn-sm edit-btn mx-1"
               data-id="{{ $row->id }}"
               data-url="{{ route('admin.Academic.sections.update', $row->id) }}"
               data-name_ar="{{ $row->getTranslation('name', 'ar') }}"
               data-name_en="{{ $row->getTranslation('name', 'en') }}"
               data-grade_id="{{ $row->grade_id }}"
               data-classroom_id="{{ $row->classroom_id }}"
               data-notes="{{ $row->notes }}"
               data-status="{{ $row->status }}"
               data-toggle="modal" data-target="#editModal"
               title="{{ trans('admin.global.edit') }}">
                <i class="las la-pen"></i>
            </a>
        @endcan
        @can('delete_sections')
            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-item mx-1"
               data-id="{{ $row->id }}"
               data-url="{{ route('admin.Academic.sections.destroy', $row->id) }}"
               data-name="{{ $row->name }}"
               title="{{ trans('admin.global.delete') }}">
                <i class="las la-trash"></i>
            </a>
        @endcan
    @else
        <span class="text-muted"><i class="las la-lock"></i> {{ trans('admin.global.disabled') }}</span>
    @endif
</div>
