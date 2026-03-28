<?php

use App\Models\User;
use App\Support\AccessControl;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('permission_role')) {
            Schema::create('permission_role', function (Blueprint $table) {
                $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
                $table->foreignId('role_id')->constrained()->cascadeOnDelete();
                $table->timestamps();

                $table->primary(['permission_id', 'role_id']);
            });
        }

        if (! Schema::hasTable('role_user')) {
            Schema::create('role_user', function (Blueprint $table) {
                $table->foreignId('role_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->timestamps();

                $table->primary(['role_id', 'user_id']);
            });
        }

        if (! Schema::hasTable('permission_user')) {
            Schema::create('permission_user', function (Blueprint $table) {
                $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->timestamps();

                $table->primary(['permission_id', 'user_id']);
            });
        }

        $now = now();

        foreach (AccessControl::permissions() as $slug => $name) {
            DB::table('permissions')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'description' => $name,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $permissionIds = DB::table('permissions')->pluck('id', 'slug');

        foreach (AccessControl::roles() as $slug => $role) {
            DB::table('roles')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name' => $role['name'],
                    'description' => $role['name'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $roleIds = DB::table('roles')->pluck('id', 'slug');

        foreach (AccessControl::roles() as $slug => $role) {
            foreach ($role['permissions'] as $permissionSlug) {
                DB::table('permission_role')->updateOrInsert(
                    [
                        'permission_id' => $permissionIds[$permissionSlug],
                        'role_id' => $roleIds[$slug],
                    ],
                    [
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }

        $superAdminRoleId = $roleIds['super_admin'] ?? null;

        if ($superAdminRoleId) {
            User::query()
                ->where(function ($query) {
                    $query->where('is_admin', true)
                        ->orWhere('role', 'admin');
                })
                ->get()
                ->each(function (User $user) use ($superAdminRoleId, $now) {
                    DB::table('role_user')->updateOrInsert(
                        [
                            'role_id' => $superAdminRoleId,
                            'user_id' => $user->id,
                        ],
                        [
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]
                    );
                });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
