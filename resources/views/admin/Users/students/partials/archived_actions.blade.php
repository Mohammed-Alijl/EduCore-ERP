<div class="d-flex justify-content-center align-items-center">

    {{-- ─── Show ─── --}}
    @can('view-archived_students')
        <a class="btn btn-sm btn-light shadow-sm mx-1 show-btn text-info px-2 py-1"
           href="javascript:void(0)"
           data-id="{{ $row->id }}"
           data-student_code="{{ $row->student_code }}"
           data-name_ar="{{ $row->getTranslation('name', 'ar') }}"
           data-name_en="{{ $row->getTranslation('name', 'en') }}"
           data-email="{{ $row->email }}"
           data-national_id="{{ $row->national_id }}"
           data-date_of_birth="{{ $row->date_of_birth ? $row->date_of_birth->format('Y-m-d') : '' }}"
           data-gender="{{ optional($row->gender)->name }}"
           data-nationality="{{ optional($row->nationality)->name }}"
           data-blood_type="{{ optional($row->bloodType)->name }}"
           data-religion="{{ optional($row->religion)->name }}"
           data-grade_name="{{ optional($row->grade)->getTranslation('name', app()->getLocale()) }}"
           data-classroom_name="{{ optional($row->classroom)->getTranslation('name', app()->getLocale()) }}"
           data-section_name="{{ optional($row->section)->getTranslation('name', app()->getLocale()) }}"
           data-academic_year="{{ $row->academic_year }}"
           data-guardian_name="{{ optional($row->guardian)->name_father }}"
           data-status="{{ $row->status ? trans('admin.global.active') : trans('admin.global.disabled') }}"
           data-image="{{ $row->image_url }}"
           data-attachments='@json(collect($row->attachments ?? [])->map(fn($p) => asset("storage/$p")))'
           data-toggle="modal" data-target="#showModal"
           title="{{ trans('admin.global.view') }}"
           style="border-radius: 6px;">
            <i class="las la-eye tx-18"></i>
        </a>
    @endcan

    {{-- ─── Restore ─── --}}
    @can('restore_students')
        <a class="btn btn-sm btn-light shadow-sm mx-1 restore-item text-success px-2 py-1"
           href="javascript:void(0)"
           data-url="{{ route('admin.Users.students.restore', $row->id) }}"
           data-id="{{ $row->id }}"
           data-name="{{ $row->getTranslation('name', app()->getLocale()) }}"
           title="{{ trans('admin.global.restore') }}"
           style="border-radius: 6px;">
            <i class="las la-trash-restore tx-18"></i>
        </a>
    @endcan

    {{-- ─── Force Delete ─── --}}
    @can('force-delete_students')
        <a class="btn btn-sm btn-light shadow-sm mx-1 delete-item text-danger px-2 py-1"
           href="javascript:void(0)"
           data-url="{{ route('admin.Users.students.forceDelete', $row->id) }}"
           data-id="{{ $row->id }}"
           data-name="{{ $row->getTranslation('name', app()->getLocale()) }}"
           title="{{ trans('admin.global.delete') }}"
           style="border-radius: 6px;">
            <i class="las la-skull-crossbones tx-18"></i>
        </a>
    @endcan

</div>