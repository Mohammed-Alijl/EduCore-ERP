<?php

namespace App\Http\Controllers\Guardian\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guardian\Auth\LoginRequest;
use App\Models\Users\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuardianAuthController extends Controller
{
    public function create()
    {
        return view('guardian.auth.login');
    }

    public function store(LoginRequest $request)
    {
        if (Auth::guard('guardian')->attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('guardian.dashboard');
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::guard('guardian')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('guardian.login');
    }
}
