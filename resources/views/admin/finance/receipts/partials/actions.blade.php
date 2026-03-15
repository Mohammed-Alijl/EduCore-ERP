<div class="receipt-actions-container">

    @can('print_receipts')
        <a href="{{ route('admin.receipts.print', $receipt->id) }}" target="_blank" rel="noopener"
            class="btn btn-sm btn-receipt-print" title="{{ trans('admin.global.print') }}">
            <i class="las la-print"></i>
        </a>
    @endcan

    @can('view_receipts')
        <button type="button" class="btn btn-sm btn-receipt-view view-receipt-btn"
            data-id="{{ $receipt->id }}"
            data-receipt_number="{{ $receipt->receipt_number }}"
            data-student_name="{{ $receipt->student->name ?? '—' }}"
            data-student_code="{{ $receipt->student->student_code ?? '—' }}"
            data-invoice_id="{{ $receipt->invoice_id }}"
            data-academic_year="{{ $receipt->academicYear->name ?? '—' }}"
            data-amount="{{ number_format($receipt->amount, 2) }}"
            data-payment_method="{{ $receipt->payment_method }}"
            data-description="{{ $receipt->description ?? '' }}"
            data-receipt_date="{{ $receipt->receipt_date ? $receipt->receipt_date->format('Y-m-d') : '—' }}"
            title="{{ trans('admin.global.view') }}">
            <i class="las la-eye"></i>
        </button>
    @endcan

    @can('delete_receipts')
        <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-receipt-delete delete-btn delete-item"
            data-id="{{ $receipt->id }}"
            data-toggle="modal" data-target="#deleteModal"
            data-url="{{ route('admin.receipts.destroy', $receipt->id) }}"
            title="{{ trans('admin.global.delete') }}">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endcan

</div>
