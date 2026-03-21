<div class="d-flex align-items-center justify-content-center gap-1">
    @can('delete_paymentVoucher')
        <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-item" data-id="{{ $voucher->id }}"
            data-url="{{ route('admin.payment_vouchers.destroy', $voucher->id) }}" title="{{ trans('admin.global.delete') }}">
            <i class="las la-trash"></i>
        </a>
    @endcan
</div>
