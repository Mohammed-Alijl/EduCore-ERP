<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    use UploadImageTrait;

    public function index()
    {
        return view('admin.Auth.profile');
    }

    public function updateProfile(Request $request)
    {
        $admin = auth('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $admin->update($request->only('name', 'email'));

        return response()->json([
            'status' => 'success',
            'message' => trans('admin.profile.messages.update')
        ]);
    }

    public function updatePassword(Request $request)
    {
        $admin = auth('admin')->user();

        $request->validate([
            'current_password' => 'required|current_password:admin',
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $admin->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => trans('admin.profile.messages.update_password')
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $admin = auth('admin')->user();

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($admin->image_path) {
                $this->deleteImage($admin->image_path);
            }
            $imagePath = $this->uploadImage($request->file('image'), 'admins');
            $admin->update(['image_path' => $imagePath]);
        }

        return response()->json([
            'status' => 'success',
            'message' => trans('admin.profile.messages.update_avatar')
        ]);
    }
}
