<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'google_id',
        'facebook_id',
        'avatar',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ⬇️ TAMBAHAN AMAN (tidak ganggu kode lain)
    protected $appends = ['days_left'];

    public function getDaysLeftAttribute()
    {
        if (!$this->deleted_at) {
            return null;
        }

        return now()->diffInDays(
            $this->deleted_at->copy()->addDays(7),
            false
        );
    }
    // ⬆️ SELESAI TAMBAHAN

    // ⬇️ FIX ERROR hasPendingUsernameVerification
    public function hasPendingUsernameVerification(): bool
    {
        return false;
    }
    // ⬆️ SELESAI FIX

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    // Tambahkan ini di class User, di bawah method isUser() misal
public function sendPasswordResetNotification($token)
{
    $this->notify(new \App\Notifications\CustomResetPassword($token));
}

}
