@extends('layouts.student')

@section('title', 'Student Dashboard')
@section('page_title', 'Student Dashboard')
@section('page_subtitle', 'Your profile, payments, and course timetable at a glance.')

@section('content')
<div class="sp-grid sp-grid-3">
    <div class="sp-card">
        <div class="sp-muted">Active Courses</div>
        <div class="sp-stat-num">{{ $stats['active_courses'] }}</div>
        <span class="sp-pill"><i class="fas fa-book-open"></i> {{ $stats['enrollments'] }} total enrollments</span>
    </div>
    <div class="sp-card">
        <div class="sp-muted">Total Paid</div>
        <div class="sp-stat-num">UGX {{ number_format($stats['paid_total'], 0) }}</div>
        <span class="sp-pill"><i class="fas fa-wallet"></i> Balance UGX {{ number_format($stats['balance'], 0) }}</span>
    </div>
    <div class="sp-card">
        <div class="sp-muted">Completed Courses</div>
        <div class="sp-stat-num">{{ $stats['completed_courses'] }}</div>
        <span class="sp-pill"><i class="fas fa-graduation-cap"></i> Progress tracked</span>
    </div>
</div>

<div class="sp-grid sp-grid-2" style="margin-top:20px;">
    <div class="sp-card">
        <h3>Profile Snapshot</h3>
        <div class="sp-list">
            <div class="sp-list-item"><span class="sp-muted">Full Name</span><strong>{{ $student->full_name }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Email</span><strong>{{ $student->email ?? auth()->user()->email }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Phone</span><strong>{{ $student->phone ?? 'Not provided' }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Course Interest</span><strong>{{ $student->course_interest ?? 'Not set' }}</strong></div>
        </div>
    </div>

    <div class="sp-card">
        <h3>Timetable Snapshot</h3>
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

<div class="sp-grid sp-grid-2" style="margin-top:20px;">
    <div class="sp-card">
        <h3>Recent Payments</h3>
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

    <div class="sp-card">
        <h3>Enrolled Courses</h3>
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
                        <span class="sp-pill">{{ ucfirst($enrollment->status ?? 'pending') }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
