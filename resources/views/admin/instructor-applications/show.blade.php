@extends('layouts.admin')
@section('title', 'Instructor Application Review')

@php
    $statusLabels = [
        'submitted' => 'Submitted',
        'reviewed' => 'Under Review',
        'accepted' => 'Accepted',
        'rejected' => 'Rejected',
        'activated' => 'Activated',
    ];

    $badgeMap = [
        'submitted' => 'ad-badge-pending',
        'reviewed' => 'ad-badge-pending',
        'accepted' => 'ad-badge-active',
        'rejected' => 'ad-badge-rejected',
        'activated' => 'ad-badge-finished',
    ];
@endphp

@section('content')

<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Instructor Application Review</h1>
        <nav class="ad-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('admin.instructor-applications.index') }}">Instructor Applications</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ $application->full_name }}</span>
        </nav>
    </div>
    <a href="{{ route('admin.instructor-applications.index') }}" class="btn-ad btn-ad-outline">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

@if(session('success'))
<div class="ad-alert ad-alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
    <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif
@if(session('error'))
<div class="ad-alert ad-alert-error">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
    <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif
@if($errors->any())
<div class="ad-alert ad-alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <div>
        <strong>Please fix the following errors:</strong>
        <ul class="ad-alert-list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="ad-stats-row" style="grid-template-columns:repeat(auto-fit,minmax(160px,1fr));margin-bottom:20px;">
    <div class="ad-stat-card blue">
        <div>
            <div class="ad-stat-num">{{ $statusLabels[$application->status] ?? ucfirst($application->status) }}</div>
            <div class="ad-stat-lbl">Current Status</div>
        </div>
    </div>
    <div class="ad-stat-card green">
        <div>
            <div class="ad-stat-num">{{ $application->expertise }}</div>
            <div class="ad-stat-lbl">Expertise</div>
        </div>
    </div>
    <div class="ad-stat-card purple">
        <div>
            <div class="ad-stat-num">{{ $application->reviewer?->name ?? '—' }}</div>
            <div class="ad-stat-lbl">Reviewer</div>
        </div>
    </div>
    <div class="ad-stat-card orange">
        <div>
            <div class="ad-stat-num">{{ $application->instructor?->full_name ?? 'Not yet' }}</div>
            <div class="ad-stat-lbl">Instructor Record</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:340px 1fr;gap:20px;align-items:start;">
    <div style="display:flex;flex-direction:column;gap:16px;">
        <div class="ad-card">
            <div style="padding:28px 24px;text-align:center;border-bottom:1px solid var(--ad-border);">
                <div style="width:80px;height:80px;border-radius:50%;background:var(--ad-primary);color:#fff;font-size:1.75rem;font-weight:700;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                    {{ strtoupper(substr($application->full_name, 0, 2)) }}
                </div>
                <div style="font-size:1rem;font-weight:600;color:var(--ad-text);">{{ $application->full_name }}</div>
                <div style="margin-top:10px;">
                    <span class="ad-badge {{ $badgeMap[$application->status] ?? 'ad-badge-pending' }}">
                        {{ $statusLabels[$application->status] ?? ucfirst($application->status) }}
                    </span>
                </div>
            </div>
            <div style="padding:16px 20px;display:flex;flex-direction:column;gap:12px;">
                <div style="display:flex;align-items:center;gap:10px;font-size:0.8125rem;">
                    <i class="fas fa-envelope" style="width:16px;color:var(--ad-muted);"></i>
                    <a href="mailto:{{ $application->email }}" style="color:var(--ad-primary);word-break:break-all;">{{ $application->email }}</a>
                </div>
                <div style="display:flex;align-items:center;gap:10px;font-size:0.8125rem;">
                    <i class="fas fa-phone" style="width:16px;color:var(--ad-muted);"></i>
                    <span>{{ $application->phone }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:10px;font-size:0.8125rem;">
                    <i class="fas fa-calendar" style="width:16px;color:var(--ad-muted);"></i>
                    <span>Applied {{ $application->created_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="ad-card">
            <div style="padding:14px 20px;border-bottom:1px solid var(--ad-border);font-weight:600;font-size:0.875rem;">
                Review Timeline
            </div>
            <div style="padding:16px 20px;display:flex;flex-direction:column;gap:14px;font-size:0.8125rem;">
                <div>
                    <div style="color:var(--ad-muted);margin-bottom:4px;">Reviewed By</div>
                    <div>{{ $application->reviewer?->name ?? 'Not assigned' }}</div>
                </div>
                <div>
                    <div style="color:var(--ad-muted);margin-bottom:4px;">Reviewed At</div>
                    <div>{{ $application->reviewed_at?->format('M d, Y H:i') ?? 'Not yet reviewed' }}</div>
                </div>
                <div>
                    <div style="color:var(--ad-muted);margin-bottom:4px;">Decision At</div>
                    <div>{{ $application->decision_at?->format('M d, Y H:i') ?? 'No decision yet' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:20px;">
        <div class="ad-card">
            <div style="padding:14px 20px;border-bottom:1px solid var(--ad-border);font-weight:600;font-size:0.875rem;">
                Application Details
            </div>
            <div style="padding:16px 20px;display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;">
                <div>
                    <div style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--ad-muted);margin-bottom:4px;">Expertise</div>
                    <div style="font-size:0.875rem;">{{ $application->expertise }}</div>
                </div>
                <div>
                    <div style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--ad-muted);margin-bottom:4px;">Experience</div>
                    <div style="font-size:0.875rem;">{{ $application->experience_years ? $application->experience_years . ' years' : 'Not provided' }}</div>
                </div>
                <div>
                    <div style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--ad-muted);margin-bottom:4px;">Portfolio</div>
                    <div style="font-size:0.875rem;">
                        @if($application->portfolio)
                            <a href="{{ $application->portfolio }}" target="_blank" rel="noopener">{{ $application->portfolio }}</a>
                        @else
                            Not provided
                        @endif
                    </div>
                </div>
                <div>
                    <div style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--ad-muted);margin-bottom:4px;">Terms Accepted</div>
                    <div style="font-size:0.875rem;">{{ $application->agreed_terms ? 'Yes' : 'No' }}</div>
                </div>
                <div style="grid-column:1 / -1;">
                    <div style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--ad-muted);margin-bottom:4px;">Bio</div>
                    <div style="font-size:0.875rem;line-height:1.7;color:var(--ad-text);">{{ $application->bio }}</div>
                </div>
            </div>
        </div>

        <div class="ad-card">
            <div style="padding:14px 20px;border-bottom:1px solid var(--ad-border);font-weight:600;font-size:0.875rem;">
                Review Actions
            </div>
            <div style="padding:16px 20px;">
                <form method="POST">
                    @csrf
                    <div class="ad-form-group">
                        <label class="ad-label" for="review_notes">Internal Notes</label>
                        <textarea id="review_notes" name="review_notes" rows="6" class="ad-input" placeholder="Add review notes, acceptance comments, or rejection reasons...">{{ old('review_notes', $application->review_notes) }}</textarea>
                        <p class="ad-input-hint">These notes support recruitment review and are also used in rejection decisions.</p>
                    </div>
                    <div style="display:flex;gap:10px;flex-wrap:wrap;">
                        @if(in_array($application->status, ['submitted', 'reviewed'], true))
                            <button type="submit" formaction="{{ route('admin.instructor-applications.review', $application) }}" class="btn-ad btn-ad-outline">
                                <i class="fas fa-eye"></i> Mark Under Review
                            </button>
                            <button type="submit" formaction="{{ route('admin.instructor-applications.accept', $application) }}" class="btn-ad btn-ad-primary">
                                <i class="fas fa-circle-check"></i> Accept
                            </button>
                            <button type="submit" formaction="{{ route('admin.instructor-applications.reject', $application) }}" class="btn-ad btn-ad-danger">
                                <i class="fas fa-circle-xmark"></i> Reject
                            </button>
                        @endif

                        @if($application->status === 'accepted')
                            <button type="submit" formaction="{{ route('admin.instructor-applications.activate', $application) }}" class="btn-ad btn-ad-primary">
                                <i class="fas fa-user-plus"></i> Create Instructor Record
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
