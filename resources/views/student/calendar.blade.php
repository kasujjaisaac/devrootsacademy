@extends('layouts.student')

@section('title', 'Student Timetable')
@section('page_title', 'Calendar & Timetable')
@section('page_subtitle', 'Track your published class schedule and other academic dates.')

@section('content')
<div class="sp-card">
    <h3>Upcoming Schedule</h3>
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
@endsection
