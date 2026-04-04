<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Promotion\StoreRequest;
use App\Services\StudentPromotionService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StudentPromotionController extends Controller implements HasMiddleware
{
    public function __construct(protected StudentPromotionService $promotionService) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:promote_students', only: ['index', 'store']),
        ];
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'from_grade_id',
            'from_classroom_id',
            'from_section_id',
            'from_academic_year_id',
        ]);

        $lookups = $this->promotionService->getLookups();
        $students = null;

        if ($this->promotionService->hasPromotionFilters($filters)) {
            $students = $this->promotionService->getStudentsForPromotion($filters);
        }

        return view('admin.students.promotions', array_merge($lookups, [
            'students' => $students,
        ]));
    }

    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            if (!empty($payload['graduate_student_ids']) && !auth('admin')->user()->can('graduate_students')) {
                throw new \Exception(__('admin.promotions.messages.failed.unauthorized_graduate'));
            }

            $result = $this->promotionService->promote($payload);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.promotions.messages.success.promote', $result),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?: __('admin.promotions.messages.failed.promote'),
            ], 500);
        }
    }
}
