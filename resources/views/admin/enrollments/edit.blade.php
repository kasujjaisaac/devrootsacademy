@extends('layouts.admin')
@section('title', 'Edit Enrollment')

@section('content')
<div class="ad-page-hd">
  <div class="ad-page-hd-left">
    <h1>Edit Enrollment</h1>
    <div class="ad-breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fas fa-chevron-right"></i>
      <a href="{{ route('admin.enrollments.index') }}">Enrollments</a>
      <i class="fas fa-chevron-right"></i>
      <span>Edit</span>
    </div>
  </div>
  <a href="{{ route('admin.enrollments.index') }}" class="btn-ad btn-ad-outline">
    <i class="fas fa-arrow-left"></i> Back
  </a>
</div>

<div class="ad-card" style="max-width:560px">
  <div class="ad-card-head"><h3>Update Status</h3></div>
  <div class="ad-card-body">
    <div class="ad-form-group">
      <label class="ad-label">Student</label>
      <input type="text" class="ad-input" value="{{ $enrollment->student?->full_name ?? trim(($enrollment->student?->first_name ?? '').' '.($enrollment->student?->last_name ?? '')) ?: 'N/A' }}" readonly>
    </div>
    <div class="ad-form-group">
      <label class="ad-label">Course</label>
      <input type="text" class="ad-input" value="{{ $enrollment->course->title ?? 'N/A' }}" readonly>
    </div>
    <form method="POST" action="{{ route('admin.enrollments.update', $enrollment) }}">
      @csrf @method('PUT')
      <div class="ad-form-group">
        <label class="ad-label" for="status">Status <span class="required">*</span></label>
        <select name="status" id="status" class="ad-select" required>
          @foreach(['pending','active','completed','cancelled'] as $s)
          <option value="{{ $s }}" {{ $enrollment->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn-ad btn-ad-primary">
        <i class="fas fa-save"></i> Update
      </button>
    </form>
  </div>
</div>
@endsection
