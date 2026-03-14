@extends('layouts.admin')
@section('title', 'Reports')

@section('content')
<div class="ad-page-hd">
  <div class="ad-page-hd-left">
    <h1>Reports</h1>
    <div class="ad-breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fas fa-chevron-right"></i>
      <span>Reports</span>
    </div>
  </div>
</div>

{{-- KPI Stats --}}
<div class="ad-stats-row">
  <div class="ad-stat-card red">
    <div class="ad-stat-icon"><i class="fas fa-user-graduate"></i></div>
    <div>
      <div class="ad-stat-num">{{ number_format($totalStudents) }}</div>
      <div class="ad-stat-lbl">Total Students</div>
    </div>
  </div>
  <div class="ad-stat-card blue">
    <div class="ad-stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
    <div>
      <div class="ad-stat-num">{{ number_format($totalInstructors) }}</div>
      <div class="ad-stat-lbl">Total Instructors</div>
    </div>
  </div>
  <div class="ad-stat-card green">
    <div class="ad-stat-icon"><i class="fas fa-book-open"></i></div>
    <div>
      <div class="ad-stat-num">{{ number_format($totalCourses) }}</div>
      <div class="ad-stat-lbl">Total Courses</div>
    </div>
  </div>
  <div class="ad-stat-card orange">
    <div class="ad-stat-icon"><i class="fas fa-coins"></i></div>
    <div>
      <div class="ad-stat-num">UGX {{ number_format($totalPayments) }}</div>
      <div class="ad-stat-lbl">Total Revenue</div>
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">
  {{-- Top Courses --}}
  <div class="ad-card">
    <div class="ad-card-head"><h3><i class="fas fa-trophy" style="color:#d97706;margin-right:6px"></i>Top Courses by Enrollment</h3></div>
    <div class="ad-card-body-p0">
      <div class="ad-table-wrap">
        <table class="ad-table">
          <thead><tr><th>#</th><th>Course</th><th>Enrollments</th></tr></thead>
          <tbody>
            @forelse($topCourses as $i => $course)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $course->title }}</td>
              <td><strong>{{ $course->enrollments_count }}</strong></td>
            </tr>
            @empty
            <tr><td colspan="3" class="ad-table-empty"><i class="fas fa-chart-bar"></i>No data yet</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Recent Enrollments --}}
  <div class="ad-card">
    <div class="ad-card-head"><h3><i class="fas fa-clock" style="color:#2563eb;margin-right:6px"></i>Recent Enrollments</h3></div>
    <div class="ad-card-body-p0">
      <div class="ad-table-wrap">
        <table class="ad-table">
          <thead><tr><th>Student</th><th>Course</th><th>Date</th></tr></thead>
          <tbody>
            @forelse($recentEnrollments as $e)
            <tr>
              <td>{{ $e->student->full_name ?? $e->student->first_name ?? 'N/A' }}</td>
              <td>{{ $e->course->title ?? 'N/A' }}</td>
              <td style="white-space:nowrap">{{ $e->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="3" class="ad-table-empty">No enrollments yet</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Monthly summary --}}
<div class="ad-card">
  <div class="ad-card-head"><h3>Monthly Overview ({{ date('Y') }})</h3></div>
  <div class="ad-card-body-p0">
    <div class="ad-table-wrap">
      <table class="ad-table">
        <thead>
          <tr>
            <th>Month</th>
            @foreach($months as $m)<th>{{ $m }}</th>@endforeach
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><strong>Enrollments</strong></td>
            @foreach($enrollmentsPerMonth as $v)<td>{{ $v }}</td>@endforeach
          </tr>
          <tr>
            <td><strong>Revenue (UGX)</strong></td>
            @foreach($paymentsPerMonth as $v)<td>{{ number_format($v) }}</td>@endforeach
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
