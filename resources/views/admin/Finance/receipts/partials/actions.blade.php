<div class="d-flex align-items-center justify-content-center gap-1">

    @can('print_receipts')
        <a href="{{ route('admin.Finance.receipts.print', $receipt->id) }}" target="_blank" rel="noopener"
            class="btn btn-sm btn-secondary" title="{{ trans('admin.global.print') }}">
            <i class="las la-print"></i>
        </a>
    @endcan

    @can('delete_receipts')
        <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-item" data-id="{{ $receipt->id }}"
            data-url="{{ route('admin.Finance.receipts.destroy', $receipt->id) }}" title="{{ trans('admin.global.delete') }}">
            <i class="las la-trash"></i>
        </a>
    @endcan

</div>
