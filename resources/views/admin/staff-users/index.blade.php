@extends('layouts.admin')
@section('title', 'Staff Access')

@section('content')
<div class="ad-page-hd">
  <div class="ad-page-hd-left">
    <h1>Staff Access</h1>
    <div class="ad-breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fas fa-chevron-right"></i>
      <span>Staff Access</span>
    </div>
  </div>
  <div class="ad-page-hd-right">
    <a href="{{ route('admin.staff-users.create') }}" class="btn-ad btn-ad-primary">
      <i class="fas fa-user-plus"></i> Add Staff User
    </a>
  </div>
</div>

<div class="ad-card">
  <div class="ad-card-head">
    <h3>Office Users</h3>
  </div>
  <div class="ad-table-wrap">
    <table class="ad-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Status</th>
          <th>Extra Access</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($staffUsers as $user)
          <tr>
            <td>
              <div style="font-weight:600;">{{ $user->name }}</div>
              <div style="font-size:0.75rem;color:var(--ad-muted);">{{ $user->username }}</div>
            </td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->roles->first()->name ?? ucfirst(str_replace('_', ' ', $user->role ?? 'staff')) }}</td>
            <td>
              <span class="ad-badge {{ $user->isActive() ? 'ad-badge-active' : 'ad-badge-cancelled' }}">
                {{ $user->isActive() ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td>{{ $user->permissions->count() }}</td>
            <td>
              <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end;">
                <a href="{{ route('admin.staff-users.edit', $user) }}" class="btn-ad btn-ad-outline btn-ad-sm">
                  <i class="fas fa-pen"></i> Edit
                </a>

                @if($user->hasRole('super_admin'))
                  <span class="ad-input-hint" style="margin:0;align-self:center;">Protected</span>
                @elseif($user->isActive())
                  <form method="POST" action="{{ route('admin.staff-users.deactivate', $user) }}">
                    @csrf
                    <button type="submit" class="btn-ad btn-ad-danger btn-ad-sm">
                      <i class="fas fa-user-slash"></i> Deactivate
                    </button>
                  </form>
                @else
                  <form method="POST" action="{{ route('admin.staff-users.activate', $user) }}">
                    @csrf
                    <button type="submit" class="btn-ad btn-ad-primary btn-ad-sm">
                      <i class="fas fa-user-check"></i> Activate
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="ad-table-empty">
              <i class="fas fa-user-shield"></i> No staff users found.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="ad-card" style="margin-top:18px;">
  <div class="ad-card-head">
    <h3>Recent Staff Activity</h3>
  </div>
  <div class="ad-table-wrap">
    <table class="ad-table">
      <thead>
        <tr>
          <th>Action</th>
          <th>Actor</th>
          <th>Target</th>
          <th>When</th>
        </tr>
      </thead>
      <tbody>
        @forelse($recentAuditLogs as $log)
          <tr>
            <td>
              <div style="font-weight:600;">{{ $log->description }}</div>
              <div style="font-size:0.75rem;color:var(--ad-muted);">{{ $log->action }}</div>
            </td>
            <td>{{ $log->actor?->name ?? 'System' }}</td>
            <td>{{ $log->targetUser?->name ?? 'No staff target' }}</td>
            <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="ad-table-empty">No staff activity has been logged yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
