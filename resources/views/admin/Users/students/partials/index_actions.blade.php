<div class="btn-icon-list">
    {{-- ─── Show ─── --}}
    @can('view_students')
        <a class="btn btn-sm btn-light shadow-sm mx-1 show-btn text-info px-2 py-1" href="javascript:void(0)"
            data-id="{{ $row->id }}" data-student_code="{{ $row->student_code }}"
            data-name_ar="{{ $row->getTranslation('name', 'ar') }}" data-name_en="{{ $row->getTranslation('name', 'en') }}"
            data-email="{{ $row->email }}" data-national_id="{{ $row->national_id }}"
            data-date_of_birth="{{ $row->date_of_birth ? $row->date_of_birth->format('Y-m-d') : '' }}"
            data-gender="{{ optional($row->gender)->name }}" data-nationality="{{ optional($row->nationality)->name }}"
            data-blood_type="{{ optional($row->bloodType)->name }}" data-religion="{{ optional($row->religion)->name }}"
            data-grade_name="{{ optional($row->grade)->getTranslation('name', app()->getLocale()) }}"
            data-classroom_name="{{ optional($row->classroom)->getTranslation('name', app()->getLocale()) }}"
            data-section_name="{{ optional($row->section)->getTranslation('name', app()->getLocale()) }}"
            data-academic_year="{{ $row->academic_year }}"
            data-guardian_name="{{ optional($row->guardian)->name_father }}"
            data-status="{{ $row->status ? trans('admin.global.active') : trans('admin.global.disabled') }}"
            data-image="{{ $row->image_url }}" data-attachments='@json(collect($row->attachments ?? [])->map(fn($p) => asset("storage/$p")))' data-toggle="modal"
            data-target="#showModal" title="{{ trans('admin.global.view') }}" style="border-radius: 6px;">
            <i class="las la-eye tx-18"></i>
        </a>
    @endcan

    {{-- ─── Finance ─── --}}
    @can('view_students')
        <a class="btn btn-sm btn-light shadow-sm mx-1 finance-btn text-success px-2 py-1" href="javascript:void(0)"
            data-id="{{ $row->id }}" data-url="{{ route('admin.Users.students.finance', $row->id) }}"
            title="{{ trans('admin.Users.students.finance.title') }}" style="border-radius: 6px;">
            <i class="las la-wallet tx-18"></i>
        </a>
    @endcan

    {{-- ─── Grades ─── --}}
    @can('view_students')
        <a class="btn btn-sm btn-light shadow-sm mx-1 text-primary px-2 py-1"
            href="{{ route('admin.Users.students.grades', $row->id) }}" title="{{ trans('admin.Users.students.grades.title') }}"
            style="border-radius: 6px;">
            <i class="las la-chart-bar tx-18"></i>
        </a>
    @endcan

    @can('edit_students')
        <a href="javascript:void(0)" class="btn btn-info btn-sm edit-btn" data-id="{{ $row->id }}"
            data-url="{{ route('admin.Users.students.update', $row->id) }}" data-student_code="{{ $row->student_code }}"
            data-name_ar="{{ $row->getTranslation('name', 'ar') }}"
            data-name_en="{{ $row->getTranslation('name', 'en') }}" data-email="{{ $row->email }}"
            data-national_id="{{ $row->national_id }}"
            data-date_of_birth="{{ $row->date_of_birth ? $row->date_of_birth->format('d-m-Y') : '' }}"
            data-gender_id="{{ $row->gender_id }}" data-nationality_id="{{ $row->nationality_id }}"
            data-blood_type_id="{{ $row->blood_type_id }}" data-religion_id="{{ $row->religion_id }}"
            data-grade_id="{{ $row->grade_id }}" data-classroom_id="{{ $row->classroom_id }}"
            data-classroom_name="{{ $row->classroom ? $row->classroom->getTranslation('name', app()->getLocale()) : '' }}"
            data-section_id="{{ $row->section_id }}"
            data-section_name="{{ $row->section ? $row->section->getTranslation('name', app()->getLocale()) : '' }}"
            data-academic_year="{{ $row->academic_year }}" data-guardian_id="{{ $row->guardian_id }}"
            data-status="{{ $row->status }}" data-image="{{ $row->image_url }}"
            data-attachments='@json(collect($row->attachments ?? [])->map(fn($p) => asset("storage/$p")))' data-configs='@json(collect($row->attachments ?? [])->map(fn($p) => ['caption' => basename($p), 'key' => $p]))' data-toggle="modal"
            data-target="#editModal" title="{{ trans('admin.global.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
    @endcan

    @can('delete_students')
        <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-btn delete-item" data-id="{{ $row->id }}"
            data-toggle="modal" data-target="#deleteModal" data-url="{{ route('admin.Users.students.destroy', $row->id) }}"
            data-name="{{ $row->name }}" title="{{ trans('admin.global.delete') }}">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endcan
</div>
