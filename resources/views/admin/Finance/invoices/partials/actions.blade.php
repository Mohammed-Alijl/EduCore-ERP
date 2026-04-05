<div class="d-flex align-items-center justify-content-center gap-1">

    @can('print_invoices')
        <a href="{{ route('admin.Finance.invoices.print', $invoice->id) }}" target="_blank" rel="noopener"
            class="btn btn-sm btn-secondary mx-1" title="{{ trans('admin.global.print') }}">
            <i class="las la-print"></i>
        </a>
    @endcan

    @can('view_invoices')
        <button type="button" class="btn btn-sm btn-info view-invoice-btn mx-1" data-id="{{ $invoice->id }}"
            data-student_name="{{ $invoice->student->name ?? '—' }}"
            data-student_code="{{ $invoice->student->student_code ?? '—' }}"
            data-fee_title="{{ $invoice->fee->title ?? '—' }}"
            data-fee_category="{{ $invoice->fee->feeCategory->title ?? '—' }}"
            data-academic_year="{{ $invoice->academicYear->name ?? '—' }}"
            data-amount="{{ number_format($invoice->amount, 2) }}" data-description="{{ $invoice->description ?? '' }}"
            data-invoice_date="{{ $invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : '—' }}"
            title="{{ trans('admin.global.view') }}">
            <i class="las la-eye"></i>
        </button>
    @endcan

    @can('delete_invoices')
        <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-btn delete-item" data-id="{{ $invoice->id }}"
            data-toggle="modal" data-target="#deleteModal" data-url="{{ route('admin.Finance.invoices.destroy', $invoice->id) }}"
            title="{{ trans('admin.global.delete') }}">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endcan

</div>
