<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
public function create(): View
{
return view('admin.Auth.forgot-password');
}

public function store(Request $request)
{
$request->validate(['email' => ['required', 'email','exists:admins,email']]);
$status = Password::broker('admins')->sendResetLink(
$request->only('email')
);

return $status == Password::RESET_LINK_SENT
? back()->with('status', __($status))
: back()->withInput($request->only('email'))
->withErrors(['email' => __($status)]);
}
}
