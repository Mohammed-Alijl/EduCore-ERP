<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the guardian dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('guardian.index');
    }
}
