<div class="d-flex align-items-center justify-content-center">
    @if($currency->is_default)
        <span class="badge badge-warning px-2 py-1 tx-11">
            <i class="las la-lock mr-1"></i>{{ trans('admin.global.protected') }}
        </span>
    @else
        @can('edit_currencies')
            <button class="btn btn-sm btn-info edit-btn mx-1" data-toggle="modal" data-target="#editCurrencyModal"
                data-url="{{ route('admin.Finance.currencies.update', $currency->id) }}" data-code="{{ $currency->code }}"
                data-name_ar="{{ $currency->getTranslation('name', 'ar') }}"
                data-name_en="{{ $currency->getTranslation('name', 'en') }}" data-exchange_rate="{{ $currency->exchange_rate }}"
                data-status="{{ (int) $currency->status }}"
                data-sort_order="{{ $currency->sort_order }}" title="{{ trans('admin.global.edit') }}">
                <i class="las la-pen"></i>
            </button>
        @endcan

        @can('delete_currencies')
            <button class="btn btn-sm btn-danger delete-item mx-1"
                data-url="{{ route('admin.Finance.currencies.destroy', $currency->id) }}" data-id="{{ $currency->id }}"
                title="{{ trans('admin.global.delete') }}">
                <i class="las la-trash"></i>
            </button>
        @endcan
    @endif
</div>
