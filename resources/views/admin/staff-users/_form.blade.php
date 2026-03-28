<form method="POST" action="{{ $formAction }}">
  @csrf
  @if($formMethod !== 'POST')
    @method($formMethod)
  @endif

  <div class="ad-card">
    <div class="ad-card-head">
      <h3>{{ $staffUser->exists ? 'Edit Staff User' : 'Create Staff User' }}</h3>
    </div>
    <div class="ad-card-body">
      @if($staffUser->exists)
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:18px;">
          <span class="ad-badge {{ $staffUser->isActive() ? 'ad-badge-active' : 'ad-badge-cancelled' }}">
            {{ $staffUser->isActive() ? 'Active Account' : 'Inactive Account' }}
          </span>
          @if($staffUser->hasRole('super_admin'))
            <span class="ad-badge ad-badge-primary">Super Admin Protected</span>
          @endif
          @if($staffUser->last_login_at)
            <span class="ad-badge ad-badge-pending">Last login {{ $staffUser->last_login_at->diffForHumans() }}</span>
          @endif
        </div>
      @endif

      <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;">
        <div class="ad-form-group">
          <label class="ad-label" for="name">Full Name</label>
          <input id="name" type="text" name="name" class="ad-input" value="{{ old('name', $staffUser->name) }}" required>
        </div>

        <div class="ad-form-group">
          <label class="ad-label" for="email">Email Address</label>
          <input id="email" type="email" name="email" class="ad-input" value="{{ old('email', $staffUser->email) }}" required>
        </div>

        <div class="ad-form-group">
          <label class="ad-label" for="username">Username</label>
          <input id="username" type="text" name="username" class="ad-input" value="{{ old('username', $staffUser->username) }}" placeholder="Optional">
        </div>

        <div class="ad-form-group">
          <label class="ad-label" for="password">Password</label>
          <input id="password" type="password" name="password" class="ad-input" {{ $staffUser->exists ? '' : 'required' }}>
          @if($staffUser->exists)
            <p class="ad-input-hint">Leave blank to keep the current password.</p>
          @endif
        </div>
      </div>

      <div class="ad-form-group">
        <label class="ad-label" for="role_slug">Office Role</label>
        <select id="role_slug" name="role_slug" class="ad-select" required>
          <option value="">Select role</option>
          @foreach($roles as $role)
            <option value="{{ $role->slug }}" {{ $selectedRole === $role->slug ? 'selected' : '' }}>{{ $role->name }}</option>
          @endforeach
        </select>
        <p class="ad-input-hint">Roles provide the default module access for a staff member.</p>
      </div>

      <div class="ad-form-group">
        <label class="ad-label">Additional Module Access</label>
        <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;">
          @foreach($permissions as $permission)
            <label style="display:flex;gap:10px;align-items:flex-start;padding:12px 14px;border:1px solid var(--ad-border);border-radius:12px;background:#fff;">
              <input
                type="checkbox"
                name="permissions[]"
                value="{{ $permission->slug }}"
                {{ in_array($permission->slug, $selectedPermissions, true) ? 'checked' : '' }}
                style="margin-top:3px"
              >
              <span>
                <strong style="display:block;color:var(--ad-text);font-size:0.85rem;">{{ $permission->name }}</strong>
                <span style="color:var(--ad-muted);font-size:0.75rem;">{{ $permission->slug }}</span>
              </span>
            </label>
          @endforeach
        </div>
        <p class="ad-input-hint">Use additional access only when someone needs one or two modules outside their normal office role.</p>
      </div>
    </div>
  </div>

  <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:18px;">
      <a href="{{ route('admin.staff-users.index') }}" class="btn-ad btn-ad-outline">Cancel</a>
      <button type="submit" class="btn-ad btn-ad-primary">
        <i class="fas fa-user-shield"></i> {{ $staffUser->exists ? 'Update Staff User' : 'Create Staff User' }}
      </button>
  </div>
</form>

@if($staffUser->exists)
  <div class="ad-card" style="margin-top:18px;">
    <div class="ad-card-head">
      <h3>Security Actions</h3>
    </div>
    <div class="ad-card-body">
      <div style="display:flex;gap:12px;flex-wrap:wrap;">
        <form method="POST" action="{{ route('admin.staff-users.send-password-reset', $staffUser) }}">
          @csrf
          <button type="submit" class="btn-ad btn-ad-outline">
            <i class="fas fa-key"></i> Send Password Reset Link
          </button>
        </form>

        @if($staffUser->hasRole('super_admin'))
          <span class="ad-input-hint" style="margin:0;display:flex;align-items:center;">Super admin accounts stay active and must be managed directly by the owner.</span>
        @elseif($staffUser->isActive())
          <form method="POST" action="{{ route('admin.staff-users.deactivate', $staffUser) }}">
            @csrf
            <button type="submit" class="btn-ad btn-ad-danger">
              <i class="fas fa-user-slash"></i> Deactivate Account
            </button>
          </form>
        @else
          <form method="POST" action="{{ route('admin.staff-users.activate', $staffUser) }}">
            @csrf
            <button type="submit" class="btn-ad btn-ad-primary">
              <i class="fas fa-user-check"></i> Reactivate Account
            </button>
          </form>
        @endif
      </div>
    </div>
  </div>

  <div class="ad-card" style="margin-top:18px;">
    <div class="ad-card-head">
      <h3>Audit Log</h3>
    </div>
    <div class="ad-table-wrap">
      <table class="ad-table">
        <thead>
          <tr>
            <th>Action</th>
            <th>By</th>
            <th>When</th>
          </tr>
        </thead>
        <tbody>
          @forelse($auditLogs as $log)
            <tr>
              <td>
                <div style="font-weight:600;">{{ $log->description }}</div>
                <div style="font-size:0.75rem;color:var(--ad-muted);">{{ $log->action }}</div>
              </td>
              <td>{{ $log->actor?->name ?? 'System' }}</td>
              <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="ad-table-empty">No audit history for this staff user yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endif
