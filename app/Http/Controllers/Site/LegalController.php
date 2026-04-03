<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\CmsService;
use Illuminate\Contracts\View\View;

class LegalController extends Controller
{
    public function __construct(private readonly CmsService $cmsService) {}

    public function privacy(): View
    {
        $page = $this->cmsService->getLegalPage('privacy-policy');

        return view('site.legal.privacy', compact('page'));
    }

    public function terms(): View
    {
        $page = $this->cmsService->getLegalPage('terms-of-service');

        return view('site.legal.terms', compact('page'));
    }

    public function cookie(): View
    {
        $page = $this->cmsService->getLegalPage('cookie-policy');

        return view('site.legal.cookie', compact('page'));
    }
}
