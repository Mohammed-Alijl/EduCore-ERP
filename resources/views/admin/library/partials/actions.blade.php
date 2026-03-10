<div class="btn-icon-list">
    @can('download_library')
        <a href="{{ route('admin.library.download', $book->id) }}" class="btn btn-sm btn-success me-1 mx-1" title="{{ __('admin.books.actions.download', [], 'ar') }}">
            <i class="las la-download"></i>
        </a>
    @endcan

    @can('delete_library')
        <button class="btn btn-sm btn-danger delete-btn delete-item mx-1" data-id="{{ $book->id }}" title="{{ __('admin.books.actions.delete', [], 'ar') }}">
            <i class="las la-trash"></i>
        </button>
    @endcan
</div>
