@extends('layouts.student')

@section('title', 'Student Dashboard')
@section('page_title', 'Student Dashboard')
@section('page_subtitle', 'Your profile, payments, and course timetable at a glance.')

@section('content')
<div class="sp-hero">
    <div class="ad-card sp-hero-card">
        <div class="ad-card-body">
            <h2>Welcome back, {{ explode(' ', $student->full_name)[0] ?? $student->full_name }}.</h2>
            <p>{{ $student->student_number ? 'Your student number is '.$student->student_number.'. ' : '' }}Use the portal to track your course activity, payments, and upcoming timetable sessions in one place.</p>
            <div class="sp-hero-meta">
                <span class="sp-chip"><i class="fas fa-id-badge"></i> {{ $student->student_number ?? 'Student number pending' }}</span>
                <span class="sp-chip"><i class="fas fa-book-open"></i> {{ $stats['enrollments'] }} enrollments</span>
                <span class="sp-chip"><i class="fas fa-calendar-days"></i> {{ $events->count() }} upcoming schedule items</span>
            </div>
        </div>
    </div>

    <div class="ad-card sp-quick-card">
        <div class="ad-card-body">
            <div class="sp-quick-label">Quick Summary</div>
            <div class="sp-quick-list">
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Portal Email</div>
                        <strong>{{ $student->email ?? auth()->user()->email }}</strong>
                    </div>
                    <i class="fas fa-envelope sp-muted"></i>
                </div>
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Course Focus</div>
                        <strong>{{ $student->course_interest ?? 'Not assigned yet' }}</strong>
                    </div>
                    <i class="fas fa-graduation-cap sp-muted"></i>
                </div>
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Outstanding Balance</div>
                        <strong>UGX {{ number_format($stats['balance'], 0) }}</strong>
                    </div>
                    <i class="fas fa-wallet sp-muted"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ad-stats-row">
    <div class="ad-stat-card blue">
        <div>
            <div class="ad-stat-num">{{ $stats['active_courses'] }}</div>
            <div class="ad-stat-lbl">Active Courses</div>
            <div class="sp-stat-note">{{ $stats['enrollments'] }} total enrollments</div>
        </div>
        <div class="ad-stat-icon"><i class="fas fa-book-open"></i></div>
    </div>
    <div class="ad-stat-card green">
        <div>
            <div class="ad-stat-num">UGX {{ number_format($stats['paid_total'], 0) }}</div>
            <div class="ad-stat-lbl">Total Paid</div>
            <div class="sp-stat-note">Recorded payments to date</div>
        </div>
        <div class="ad-stat-icon"><i class="fas fa-credit-card"></i></div>
    </div>
    <div class="ad-stat-card orange">
        <div>
            <div class="ad-stat-num">UGX {{ number_format($stats['balance'], 0) }}</div>
            <div class="ad-stat-lbl">Outstanding Balance</div>
            <div class="sp-stat-note">Finance snapshot</div>
        </div>
        <div class="ad-stat-icon"><i class="fas fa-wallet"></i></div>
    </div>
    <div class="ad-stat-card purple">
        <div>
            <div class="ad-stat-num">{{ $stats['completed_courses'] }}</div>
            <div class="ad-stat-lbl">Completed Courses</div>
            <div class="sp-stat-note">Progress tracked</div>
        </div>
        <div class="ad-stat-icon"><i class="fas fa-award"></i></div>
    </div>
</div>

<div class="sp-grid sp-grid-2 sp-section-gap">
    <div class="ad-card">
        <div class="ad-card-head">
            <h3>Profile Snapshot</h3>
        </div>
        <div class="ad-card-body">
        <div class="sp-list">
            <div class="sp-list-item"><span class="sp-muted">Student Number</span><strong>{{ $student->student_number ?? 'Pending assignment' }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Full Name</span><strong>{{ $student->full_name }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Email</span><strong>{{ $student->email ?? auth()->user()->email }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Phone</span><strong>{{ $student->phone ?? 'Not provided' }}</strong></div>
        </div>
        </div>
    </div>

    <div class="ad-card">
        <div class="ad-card-head">
            <h3>Timetable Snapshot</h3>
            <a href="{{ route('student.calendar') }}" class="btn-ad btn-ad-outline btn-ad-sm">
                <i class="fas fa-calendar-days"></i> View Full Calendar
            </a>
        </div>
        <div class="ad-card-body">
        @if($events->isEmpty())
            <div class="sp-empty">No upcoming timetable entries yet.</div>
        @else
            <div class="sp-list">
                @foreach($events->take(4) as $event)
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

<div class="sp-grid sp-grid-2 sp-section-gap">
    <div class="ad-card">
        <div class="ad-card-head">
            <h3>Recent Payments</h3>
            <a href="{{ route('student.payments') }}" class="btn-ad btn-ad-outline btn-ad-sm">
                <i class="fas fa-credit-card"></i> Payment History
            </a>
        </div>
        <div class="ad-card-body">
        @if($payments->isEmpty())
            <div class="sp-empty">No payment records available.</div>
        @else
            <table class="sp-table">
                <thead>
                    <tr><th>Course</th><th>Amount</th><th>Date</th></tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->course?->title ?? '—' }}</td>
                            <td>UGX {{ number_format($payment->amount, 0) }}</td>
                            <td>{{ $payment->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        </div>
    </div>

    <div class="ad-card">
        <div class="ad-card-head">
            <h3>Enrolled Courses</h3>
        </div>
        <div class="ad-card-body">
        @if($student->enrollments->isEmpty())
            <div class="sp-empty">No enrollments found yet.</div>
        @else
            <div class="sp-list">
                @foreach($student->enrollments->take(5) as $enrollment)
                    <div class="sp-list-item">
                        <div>
                            <strong>{{ $enrollment->course?->title ?? 'Untitled course' }}</strong>
                            <div class="sp-muted">{{ $enrollment->course?->category ?? 'Course category unavailable' }}</div>
                        </div>
                        <span class="ad-badge {{ ($enrollment->status ?? 'pending') === 'active' ? 'ad-badge-active' : (($enrollment->status ?? 'pending') === 'completed' ? 'ad-badge-finished' : 'ad-badge-pending') }}">
                            {{ ucfirst($enrollment->status ?? 'pending') }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
        </div>
    </div>
</div>
@endsection
