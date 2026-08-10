<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Whether the user holds a given permission.
     *
     * NOTE: A full roles/permissions system is not built yet. Until then every
     * authenticated user is treated as fully privileged so the admin menu and
     * sections are all reachable. Replace this with a real roles lookup once the
     * permissions module exists.
     */
    public function hasPermission(string $permission): bool
    {
        return true;
    }

    /**
     * Whether the user is a super admin.
     *
     * Placeholder until roles exist — see {@see hasPermission()}.
     */
    public function isSuperAdmin(): bool
    {
        return true;
    }
}
