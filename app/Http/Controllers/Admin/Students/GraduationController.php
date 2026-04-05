<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Controller;
use App\Services\Students\GraduationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class GraduationController extends Controller implements HasMiddleware
{
    public function __construct(protected readonly GraduationService $graduationService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_graduations', only: ['index']),
            new Middleware('permission:restore_graduations', only: ['restore']),
        ];
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->graduationService->getGraduatedStudentsDataTable($request);
        }

        $lookups = $this->graduationService->getLookups();

        return view('admin.Students.graduations.index', $lookups);
    }

    public function restore(int $id): JsonResponse
    {
        try {
            $this->graduationService->restore($id);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Students.graduations.messages.success.restore'),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?: __('admin.Students.graduations.messages.failed.restore'),
            ], 500);
        }
    }
}
