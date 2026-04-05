<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{

    public function __invoke(Request $request)
    {
        return $request->user('admin')->hasVerifiedEmail()
            ? redirect()->intended(route('admin.dashboard'))
            : view('admin.Auth.verify-email');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->user('admin')->hasVerifiedEmail()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        $request->user('admin')->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }

    public function verify(Request $request): RedirectResponse
    {
        if ($request->route('id') != $request->user('admin')->getKey()) {
            abort(403);
        }

        if ($request->user('admin')->hasVerifiedEmail()) {
            return redirect()->intended(route('admin.dashboard') . '?verified=1');
        }

        if ($request->user('admin')->markEmailAsVerified()) {
            event(new Verified($request->user('admin')));
        }

        return redirect()->intended(route('admin.dashboard') . '?verified=1');
    }
}
