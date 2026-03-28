<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Support\AuditLogger;
use App\Support\AccessControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class StaffUserController extends Controller
{
    public function index()
    {
        $staffUsers = User::query()
            ->with(['roles', 'permissions'])
            ->where(function ($query) {
                $query->where('is_admin', true)
                    ->orWhere('role', 'admin')
                    ->orWhereHas('roles.permissions', fn ($subQuery) => $subQuery->where('slug', AccessControl::ACCESS_ADMIN_PANEL))
                    ->orWhereHas('permissions', fn ($subQuery) => $subQuery->where('slug', AccessControl::ACCESS_ADMIN_PANEL));
            })
            ->orderBy('name')
            ->get();

        $recentAuditLogs = AuditLog::query()
            ->with(['actor', 'targetUser'])
            ->latest()
            ->take(25)
            ->get();

        return view('admin.staff-users.index', [
            'staffUsers' => $staffUsers,
            'recentAuditLogs' => $recentAuditLogs,
        ]);
    }

    public function create()
    {
        return view('admin.staff-users.create', $this->formData(new User()));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'] ?: User::generateUsername(null, $validated['email']),
            'email' => $validated['email'],
            'password' => $validated['password'],
            'is_admin' => false,
            'role' => $validated['role_slug'],
        ]);

        $this->syncAccess($user, $validated['role_slug'], $validated['permissions'] ?? []);
        $this->logAction($request, $user, 'staff_user.created', 'Created staff user.');

        return redirect()->route('admin.staff-users.index')->with('success', 'Staff user created successfully.');
    }

    public function edit(User $staffUser)
    {
        $staffUser->load(['roles', 'permissions', 'auditLogs.actor']);

        return view('admin.staff-users.edit', $this->formData($staffUser));
    }

    public function update(Request $request, User $staffUser)
    {
        $validated = $this->validateRequest($request, $staffUser);

        $staffUser->update([
            'name' => $validated['name'],
            'username' => $validated['username'] ?: User::generateUsername(null, $validated['email']),
            'email' => $validated['email'],
            'password' => $validated['password'] ?: $staffUser->password,
            'role' => $validated['role_slug'],
            'is_admin' => $validated['role_slug'] === 'super_admin',
        ]);

        $this->syncAccess($staffUser, $validated['role_slug'], $validated['permissions'] ?? []);
        $this->logAction($request, $staffUser, 'staff_user.updated', 'Updated staff user access.');

        return redirect()->route('admin.staff-users.index')->with('success', 'Staff user updated successfully.');
    }

    public function deactivate(Request $request, User $staffUser)
    {
        if ($staffUser->hasRole('super_admin')) {
            return back()->withErrors(['email' => 'Super admin accounts cannot be deactivated from this panel.']);
        }

        $staffUser->forceFill(['is_active' => false])->save();
        $this->logAction($request, $staffUser, 'staff_user.deactivated', 'Deactivated staff account.');

        return back()->with('success', 'Staff account deactivated successfully.');
    }

    public function activate(Request $request, User $staffUser)
    {
        $staffUser->forceFill(['is_active' => true])->save();
        $this->logAction($request, $staffUser, 'staff_user.activated', 'Reactivated staff account.');

        return back()->with('success', 'Staff account reactivated successfully.');
    }

    public function sendPasswordReset(Request $request, User $staffUser)
    {
        $status = Password::sendResetLink(['email' => $staffUser->email]);

        if ($status !== Password::RESET_LINK_SENT) {
            return back()->withErrors(['email' => __($status)]);
        }

        $this->logAction($request, $staffUser, 'staff_user.password_reset_link_sent', 'Sent password reset link to staff user.');

        return back()->with('success', 'Password reset link sent successfully.');
    }

    protected function validateRequest(Request $request, ?User $user = null): array
    {
        $roleSlugs = Role::query()->pluck('slug')->all();
        $permissionSlugs = Permission::query()->pluck('slug')->all();

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'nullable',
                'string',
                'max:100',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($user?->id),
            ],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8'],
            'role_slug' => ['required', Rule::in($roleSlugs)],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [Rule::in($permissionSlugs)],
        ]);
    }

    protected function syncAccess(User $user, string $roleSlug, array $permissionSlugs): void
    {
        $role = Role::query()->where('slug', $roleSlug)->firstOrFail();
        $permissions = Permission::query()
            ->whereIn('slug', $permissionSlugs)
            ->pluck('id')
            ->all();

        $user->roles()->sync([$role->id]);
        $user->permissions()->sync($permissions);
    }

    protected function formData(User $staffUser): array
    {
        $roles = Role::query()->orderBy('name')->get();
        $permissions = Permission::query()->orderBy('name')->get();
        $selectedRole = old('role_slug', $staffUser->roles->first()->slug ?? ($staffUser->role ?: ''));
        $selectedPermissions = old('permissions', $staffUser->permissions->pluck('slug')->all());
        $auditLogs = $staffUser->exists
            ? AuditLog::query()->with('actor')->where('target_user_id', $staffUser->id)->latest()->take(20)->get()
            : collect();

        return [
            'staffUser' => $staffUser,
            'roles' => $roles,
            'permissions' => $permissions,
            'selectedRole' => $selectedRole,
            'selectedPermissions' => $selectedPermissions,
            'auditLogs' => $auditLogs,
            'roleDefinitions' => AccessControl::roles(),
        ];
    }

    protected function logAction(Request $request, User $targetUser, string $action, string $description): void
    {
        AuditLogger::log(
            $action,
            $description,
            actor: $request->user(),
            targetUser: $targetUser,
            metadata: [
                'role' => $targetUser->primaryRoleName(),
                'active' => $targetUser->isActive(),
            ],
            request: $request,
        );
    }
}
