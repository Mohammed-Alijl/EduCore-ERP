<?php

namespace App\Models\Users;

use App\Notifications\Admin\AdminVerifyEmail;
use App\Notifications\Admin\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $guard = 'admin';

    protected $fillable = ["name", "email", "password", "status", "roles_name", "image_path"];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'roles_name' => 'array',
        ];
    }

    public function getImageUrlAttribute()
    {
        if (!empty($this->image_path)) {
            return asset('storage/' . $this->image_path);
        }
        return asset('assets/admin/img/faces/admin.png');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new AdminVerifyEmail);
    }
}
