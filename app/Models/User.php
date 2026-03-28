<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
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
        'is_active',
        'role',
        'last_login_at',
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
            'is_active'         => 'boolean',
            'last_login_at'     => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true
            || $this->role === 'admin'
            || $this->hasPermission(\App\Support\AccessControl::ACCESS_ADMIN_PANEL);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'target_user_id');
    }

    public function permissionSlugs(): Collection
    {
        if (! Schema::hasTable('roles') || ! Schema::hasTable('permissions')) {
            return collect();
        }

        $this->loadMissing('roles.permissions', 'permissions');

        $rolePermissions = $this->roles
            ->flatMap(fn (Role $role) => $role->permissions->pluck('slug'));

        $directPermissions = $this->permissions->pluck('slug');

        return $rolePermissions
            ->merge($directPermissions)
            ->unique()
            ->values();
    }

    public function hasRole(string $slug): bool
    {
        if (! Schema::hasTable('roles')) {
            return $this->role === $slug;
        }

        $this->loadMissing('roles');

        return $this->roles->contains(fn (Role $role) => $role->slug === $slug);
    }

    public function hasPermission(string $slug): bool
    {
        if ($this->is_admin === true || $this->role === 'admin') {
            return true;
        }

        if (! Schema::hasTable('roles') || ! Schema::hasTable('permissions')) {
            return false;
        }

        return $this->permissionSlugs()->contains($slug);
    }

    public function isActive(): bool
    {
        if (! Schema::hasColumn('users', 'is_active')) {
            return true;
        }

        return $this->is_active !== false;
    }

    public function primaryRoleName(): string
    {
        if (! Schema::hasTable('roles')) {
            return ucfirst(str_replace('_', ' ', $this->role ?? 'admin'));
        }

        $this->loadMissing('roles');

        return $this->roles->first()->name
            ?? ucfirst(str_replace('_', ' ', $this->role ?? 'admin'));
    }

    public function unreadAdminNotificationsCount(): int
    {
        if (! Schema::hasTable('notifications')) {
            return 0;
        }

        return $this->unreadNotifications()->count();
    }

    public function recentAdminNotifications(int $limit = 5): DatabaseNotificationCollection
    {
        if (! Schema::hasTable('notifications')) {
            return new DatabaseNotificationCollection();
        }

        return $this->notifications()->latest()->limit($limit)->get();
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
