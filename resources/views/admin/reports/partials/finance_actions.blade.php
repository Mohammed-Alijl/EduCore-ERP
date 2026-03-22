{{-- View Student Ledger Button --}}
<button type="button" class="btn btn-sm btn-outline-primary student-finance-btn"
    data-student-id="{{ $row->id }}"
    style="border-radius: 8px; padding: 0.375rem 0.875rem; font-weight: 600;" data-toggle="tooltip"
    data-placement="top" title="{{ trans('admin.reports.financial.actions.view_ledger') }}">
    <i class="las la-file-invoice-dollar" style="font-size: 1.125rem;"></i>
    <span class="d-none d-md-inline ml-1 mr-1">
        {{ trans('admin.reports.financial.actions.ledger') }}
    </span>
</button>

<script>
    // Initialize tooltips for action buttons
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
