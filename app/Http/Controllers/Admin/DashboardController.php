<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(public DashboardService $dashboardService) {}

    public function index(): View
    {
        $kpis = $this->dashboardService->getKpis();

        return view('admin.index', $kpis);
    }
}
