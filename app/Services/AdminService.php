<?php

namespace App\Services;

use App\Models\Admin;
use App\Traits\UploadImageTrait;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Auth\Events\Registered;

class AdminService
{
    use UploadImageTrait;

    public function getAll()
    {
        return Admin::where('id', '!=', auth()->id())->latest()->get();
    }

    public function store(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        if (isset($data['image']) && $data['image']) {
            $data['image_path'] = $this->uploadImage($data['image'], 'admins');
        } else {
            $data['image_path'] = null;
        }

        $admin = Admin::create($data);

        $admin->assignRole($data['roles_name']);

        event(new Registered($admin));

        return $admin;
    }

    public function update($admin, array $data)
    {
        if($admin->hasRole('Super Admin'))
            throw new Exception( __('admin.admins.messages.failed.update'));
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data = Arr::except($data, ['password']);
        }

        if (isset($data['image']) && $data['image']) {
            if ($admin->image_path) {
                $this->deleteImage($admin->image_path);
            }
            $data['image_path'] = $this->uploadImage($data['image'], 'admins');
        }

        $admin->update($data);

        $admin->syncRoles($data['roles_name']);

        return $admin;
    }

    public function delete($admin)
    {
        if($admin->hasRole('Super Admin'))
            throw new Exception( __('admin.admins.messages.failed.delete'));

        if ($admin->image_path) {
            $this->deleteImage($admin->image_path);
        }

        $admin->delete();
        return true;
    }
}
