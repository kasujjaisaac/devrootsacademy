<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Schema;

class AdminNotifier
{
    public static function sendToPermission(string $permission, Notification $notification): void
    {
        if (! Schema::hasTable('notifications')) {
            return;
        }

        User::query()
            ->where(function ($query) use ($permission) {
                $query->where('is_admin', true)
                    ->orWhere('role', 'admin')
                    ->orWhereHas('roles.permissions', fn ($subQuery) => $subQuery->where('slug', $permission))
                    ->orWhereHas('permissions', fn ($subQuery) => $subQuery->where('slug', $permission));
            })
            ->get()
            ->filter(fn (User $user) => $user->isActive() && $user->hasPermission($permission))
            ->each
            ->notify($notification);
    }
}
