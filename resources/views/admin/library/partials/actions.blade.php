<div class="btn-icon-list">
    @can('download_library')
        <a href="{{ route('admin.library.download', $book->id) }}" class="btn btn-sm btn-success mx-1" data-toggle="tooltip"
            title="{{ trans('admin.books.actions.download') }}">
            <i class="las la-download"></i>
        </a>
    @endcan

    @can('delete_library')
        <button class="btn btn-sm btn-danger delete-item mx-1" data-url="{{ route('admin.library.destroy', $book->id) }}" data-id="{{ $book->id }}" title="{{ __('admin.books.actions.delete') }}">
            <i class="las la-trash"></i>
        </button>
    @endcan
</div>
