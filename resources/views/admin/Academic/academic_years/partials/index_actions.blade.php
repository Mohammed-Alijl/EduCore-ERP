<div class="btn-icon-list">
    @can('view_years')
        <a href="javascript:void(0)" class="btn btn-sm btn-light shadow-sm mx-1 show-academic-year-btn text-info px-2 py-1"
            data-name="{{ $year->name }}" data-starts_at="{{ $year->starts_at?->format('Y-m-d') ?? '-' }}"
            data-ends_at="{{ $year->ends_at?->format('Y-m-d') ?? '-' }}" data-is_current="{{ $year->is_current ? 1 : 0 }}"
            title="{{ __('admin.global.view') }}">
            <i class="las la-eye tx-18"></i>
        </a>
    @endcan

    @can('edit_years')
        <a href="javascript:void(0)" class="btn btn-info btn-sm academic-year-edit-btn edit-btn mx-1"
            data-url="{{ route('admin.Academic.academic_years.update', $year->id) }}" data-name="{{ $year->name }}"
            data-starts_at_raw="{{ optional($year->starts_at)->format('Y-m-d') }}"
            data-ends_at_raw="{{ optional($year->ends_at)->format('Y-m-d') }}"
            data-is_current="{{ $year->is_current ? 1 : 0 }}" data-target="#editModal" data-toggle="modal"
            title="{{ __('admin.global.edit') }}">
            <i class="las la-pen"></i>
        </a>
    @endcan
</div>
