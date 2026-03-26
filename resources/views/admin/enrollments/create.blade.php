@extends('layouts.admin')
@section('title', 'Add Enrollment')

@section('content')
<div class="ad-page-hd">
  <div class="ad-page-hd-left">
    <h1>Add Enrollment</h1>
    <div class="ad-breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fas fa-chevron-right"></i>
      <a href="{{ route('admin.enrollments.index') }}">Enrollments</a>
      <i class="fas fa-chevron-right"></i>
      <span>Add</span>
    </div>
  </div>
  <a href="{{ route('admin.enrollments.index') }}" class="btn-ad btn-ad-outline">
    <i class="fas fa-arrow-left"></i> Back
  </a>
</div>

<div class="ad-card" style="max-width:560px">
  <div class="ad-card-head"><h3>Enrollment Details</h3></div>
  <div class="ad-card-body">
    <form method="POST" action="{{ route('admin.enrollments.store') }}">
      @csrf
      <div class="ad-form-group">
        <label class="ad-label" for="student_id">Student <span class="required">*</span></label>
        <select name="student_id" id="student_id" class="ad-select {{ $errors->has('student_id') ? 'is-invalid' : '' }}" required>
          <option value="">-- Select Student --</option>
          @foreach($students as $student)
          <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
            {{ $student->full_name ?? trim(($student->first_name ?? '').' '.($student->last_name ?? '')) ?: 'N/A' }}
          </option>
          @endforeach
        </select>
        @error('student_id')<p class="ad-error">{{ $message }}</p>@enderror
      </div>
      <div class="ad-form-group">
        <label class="ad-label" for="course_id">Course <span class="required">*</span></label>
        <select name="course_id" id="course_id" class="ad-select {{ $errors->has('course_id') ? 'is-invalid' : '' }}" required>
          <option value="">-- Select Course --</option>
          @foreach($courses as $course)
          <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
            {{ $course->title }}
          </option>
          @endforeach
        </select>
        @error('course_id')<p class="ad-error">{{ $message }}</p>@enderror
      </div>
      <div class="ad-form-group">
        <label class="ad-label" for="status">Status</label>
        <select name="status" id="status" class="ad-select">
          @foreach(['pending','active','completed','cancelled'] as $s)
          <option value="{{ $s }}" {{ old('status', 'pending') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn-ad btn-ad-primary">
        <i class="fas fa-save"></i> Save Enrollment
      </button>
    </form>
  </div>
</div>
@endsection
