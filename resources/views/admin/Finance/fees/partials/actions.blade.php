<div class="d-flex align-items-center justify-content-center">
    @can('view_fees')
        <button class="btn btn-sm btn-primary show-btn mx-1"
                data-title_ar="{{ $fee->getTranslation('title', 'ar') }}"
                data-title_en="{{ $fee->getTranslation('title', 'en') }}"
                data-amount="{{ $fee->amount }}"
                data-category_name="{{ $fee->feeCategory->title ?? '' }}"
                data-academic_year_name="{{ $fee->academicYear->name ?? '' }}"
                data-grade_name="{{ $fee->grade->name ?? '' }}"
                data-classroom_name="{{ $fee->classroom->name ?? '' }}"
                data-description="{{ $fee->description }}"
                title="{{ __('admin.Finance.finance.fees.show') }}">
            <i class="las la-eye"></i>
        </button>
    @endcan
    @can('edit_fees')
        <button class="btn btn-sm btn-info edit-btn mx-1"
                data-toggle="modal" data-target="#editFeeModal"
                data-url="{{ route('admin.Finance.fees.update', $fee->id) }}"
                data-title_ar="{{ $fee->getTranslation('title', 'ar') }}"
                data-title_en="{{ $fee->getTranslation('title', 'en') }}"
                data-description="{{ $fee->description }}"
                data-amount="{{ $fee->amount }}"
                data-fee_category_id="{{ $fee->fee_category_id }}"
                data-academic_year_id="{{ $fee->academic_year_id }}"
                data-grade_id="{{ $fee->grade_id }}"
                data-classroom_id="{{ $fee->classroom_id }}"
                title="{{ __('admin.global.edit') }}">
            <i class="las la-pen"></i>
        </button>
    @endcan

    @can('delete_fees')
        <button class="btn btn-sm btn-danger delete-item mx-1"
                data-url="{{ route('admin.Finance.fees.destroy', $fee->id) }}"
                data-id="{{ $fee->id }}"
                title="{{ __('admin.global.delete') }}">
            <i class="las la-trash"></i>
        </button>
    @endcan
</div>
