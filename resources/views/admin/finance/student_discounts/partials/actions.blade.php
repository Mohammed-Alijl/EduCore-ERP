{{--
    Student Discount Actions Partial

    This partial is returned by Yajra DataTables for the actions column.
    Contains ONLY a Delete/Void button - NO edit button.

    FINTECH RULE: Financial records are IMMUTABLE.
    Users can only Add new discounts or Delete/Void existing ones.
--}}
<div class="d-flex align-items-center justify-content-center gap-1">
    @can('delete_studentDiscount')
        <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-item" data-id="{{ $discount->id }}"
            data-url="{{ route('admin.student_discounts.destroy', $discount->id) }}"
            title="{{ trans('admin.global.delete') }}">
            <i class="las la-trash"></i>
        </a>
    @endcan
</div>
