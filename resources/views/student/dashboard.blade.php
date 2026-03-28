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
                <span class="sp-chip"><i class="fas fa-circle-play"></i> {{ $stats['recordings'] }} recent recording{{ $stats['recordings'] === 1 ? '' : 's' }}</span>
            </div>
            @if($stats['balance'] > 0)
                <div style="margin-top:18px;display:flex;gap:10px;flex-wrap:wrap;">
                    <a href="{{ route('student.payments') }}" class="btn-ad btn-ad-light">
                        <i class="fas fa-credit-card"></i> Make Payment
                    </a>
                    <a href="{{ route('user.chat.index', ['category' => 'general', 'subject' => 'General student support', 'message' => 'Hello, I need help with my student portal or academy support request.']) }}" class="btn-ad btn-ad-outline" style="background:rgba(255,255,255,0.12);border-color:rgba(255,255,255,0.22);color:#fff;">
                        <i class="fas fa-comments"></i> Get Support
                    </a>
                </div>
            @else
                <div style="margin-top:18px;">
                    <a href="{{ route('user.chat.index', ['category' => 'general', 'subject' => 'General student support', 'message' => 'Hello, I need help with my student portal or academy support request.']) }}" class="btn-ad btn-ad-outline" style="background:rgba(255,255,255,0.12);border-color:rgba(255,255,255,0.22);color:#fff;">
                        <i class="fas fa-comments"></i> Get Support
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

<div class="ad-card sp-section-gap">
    <div class="ad-card-head">
        <h3>Lecture Recordings</h3>
        <a href="{{ route('student.recordings') }}" class="btn-ad btn-ad-outline btn-ad-sm">
            <i class="fas fa-circle-play"></i> View All
        </a>
    </div>
    <div class="ad-card-body">
        @if($lectureRecordings->isEmpty())
            <div class="sp-empty">No lecture recordings have been added for your active course yet.</div>
        @else
            <div class="sp-recording-grid">
                @foreach($lectureRecordings as $recording)
                    <a href="{{ $recording->google_drive_url }}" target="_blank" rel="noopener noreferrer" class="sp-recording-card">
                        <span class="sp-recording-date">{{ $recording->class_date->format('M d, Y') }}</span>
                        <div class="sp-recording-icon">
                            <i class="fas fa-circle-play"></i>
                        </div>
                        <div class="sp-recording-course">{{ $recording->course?->title ?? 'Course recording' }}</div>
                        <h4>{{ $recording->title }}</h4>
                        <p>{{ $recording->topic ?: 'Open this lecture recording in Google Drive.' }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .sp-recording-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
        gap:16px;
    }
    .sp-recording-card{
        position:relative;
        display:block;
        padding:18px;
        border:1px solid rgba(195, 33, 48, 0.12);
        border-radius:18px;
        background:#fff;
        text-decoration:none;
        color:inherit;
        transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        min-height:180px;
        overflow:hidden;
    }
    .sp-recording-card:hover{
        transform:translateY(-4px);
        border-color:rgba(195, 33, 48, 0.28);
        box-shadow:0 18px 34px rgba(20, 20, 43, 0.08);
    }
    .sp-recording-icon{
        width:42px;
        height:42px;
        border-radius:14px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:rgba(195, 33, 48, 0.08);
        color:#c32130;
        margin-bottom:16px;
    }
    .sp-recording-course{
        font-size:.75rem;
        font-weight:600;
        letter-spacing:.04em;
        text-transform:uppercase;
        color:#a2353f;
        margin-bottom:10px;
    }
    .sp-recording-card h4{
        margin:0 0 8px;
        font-size:1rem;
        color:#14142b;
    }
    .sp-recording-card p{
        margin:0;
        color:#6b7280;
        font-size:.9rem;
        line-height:1.55;
    }
    .sp-recording-date{
        position:absolute;
        top:14px;
        right:14px;
        padding:6px 10px;
        border-radius:999px;
        background:#14142b;
        color:#fff;
        font-size:.72rem;
        font-weight:600;
        opacity:0;
        transform:translateY(-6px);
        transition:opacity .18s ease, transform .18s ease;
    }
    .sp-recording-card:hover .sp-recording-date{
        opacity:1;
        transform:translateY(0);
    }
</style>
@endpush

@endsection
