<div class="d-flex align-items-center justify-content-center gap-1">
    @can('print_paymentVoucher')
        <a href="{{ route('admin.payment_vouchers.print', $voucher->id) }}" class="btn btn-info btn-sm"
            title="{{ trans('admin.global.print') }}" target="_blank">
            <i class="las la-print"></i>
        </a>
    @endcan
    @can('delete_paymentVoucher')
        <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-item" data-id="{{ $voucher->id }}"
            data-url="{{ route('admin.payment_vouchers.destroy', $voucher->id) }}"
            title="{{ trans('admin.global.delete') }}">
            <i class="las la-trash"></i>
        </a>
    @endcan
</div>
