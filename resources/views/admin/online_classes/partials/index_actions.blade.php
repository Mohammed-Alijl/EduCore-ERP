<div class="btn-icon-list">
    @can('view_online_classes')
        <a href="javascript:void(0)" class="btn btn-sm btn-light shadow-sm mx-1 online-class-show-btn text-info px-2 py-1"
            data-url="{{ route('admin.online_classes.show', $row->id) }}" title="{{ trans('admin.global.view') }}">
            <i class="las la-eye tx-18"></i>
        </a>
    @endcan

    @can('delete_online_classes')
        <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-item mx-1" data-id="{{ $row->id }}"
            data-url="{{ route('admin.online_classes.destroy', $row->id) }}"
            data-name="{{ $row->topic ?? ($row->subject->name ?? 'online-class') }}"
            title="{{ trans('admin.global.delete') }}">
            <i class="las la-trash"></i>
        </a>
    @endcan
</div>
