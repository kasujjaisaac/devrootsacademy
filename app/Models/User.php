<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_admin',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true || $this->role === 'admin';
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public static function generateUsername(?string $preferred = null, ?string $fallback = null): string
    {
        $base = $preferred ?: $fallback ?: 'student';
        $candidate = Str::of($base)
            ->lower()
            ->replaceMatches('/@.*/', '')
            ->slug('_')
            ->value();

        $candidate = $candidate !== '' ? $candidate : 'student';
        $username = $candidate;
        $suffix = 1;

        while (static::query()->where('username', $username)->exists()) {
            $username = $candidate.'_'.$suffix;
            $suffix++;
        }

        return $username;
    }
}
