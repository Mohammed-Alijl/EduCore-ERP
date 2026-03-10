<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Str;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;

class BookService
{

    public function getBooksQuery(array $filters): Builder
    {
        $query = Book::with(['grade', 'classroom', 'section', 'teacher', 'subject']);

        return $this->applyFilters($query, $filters);
    }

    public function datatable($query)
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('title', fn($row) => '<strong>' . e($row->title) . '</strong><br><small class="text-muted">' . e(Str::limit($row->description, 30)) . '</small>')
            ->addColumn('academic_target', function ($row) {
                $target = '<span class="badge badge-info">' . e($row->grade->name) . '</span>';
                if ($row->classroom) $target .= ' <i class="las la-angle-left tx-10"></i> <span class="badge badge-light">' . e($row->classroom->name) . '</span>';
                if ($row->section) $target .= ' <i class="las la-angle-left tx-10"></i> <span class="badge badge-light">' . e($row->section->name) . '</span>';
                return $target;
            })
            ->addColumn('teacher', fn($row) => $row->teacher->name)
            ->addColumn('subject', fn($row) => '<span class="badge badge-warning">' . e($row->subject->name) . '</span>')
            ->addColumn('actions', function ($row) {
                return view('admin.library.partials.actions', ['book' => $row])->render();
            })
            ->rawColumns(['title', 'academic_target', 'subject', 'actions'])
            ->make(true);
    }


    public function deleteBook(Book $book): bool
    {
        $deleted = $book->delete();

        if ($deleted) {
            $filePath = $this->getBookFilePath($book);
            if (Storage::disk('local')->exists($filePath)) {
                Storage::disk('local')->delete($filePath);
            }
        }

        return $deleted;
    }

    public function downloadBook(Book $book)
    {
        if (empty($book->file_name)) {
            return null;
        }

        $filePath = $this->getBookFilePath($book);

        if (Storage::disk('local')->exists($filePath)) {
            return Storage::disk('local')->download($filePath, $book->title . '.' . pathinfo($book->file_name, PATHINFO_EXTENSION));
        }

        return null;
    }

    public function getLookups()
    {
        return [
            'grades'        => Grade::all(),
            'subjects'      => Subject::all(),
            'teachers'      => Teacher::all(),
        ];
    }

    private function getBookFilePath(Book $book): string
    {
        return 'library/' . $book->file_name;
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query->when(!empty($filters['grade_id']), fn($q) => $q->where('grade_id', $filters['grade_id']));
        $query->when(!empty($filters['classroom_id']), fn($q) => $q->where('classroom_id', $filters['classroom_id']));
        $query->when(!empty($filters['section_id']), fn($q) => $q->where('section_id', $filters['section_id']));
        $query->when(!empty($filters['teacher_id']), fn($q) => $q->where('teacher_id', $filters['teacher_id']));
        $query->when(!empty($filters['subject_id']), fn($q) => $q->where('subject_id', $filters['subject_id']));

        return $query->latest();
    }
}
