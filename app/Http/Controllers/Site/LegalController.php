<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class LegalController extends Controller
{
    public function privacy(): View
    {
        return view('site.legal.privacy');
    }

    public function terms(): View
    {
        return view('site.legal.terms');
    }

    public function cookie(): View
    {
        return view('site.legal.cookie');
    }
}
