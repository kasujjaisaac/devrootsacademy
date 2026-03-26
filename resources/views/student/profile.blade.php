@extends('layouts.student')

@section('title', 'Student Profile')
@section('page_title', 'Profile')
@section('page_subtitle', 'Your academic and account identity in one place.')

@section('content')
<div class="sp-hero">
    <div class="ad-card sp-hero-card">
        <div class="ad-card-body">
            <h2>{{ $student->full_name }}</h2>
            <p>Your profile captures your academic identity, contact information, and admissions record for DevRoots Academy.</p>
            <div class="sp-hero-meta">
                <span class="sp-chip"><i class="fas fa-id-badge"></i> {{ $student->student_number ?? 'Student number pending' }}</span>
                <span class="sp-chip"><i class="fas fa-envelope"></i> {{ $student->email ?? auth()->user()->email }}</span>
            </div>
            <div style="margin-top:18px;">
                <a href="{{ route('user.chat.index', ['category' => 'general', 'subject' => 'Profile support request', 'message' => 'Hello, I need help with my student profile or account details.']) }}" class="btn-ad btn-ad-light">
                    <i class="fas fa-comments"></i> Ask for Help
                </a>
            </div>
        </div>
    </div>

    <div class="ad-card sp-quick-card">
        <div class="ad-card-body">
            <div class="sp-quick-label">Academic Snapshot</div>
            <div class="sp-quick-list">
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Status</div>
                        <strong>{{ ucfirst($student->status ?? 'active') }}</strong>
                    </div>
                    <span class="ad-badge ad-badge-active">{{ ucfirst($student->status ?? 'active') }}</span>
                </div>
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Course Interest</div>
                        <strong>{{ $student->course_interest ?? 'Not set' }}</strong>
                    </div>
                    <i class="fas fa-book-open sp-muted"></i>
                </div>
                <div class="sp-quick-item">
                    <div>
                        <div class="sp-muted">Terms Accepted</div>
                        <strong>{{ $student->agreed_terms ? 'Yes' : 'No' }}</strong>
                    </div>
                    <i class="fas fa-shield-halved sp-muted"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sp-grid sp-grid-2 sp-section-gap">
    <div class="ad-card">
        <div class="ad-card-head">
            <h3>Student Information</h3>
        </div>
        <div class="ad-card-body">
            <div class="sp-list">
                <div class="sp-list-item"><span class="sp-muted">Student Number</span><strong>{{ $student->student_number ?? 'Pending assignment' }}</strong></div>
                <div class="sp-list-item"><span class="sp-muted">Full Name</span><strong>{{ $student->full_name }}</strong></div>
                <div class="sp-list-item"><span class="sp-muted">Username</span><strong>{{ $student->username ?? 'Not set' }}</strong></div>
                <div class="sp-list-item"><span class="sp-muted">Email</span><strong>{{ $student->email ?? auth()->user()->email }}</strong></div>
                <div class="sp-list-item"><span class="sp-muted">Phone</span><strong>{{ $student->phone ?? 'Not provided' }}</strong></div>
                <div class="sp-list-item"><span class="sp-muted">Date of Birth</span><strong>{{ $student->dob?->format('M d, Y') ?? 'Not provided' }}</strong></div>
                <div class="sp-list-item"><span class="sp-muted">Location</span><strong>{{ $student->location ?? 'Not provided' }}</strong></div>
            </div>
        </div>
    </div>

    <div class="ad-card">
        <div class="ad-card-head">
            <h3>Academic Profile</h3>
        </div>
        <div class="ad-card-body">
            <div class="sp-list">
                <div class="sp-list-item"><span class="sp-muted">Application Status</span><strong>{{ ucfirst($student->status ?? 'active') }}</strong></div>
                <div class="sp-list-item"><span class="sp-muted">Course Interest</span><strong>{{ $student->course_interest ?? 'Not set' }}</strong></div>
                <div class="sp-list-item"><span class="sp-muted">Goals</span><strong>{{ $student->goals ?? 'No goals recorded' }}</strong></div>
                <div class="sp-list-item"><span class="sp-muted">Terms Accepted</span><strong>{{ $student->agreed_terms ? 'Yes' : 'No' }}</strong></div>
            </div>
        </div>
    </div>
</div>
@endsection
