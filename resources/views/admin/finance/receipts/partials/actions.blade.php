@can('delete_receipts')
    <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-btn" data-id="{{ $receipt->id }}"
        title="{{ trans('admin.global.delete') }}">
        <i class="las la-trash"></i>
    </a>
@endcan
