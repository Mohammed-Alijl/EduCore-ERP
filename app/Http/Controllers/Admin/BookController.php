<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Library\BookDatatableRequest;
use App\Models\Book;
use App\Services\BookService;
use App\Services\StudentService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class BookController extends Controller implements HasMiddleware
{
    public function __construct(
        protected readonly BookService $bookService,
        protected readonly StudentService $studentService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_library', only: ['index', 'datatable']),
            new Middleware('permission:download_library', only: ['download']),
            new Middleware('permission:delete_library', only: ['destroy']),
        ];
    }

    public function index()
    {
        $lookups = $this->studentService->getLookups();
        return view('admin.library.index', $lookups);
    }

    public function datatable(BookDatatableRequest $request)
    {
        if ($request->ajax()) {
            $query = $this->bookService->getBooksQuery($request->validated());
            return $this->bookService->datatable($query);
        }

        abort(403, 'Unauthorized action.');
    }

    public function download(Book $book)
    {
        $download = $this->bookService->downloadBook($book);

        if (!$download) {
            abort(404, trans('admin.books.messages.failed.download'));
        }

        return $download;
    }


    public function destroy(Book $book)
    {
        try {
            $deleted = $this->bookService->deleteBook($book);

                if ($deleted) {
                return response()->json([
                    'status' => 'success',
                    'message' => trans('admin.books.messages.success.delete')
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => trans('admin.books.messages.failed.delete')
            ], 400);
        } catch (\Exception $e) {
            \Log::error('Book deletion failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => trans('admin.books.messages.failed.delete')
            ], 500);
        }
    }
}