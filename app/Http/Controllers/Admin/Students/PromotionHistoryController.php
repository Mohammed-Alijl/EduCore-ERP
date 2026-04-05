<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Controller;
use App\Services\PromotionHistoryService;
use App\Services\StudentPromotionService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PromotionHistoryController extends Controller implements HasMiddleware
{
    public function __construct(
        protected readonly PromotionHistoryService $historyService,
        protected readonly StudentPromotionService $promotionService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_promotion_history', only: ['index']),
            new Middleware('permission:rollback_promotions', only: ['rollback']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->historyService->getPromotionHistoryDataTable($request);
        }

        return view('admin.Students.promotions.history');
    }

    public function rollback(int $id)
    {
        try {
            $this->promotionService->rollbackPromotion($id);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Students.promotions.messages.success.rollback'),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage() ?: __('admin.Students.promotions.messages.failed.rollback'),
            ], 500);
        }
    }
}
