<div class="d-flex align-items-center justify-content-center">
    @can('edit_fees')
        <button class="btn btn-sm btn-info edit-btn mx-1"
                data-toggle="modal" data-target="#editFeeCategoryModal"
                data-url="{{ route('admin.Finance.fee_categories.update', $feeCategory->id) }}"
                data-title_ar="{{ $feeCategory->getTranslation('title', 'ar') }}"
                data-title_en="{{ $feeCategory->getTranslation('title', 'en') }}"
                data-description="{{ $feeCategory->description }}"
                title="{{ __('admin.global.edit') }}">
            <i class="las la-pen"></i>
        </button>
    @endcan

    @can('delete_fees')
        <button class="btn btn-sm btn-danger delete-item mx-1"
                data-url="{{ route('admin.Finance.fee_categories.destroy', $feeCategory->id) }}"
                data-id="{{ $feeCategory->id }}"
                title="{{ __('admin.global.delete') }}">
            <i class="las la-trash"></i>
        </button>
    @endcan
</div>
