<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'pin'])]
#[Hidden(['password', 'remember_token', 'pin'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'pin' => 'hashed',
        ];
    }

    public function canManage(string $module): bool
    {
        $requiredRole = config("permissions.$module", 'admin');

        if ($requiredRole === 'staff') {
            return true;
        }

        return $this->role === 'admin';
    }

    public function verifyPin(string $pin): bool
    {
        return $this->pin && \Illuminate\Support\Facades\Hash::check($pin, $this->pin);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucwords(strtolower($value)),
        );
    }
}