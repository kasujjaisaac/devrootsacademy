@extends('layouts.student')

@section('title', 'Student Profile')
@section('page_title', 'Profile')
@section('page_subtitle', 'Your academic and account identity in one place.')

@section('content')
<div class="sp-grid sp-grid-2">
    <div class="sp-card">
        <h3>Student Information</h3>
        <div class="sp-list">
            <div class="sp-list-item"><span class="sp-muted">Full Name</span><strong>{{ $student->full_name }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Username</span><strong>{{ $student->username ?? 'Not set' }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Email</span><strong>{{ $student->email ?? auth()->user()->email }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Phone</span><strong>{{ $student->phone ?? 'Not provided' }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Date of Birth</span><strong>{{ $student->dob?->format('M d, Y') ?? 'Not provided' }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Location</span><strong>{{ $student->location ?? 'Not provided' }}</strong></div>
        </div>
    </div>

    <div class="sp-card">
        <h3>Academic Profile</h3>
        <div class="sp-list">
            <div class="sp-list-item"><span class="sp-muted">Application Status</span><strong>{{ ucfirst($student->status ?? 'active') }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Course Interest</span><strong>{{ $student->course_interest ?? 'Not set' }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Goals</span><strong>{{ $student->goals ?? 'No goals recorded' }}</strong></div>
            <div class="sp-list-item"><span class="sp-muted">Terms Accepted</span><strong>{{ $student->agreed_terms ? 'Yes' : 'No' }}</strong></div>
        </div>
    </div>
</div>
@endsection
