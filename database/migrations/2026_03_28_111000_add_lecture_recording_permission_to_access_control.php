<?php

use App\Support\AccessControl;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('permissions') || ! Schema::hasTable('roles') || ! Schema::hasTable('permission_role')) {
            return;
        }

        $permissionId = DB::table('permissions')->where('slug', AccessControl::MANAGE_LECTURE_RECORDINGS)->value('id');

        if (! $permissionId) {
            $permissionId = DB::table('permissions')->insertGetId([
                'name' => AccessControl::permissions()[AccessControl::MANAGE_LECTURE_RECORDINGS],
                'slug' => AccessControl::MANAGE_LECTURE_RECORDINGS,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach (['super_admin', 'academic_head', 'content_admin'] as $roleSlug) {
            $roleId = DB::table('roles')->where('slug', $roleSlug)->value('id');

            if (! $roleId) {
                continue;
            }

            $exists = DB::table('permission_role')
                ->where('permission_id', $permissionId)
                ->where('role_id', $roleId)
                ->exists();

            if (! $exists) {
                DB::table('permission_role')->insert([
                    'permission_id' => $permissionId,
                    'role_id' => $roleId,
                ]);
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('permissions') || ! Schema::hasTable('permission_role')) {
            return;
        }

        $permissionId = DB::table('permissions')->where('slug', AccessControl::MANAGE_LECTURE_RECORDINGS)->value('id');

        if (! $permissionId) {
            return;
        }

        DB::table('permission_role')->where('permission_id', $permissionId)->delete();
        DB::table('permissions')->where('id', $permissionId)->delete();
    }
};
