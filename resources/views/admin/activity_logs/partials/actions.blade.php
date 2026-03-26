<div class="d-flex justify-content-center align-items-center">
    <a href="{{ route('admin.activity_logs.show', $log->id) }}" class="btn btn-sm btn-primary-gradient btn-view-log"
        data-id="{{ $log->id }}" title="{{ trans('admin.global.view') }}">
        <i class="las la-eye"></i>
    </a>
</div>
