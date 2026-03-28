<?php

namespace App\Support;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

class AuditLogger
{
    public static function log(
        string $action,
        string $description,
        ?User $actor = null,
        ?User $targetUser = null,
        array $metadata = [],
        ?Request $request = null,
    ): void {
        if (! class_exists(AuditLog::class) || ! \Illuminate\Support\Facades\Schema::hasTable('audit_logs')) {
            return;
        }

        AuditLog::create([
            'actor_id' => $actor?->id,
            'target_user_id' => $targetUser?->id,
            'action' => $action,
            'description' => $description,
            'metadata' => $metadata ?: null,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }
}
