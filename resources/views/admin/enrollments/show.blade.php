@extends('layouts.admin')
@section('title', 'Enrollment Details')

@section('content')
<div class="ad-page-hd">
  <div class="ad-page-hd-left">
    <h1>Enrollment #{{ $enrollment->id }}</h1>
    <div class="ad-breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fas fa-chevron-right"></i>
      <a href="{{ route('admin.enrollments.index') }}">Enrollments</a>
      <i class="fas fa-chevron-right"></i>
      <span>View</span>
    </div>
  </div>
  <div style="display:flex;gap:8px">
    <a href="{{ route('admin.enrollments.edit', $enrollment) }}" class="btn-ad btn-ad-outline">
      <i class="fas fa-pen"></i> Edit
    </a>
    <a href="{{ route('admin.enrollments.index') }}" class="btn-ad btn-ad-outline">
      <i class="fas fa-arrow-left"></i> Back
    </a>
  </div>
</div>

<div class="ad-card" style="max-width:560px">
  <div class="ad-card-body">
    <div class="ad-form-group">
      <label class="ad-label">Student</label>
      <p>{{ $enrollment->student?->full_name ?? trim(($enrollment->student?->first_name ?? '').' '.($enrollment->student?->last_name ?? '')) ?: 'N/A' }}</p>
    </div>
    <div class="ad-form-group">
      <label class="ad-label">Course</label>
      <p>{{ $enrollment->course->title ?? 'N/A' }}</p>
    </div>
    <div class="ad-form-group">
      <label class="ad-label">Status</label>
      <span class="ad-badge ad-badge-{{ $enrollment->status === 'active' ? 'active' : ($enrollment->status === 'completed' ? 'finished' : 'pending') }}">
        {{ ucfirst($enrollment->status ?? 'pending') }}
      </span>
    </div>
    <div class="ad-form-group">
      <label class="ad-label">Enrolled On</label>
      <p>{{ $enrollment->created_at->format('F d, Y \a\t h:i A') }}</p>
    </div>
  </div>
</div>
@endsection
