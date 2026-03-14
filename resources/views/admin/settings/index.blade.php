@extends('layouts.admin')
@section('title', 'Settings')

@section('content')
<div class="ad-page-hd">
  <div class="ad-page-hd-left">
    <h1>Settings</h1>
    <div class="ad-breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fas fa-chevron-right"></i>
      <span>Settings</span>
    </div>
  </div>
</div>

@if(session('success'))
<div class="ad-alert ad-alert-success">
  <i class="fas fa-circle-check"></i>
  {{ session('success') }}
  <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

  {{-- Admin Account --}}
  <div class="ad-card">
    <div class="ad-card-head">
      <h3><i class="fas fa-user-shield" style="color:var(--ad-primary);margin-right:6px"></i>Admin Account</h3>
    </div>
    <div class="ad-card-body">
      <div class="ad-form-group">
        <label class="ad-label">Name</label>
        <input type="text" class="ad-input" value="{{ Auth::user()->name }}" readonly>
      </div>
      <div class="ad-form-group">
        <label class="ad-label">Email</label>
        <input type="email" class="ad-input" value="{{ Auth::user()->email }}" readonly>
      </div>
      <div class="ad-form-group">
        <label class="ad-label">Role</label>
        <input type="text" class="ad-input" value="{{ Auth::user()->role ?? 'admin' }}" readonly>
      </div>
      <p class="ad-input-hint">To update account details, use the database directly or implement a profile update feature.</p>
    </div>
  </div>

  {{-- System Info --}}
  <div class="ad-card">
    <div class="ad-card-head">
      <h3><i class="fas fa-server" style="color:#2563eb;margin-right:6px"></i>System Information</h3>
    </div>
    <div class="ad-card-body">
      <div class="ad-form-group">
        <label class="ad-label">Application</label>
        <input type="text" class="ad-input" value="DevRoots Academy" readonly>
      </div>
      <div class="ad-form-group">
        <label class="ad-label">Laravel Version</label>
        <input type="text" class="ad-input" value="{{ app()->version() }}" readonly>
      </div>
      <div class="ad-form-group">
        <label class="ad-label">PHP Version</label>
        <input type="text" class="ad-input" value="{{ PHP_VERSION }}" readonly>
      </div>
      <div class="ad-form-group">
        <label class="ad-label">Environment</label>
        <input type="text" class="ad-input" value="{{ app()->environment() }}" readonly>
      </div>
    </div>
  </div>

</div>

<div class="ad-card" style="margin-top:0">
  <div class="ad-card-head">
    <h3><i class="fas fa-circle-info" style="color:#d97706;margin-right:6px"></i>Quick Links</h3>
  </div>
  <div class="ad-card-body">
    <div style="display:flex;gap:12px;flex-wrap:wrap">
      <a href="{{ route('admin.students.index') }}" class="btn-ad btn-ad-outline">
        <i class="fas fa-user-graduate"></i> Manage Students
      </a>
      <a href="{{ route('admin.courses.index') }}" class="btn-ad btn-ad-outline">
        <i class="fas fa-book-open"></i> Manage Courses
      </a>
      <a href="{{ route('admin.instructors.index') }}" class="btn-ad btn-ad-outline">
        <i class="fas fa-chalkboard-teacher"></i> Manage Instructors
      </a>
      <a href="{{ route('admin.reports.index') }}" class="btn-ad btn-ad-outline">
        <i class="fas fa-chart-bar"></i> View Reports
      </a>
    </div>
  </div>
</div>

@endsection
