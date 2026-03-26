@extends('layouts.student')

@section('title', 'Student Dashboard')
@section('page_title', 'Student Dashboard')
@section('page_subtitle', 'A clean overview of your study progress, finance status, and next schedule item.')

@section('content')
<div class="sp-hero">
    <div class="ad-card sp-hero-card">
        <div class="ad-card-body">
            <h2>Welcome back, {{ explode(' ', $student->full_name)[0] ?? $student->full_name }}.</h2>
            <p>{{ $student->student_number ? 'Your student number is '.$student->student_number.'. ' : '' }}Use this portal for the essentials: your account details, payment status, and your upcoming classes.</p>
            <div class="sp-hero-meta">
                <span class="sp-chip"><i class="fas fa-id-badge"></i> {{ $student->student_number ?? 'Student number pending' }}</span>
                <span class="sp-chip"><i class="fas fa-book-open"></i> {{ $stats['active_courses'] }} active course{{ $stats['active_courses'] === 1 ? '' : 's' }}</span>
                <span class="sp-chip"><i class="fas fa-calendar-days"></i> {{ $events->count() }} upcoming item{{ $events->count() === 1 ? '' : 's' }}</span>
            </div>
            @if($stats['balance'] > 0)
                <div style="margin-top:18px;">
                    <a href="{{ route('student.payments') }}" class="btn-ad btn-ad-light">
                        <i class="fas fa-credit-card"></i> Make Payment
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="ad-card sp-quick-card">
        <div class="ad-card-body">
            <div class="sp-quick-label">Payment Overview</div>
            <div class="sp-quick-list">
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Total Paid</div>
                        <strong>UGX {{ number_format($stats['paid_total'], 0) }}</strong>
                    </div>
                    <i class="fas fa-credit-card sp-muted"></i>
                </div>
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Outstanding Balance</div>
                        <strong>UGX {{ number_format($stats['balance'], 0) }}</strong>
                    </div>
                    <i class="fas fa-wallet sp-muted"></i>
                </div>
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Payment Action</div>
                        <strong>{{ $stats['balance'] > 0 ? 'Ready to pay' : 'No balance due' }}</strong>
                    </div>
                    <i class="fas fa-arrow-up-right-from-square sp-muted"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sp-grid sp-grid-2 sp-section-gap">
    <div class="ad-card">
        <div class="ad-card-head">
            <h3>Account Snapshot</h3>
            <a href="{{ route('student.profile') }}" class="btn-ad btn-ad-outline btn-ad-sm">
                <i class="fas fa-id-card"></i> View Profile
            </a>
        </div>
        <div class="ad-card-body">
        <div class="sp-list">
            <div class="sp-list-item"><span class="sp-muted">Student Number</span><strong>{{ $student->student_number ?? 'Pending assignment' }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Full Name</span><strong>{{ $student->full_name }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Email</span><strong>{{ $student->email ?? auth()->user()->email }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Phone</span><strong>{{ $student->phone ?? 'Not provided' }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Current Focus</span><strong>{{ $student->course_interest ?? 'Not assigned yet' }}</strong></div>
        </div>
        </div>
    </div>

    <div class="ad-card">
        <div class="ad-card-head">
            <h3>Upcoming Schedule</h3>
            <a href="{{ route('student.calendar') }}" class="btn-ad btn-ad-outline btn-ad-sm">
                <i class="fas fa-calendar-days"></i> View Full Calendar
            </a>
        </div>
        <div class="ad-card-body">
        @if($events->isEmpty())
            <div class="sp-empty">No upcoming timetable entries yet.</div>
        @else
            <div class="sp-list">
                @foreach($events->take(3) as $event)
                    <div class="sp-list-item">
                        <div>
                            <strong>{{ $event->title }}</strong>
                            <div class="sp-muted">{{ $event->course?->title ?? 'General schedule' }}</div>
                            <div class="sp-muted">{{ $event->description ?: 'Scheduled class session' }}</div>
                        </div>
                        <div class="sp-muted">{{ $event->starts_at->format('M d, Y') }}</div>
                    </div>
                @endforeach
            </div>
        @endif
        </div>
    </div>
</div>

@endsection
