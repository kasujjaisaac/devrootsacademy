@extends('layouts.admin')
@section('title', $student->full_name ?? 'Student Profile')

@section('content')

{{-- ── Page Header ── --}}
<div class="ad-page-hd">
  <div class="ad-page-hd-left">
    <h1>Student Profile</h1>
    <nav class="ad-breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fas fa-chevron-right"></i>
      <a href="{{ route('admin.students.index') }}">Students</a>
      <i class="fas fa-chevron-right"></i>
      <span>{{ $student->full_name ?? 'View' }}</span>
    </nav>
  </div>
  <div style="display:flex;gap:8px;flex-wrap:wrap;">
    <a href="{{ route('admin.students.index') }}" class="btn-ad btn-ad-outline">
      <i class="fas fa-arrow-left"></i> Back
    </a>
  </div>
</div>

{{-- ── Alerts ── --}}
@if(session('success'))
<div class="ad-alert ad-alert-success">
  <i class="fas fa-circle-check"></i> {{ session('success') }}
  <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif

{{-- ── Stats Row ── --}}
<div class="ad-stats-row" style="grid-template-columns:repeat(auto-fit,minmax(160px,1fr));margin-bottom:20px;">

  <div class="ad-stat-card blue">
    <div class="ad-stat-icon"><i class="fas fa-layer-group"></i></div>
    <div>
      <div class="ad-stat-num">{{ $stats['total_enrollments'] }}</div>
      <div class="ad-stat-lbl">Total Enrollments</div>
    </div>
  </div>

  <div class="ad-stat-card green">
    <div class="ad-stat-icon"><i class="fas fa-book-open"></i></div>
    <div>
      <div class="ad-stat-num">{{ $stats['active_courses'] }}</div>
      <div class="ad-stat-lbl">Active Courses</div>
    </div>
  </div>

  <div class="ad-stat-card purple">
    <div class="ad-stat-icon"><i class="fas fa-graduation-cap"></i></div>
    <div>
      <div class="ad-stat-num">{{ $stats['completed_courses'] }}</div>
      <div class="ad-stat-lbl">Completed</div>
    </div>
  </div>

  <div class="ad-stat-card orange">
    <div class="ad-stat-icon"><i class="fas fa-credit-card"></i></div>
    <div>
      <div class="ad-stat-num">{{ $stats['total_payments'] }}</div>
      <div class="ad-stat-lbl">Payments</div>
    </div>
  </div>

  <div class="ad-stat-card red">
    <div class="ad-stat-icon"><i class="fas fa-coins"></i></div>
    <div>
      <div class="ad-stat-num" style="font-size:1.1rem;">{{ number_format($stats['total_paid'], 0) }}</div>
      <div class="ad-stat-lbl">UGX Paid</div>
    </div>
  </div>

</div>

{{-- ── Two-column layout ── --}}
<div style="display:grid;grid-template-columns:340px 1fr;gap:20px;align-items:start;">

  {{-- ── LEFT: Profile card + Status ── --}}
  <div style="display:flex;flex-direction:column;gap:16px;">

    {{-- Profile Card --}}
    <div class="ad-card">
      <div style="padding:28px 24px;text-align:center;border-bottom:1px solid var(--ad-border);">
        <div style="width:80px;height:80px;border-radius:50%;background:var(--ad-primary);
                    color:#fff;font-size:1.75rem;font-weight:700;
                    display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
          {{ strtoupper(substr($student->full_name ?? 'S', 0, 2)) }}
        </div>
        <div style="font-size:1rem;font-weight:600;color:var(--ad-text);">
          {{ $student->full_name ?? '—' }}
        </div>
        @if($student->student_number)
        <div style="font-size:0.78rem;color:var(--ad-primary);margin-top:4px;font-weight:600;">
          {{ $student->student_number }}
        </div>
        @endif
        @if($student->username)
        <div style="font-size:0.8rem;color:var(--ad-muted);margin-top:2px;">@{{ $student->username }}</div>
        @endif
        <div style="margin-top:10px;">
          @php
            $s = $student->status ?? 'pending';
            $badgeMap = [
              'active'   => 'ad-badge-active',
              'finished' => 'ad-badge-finished',
              'pending'  => 'ad-badge-pending',
              'inactive' => 'ad-badge-rejected',
            ];
          @endphp
          <span class="ad-badge {{ $badgeMap[$s] ?? 'ad-badge-pending' }}">
            {{ ucfirst($s) }}
          </span>
        </div>
      </div>

      {{-- Contact info --}}
      <div style="padding:16px 20px;display:flex;flex-direction:column;gap:12px;">

        @if($student->email)
        <div style="display:flex;align-items:center;gap:10px;font-size:0.8125rem;">
          <i class="fas fa-envelope" style="width:16px;color:var(--ad-muted);flex-shrink:0;"></i>
          <a href="mailto:{{ $student->email }}" style="color:var(--ad-primary);word-break:break-all;">
            {{ $student->email }}
          </a>
        </div>
        @endif

        @if($student->phone)
        <div style="display:flex;align-items:center;gap:10px;font-size:0.8125rem;">
          <i class="fas fa-phone" style="width:16px;color:var(--ad-muted);flex-shrink:0;"></i>
          <span>{{ $student->phone }}</span>
        </div>
        @endif

        <div style="display:flex;align-items:center;gap:10px;font-size:0.8125rem;">
          <i class="fas fa-id-badge" style="width:16px;color:var(--ad-muted);flex-shrink:0;"></i>
          <span>{{ $student->student_number ?? 'Pending assignment' }}</span>
        </div>

        @if($student->location)
        <div style="display:flex;align-items:center;gap:10px;font-size:0.8125rem;">
          <i class="fas fa-location-dot" style="width:16px;color:var(--ad-muted);flex-shrink:0;"></i>
          <span>{{ $student->location }}</span>
        </div>
        @endif

        @if($student->dob)
        <div style="display:flex;align-items:center;gap:10px;font-size:0.8125rem;">
          <i class="fas fa-cake-candles" style="width:16px;color:var(--ad-muted);flex-shrink:0;"></i>
          <span>{{ $student->dob->format('M d, Y') }}</span>
        </div>
        @endif

        <div style="display:flex;align-items:center;gap:10px;font-size:0.8125rem;">
          <i class="fas fa-calendar" style="width:16px;color:var(--ad-muted);flex-shrink:0;"></i>
          <span>Applied {{ $student->created_at->format('M d, Y') }}</span>
        </div>

      </div>
    </div>

    {{-- Application Details Card --}}
    @if($student->course_interest || $student->goals)
    <div class="ad-card">
      <div style="padding:14px 20px;border-bottom:1px solid var(--ad-border);font-weight:600;font-size:0.875rem;">
        Application Details
      </div>
      <div style="padding:16px 20px;display:flex;flex-direction:column;gap:14px;">

        @if($student->course_interest)
        <div>
          <div style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--ad-muted);margin-bottom:4px;">
            Course Interest
          </div>
          <div style="font-size:0.8125rem;">{{ $student->course_interest }}</div>
        </div>
        @endif

        @if($student->goals)
        <div>
          <div style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--ad-muted);margin-bottom:4px;">
            Goals
          </div>
          <div style="font-size:0.8125rem;line-height:1.6;color:var(--ad-text);">{{ $student->goals }}</div>
        </div>
        @endif

        <div>
          <div style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--ad-muted);margin-bottom:4px;">
            Agreed to Terms
          </div>
          <div style="font-size:0.8125rem;">
            @if($student->agreed_terms)
              <span style="color:#16a34a;"><i class="fas fa-circle-check"></i> Yes</span>
            @else
              <span style="color:#dc2626;"><i class="fas fa-circle-xmark"></i> No</span>
            @endif
          </div>
        </div>

      </div>
    </div>
    @endif

    {{-- Status Summary Card --}}
    <div class="ad-card">
      <div style="padding:14px 20px;border-bottom:1px solid var(--ad-border);font-weight:600;font-size:0.875rem;">
        Status Summary
      </div>
      <div style="padding:16px 20px;">
        <form method="POST" action="{{ route('admin.students.update', $student) }}">
          @csrf @method('PUT')
          <div class="ad-form-group">
            <label class="ad-label">Status</label>
            <select name="status" class="ad-input">
              <option value="active"   {{ $student->status === 'active'   ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ $student->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
              <option value="finished" {{ $student->status === 'finished' ? 'selected' : '' }}>Finished</option>
            </select>
          </div>
          <p class="ad-input-hint" style="margin-bottom:12px;">Course progression is controlled from enrollments. This field is only the learner profile summary.</p>
          <button type="submit" class="btn-ad btn-ad-primary" style="width:100%;">
            <i class="fas fa-floppy-disk"></i> Save Status
          </button>
        </form>
      </div>
    </div>

  </div>

  {{-- ── RIGHT: Enrollments + Payments ── --}}
  <div style="display:flex;flex-direction:column;gap:20px;">

    {{-- Enrollments Table --}}
    <div class="ad-card">
      <div style="padding:14px 20px;border-bottom:1px solid var(--ad-border);display:flex;align-items:center;justify-content:space-between;">
        <span style="font-weight:600;font-size:0.875rem;">
          <i class="fas fa-layer-group" style="color:var(--ad-primary);margin-right:6px;"></i>
          Enrollments
        </span>
        <span style="font-size:0.75rem;color:var(--ad-muted);">{{ $student->enrollments->count() }} record(s)</span>
      </div>
      <div class="ad-table-wrap">
        <table class="ad-table">
          <thead>
            <tr>
              <th class="cell-sm">#</th>
              <th>Course</th>
              <th>Category</th>
              <th>Status</th>
              <th>Enrolled On</th>
              <th class="cell-action">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($student->enrollments as $i => $enrollment)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td style="font-weight:500;">{{ $enrollment->course->title ?? '—' }}</td>
              <td style="color:var(--ad-muted);font-size:0.8rem;">{{ $enrollment->course->category ?? '—' }}</td>
              <td>
                @php $es = $enrollment->status ?? 'pending'; @endphp
                <span class="ad-badge {{ $es === 'active' ? 'ad-badge-active' : ($es === 'completed' ? 'ad-badge-finished' : 'ad-badge-pending') }}">
                  {{ ucfirst($es) }}
                </span>
              </td>
              <td style="white-space:nowrap;font-size:0.8rem;">
                {{ $enrollment->created_at->format('M d, Y') }}
              </td>
              <td>
                <a href="{{ route('admin.enrollments.show', $enrollment) }}" class="btn-ad-icon" title="View">
                  <i class="fas fa-eye"></i>
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="ad-table-empty">
                <i class="fas fa-layer-group"></i> No enrollments yet
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- Payments Table --}}
    <div class="ad-card">
      <div style="padding:14px 20px;border-bottom:1px solid var(--ad-border);display:flex;align-items:center;justify-content:space-between;">
        <span style="font-weight:600;font-size:0.875rem;">
          <i class="fas fa-credit-card" style="color:var(--ad-primary);margin-right:6px;"></i>
          Payment History
        </span>
        <span style="font-size:0.75rem;color:var(--ad-muted);">
          UGX {{ number_format($stats['total_paid'], 0) }} received
        </span>
      </div>
      <div class="ad-table-wrap">
        <table class="ad-table">
          <thead>
            <tr>
              <th class="cell-sm">#</th>
              <th>Course</th>
              <th>Amount (UGX)</th>
              <th>Method</th>
              <th>Reference</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($student->payments->sortByDesc('created_at') as $i => $payment)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td style="font-size:0.8rem;">{{ $payment->course->title ?? '—' }}</td>
              <td style="font-weight:600;">{{ number_format($payment->amount, 0) }}</td>
              <td style="font-size:0.8rem;">{{ $payment->method ?? '—' }}</td>
              <td style="font-size:0.75rem;color:var(--ad-muted);font-family:monospace;">
                {{ $payment->reference ?? '—' }}
              </td>
              <td>
                @php $ps = $payment->status ?? 'pending'; @endphp
                <span class="ad-badge {{ $ps === 'paid' ? 'ad-badge-active' : ($ps === 'failed' ? 'ad-badge-rejected' : 'ad-badge-pending') }}">
                  {{ ucfirst($ps) }}
                </span>
              </td>
              <td style="white-space:nowrap;font-size:0.8rem;">
                {{ $payment->created_at->format('M d, Y') }}
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="ad-table-empty">
                <i class="fas fa-credit-card"></i> No payment records
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

@endsection

@push('styles')
<style>
  @media (max-width: 900px) {
    div[style*="grid-template-columns:340px"] {
      grid-template-columns: 1fr !important;
    }
  }
</style>
@endpush
