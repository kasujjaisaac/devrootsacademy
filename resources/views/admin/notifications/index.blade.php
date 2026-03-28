@extends('layouts.admin')
@section('title', 'Notifications')

@section('content')
<div class="ad-page-hd">
  <div class="ad-page-hd-left">
    <h1>Notifications</h1>
    <div class="ad-breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fas fa-chevron-right"></i>
      <span>Notifications</span>
    </div>
  </div>
  @if($notifications instanceof \Illuminate\Contracts\Pagination\Paginator && $notifications->count())
  <div class="ad-page-hd-right">
    <form method="POST" action="{{ route('admin.notifications.read-all') }}">
      @csrf
      <button type="submit" class="btn-ad btn-ad-outline">
        <i class="fas fa-check-double"></i> Mark All Read
      </button>
    </form>
  </div>
  @endif
</div>

<div class="ad-card">
  <div class="ad-card-head">
    <h3>Recent Alerts</h3>
  </div>
  <div class="ad-table-wrap">
    <table class="ad-table">
      <thead>
        <tr>
          <th>Notification</th>
          <th>When</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($notifications as $notification)
          @php($data = $notification->data)
          <tr>
            <td>
              <div style="font-weight:600;">{{ $data['title'] ?? 'System notification' }}</div>
              <div style="font-size:0.85rem;color:var(--ad-muted);">{{ $data['body'] ?? '' }}</div>
            </td>
            <td>{{ $notification->created_at?->format('M d, Y H:i') }}</td>
            <td>
              <span class="ad-badge {{ $notification->read_at ? 'ad-badge-active' : 'ad-badge-pending' }}">
                {{ $notification->read_at ? 'Read' : 'Unread' }}
              </span>
            </td>
            <td>
              <div style="display:flex;gap:8px;justify-content:flex-end;flex-wrap:wrap;">
                @if(!empty($data['url']))
                  <a href="{{ $data['url'] }}" class="btn-ad btn-ad-outline btn-ad-sm">
                    <i class="fas fa-arrow-up-right-from-square"></i> Open
                  </a>
                @endif
                @if(!$notification->read_at)
                  <form method="POST" action="{{ route('admin.notifications.read', $notification->id) }}">
                    @csrf
                    <button type="submit" class="btn-ad btn-ad-primary btn-ad-sm">
                      <i class="fas fa-check"></i> Mark Read
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="ad-table-empty">
              <i class="fas fa-bell"></i> No notifications yet.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($notifications instanceof \Illuminate\Contracts\Pagination\Paginator && method_exists($notifications, 'links'))
    <div style="padding:18px 22px;">
      {{ $notifications->links() }}
    </div>
  @endif
</div>
@endsection
