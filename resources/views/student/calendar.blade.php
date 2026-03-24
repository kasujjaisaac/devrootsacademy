@extends('layouts.student')

@section('title', 'Student Timetable')
@section('page_title', 'Calendar & Timetable')
@section('page_subtitle', 'Track your published class schedule and other academic dates.')

@section('content')
<div class="sp-hero">
    <div class="ad-card sp-hero-card">
        <div class="ad-card-body">
            <h2>Calendar & Timetable</h2>
            <p>Stay on top of scheduled class sessions, published course activities, and upcoming time-bound academic items.</p>
            <div class="sp-hero-meta">
                <span class="sp-chip"><i class="fas fa-calendar-days"></i> {{ $events->count() }} upcoming items</span>
                <span class="sp-chip"><i class="fas fa-book-open"></i> {{ $student->enrollments->count() }} enrolled courses</span>
            </div>
        </div>
    </div>

    <div class="ad-card sp-quick-card">
        <div class="ad-card-body">
            <div class="sp-quick-label">Schedule Focus</div>
            <div class="sp-quick-list">
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Next Event</div>
                        <strong>{{ $events->first()?->title ?? 'No event scheduled' }}</strong>
                    </div>
                    <i class="fas fa-clock sp-muted"></i>
                </div>
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Next Date</div>
                        <strong>{{ $events->first()?->starts_at?->format('M d, Y g:i A') ?? 'Pending' }}</strong>
                    </div>
                    <i class="fas fa-hourglass-half sp-muted"></i>
                </div>
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Student Number</div>
                        <strong>{{ $student->student_number ?? 'Pending assignment' }}</strong>
                    </div>
                    <i class="fas fa-id-badge sp-muted"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ad-card">
    <div class="ad-card-head">
        <h3>Upcoming Schedule</h3>
    </div>
    <div class="ad-card-body">
        @if($events->isEmpty())
            <div class="sp-empty">No timetable entries have been published for you yet.</div>
        @else
            <div class="sp-list">
                @foreach($events as $event)
                    <div class="sp-list-item">
                        <div>
                            <strong>{{ $event->title }}</strong>
                            <div class="sp-muted">{{ $event->description ?: 'Student schedule item' }}</div>
                            @if($event->course)
                                <div class="sp-muted">Course: {{ $event->course->title }}</div>
                            @endif
                        </div>
                        <div class="sp-muted">
                            {{ $event->starts_at->format('M d, Y g:i A') }}
                            @if($event->ends_at)
                                <div>to {{ $event->ends_at->format('M d, Y g:i A') }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
