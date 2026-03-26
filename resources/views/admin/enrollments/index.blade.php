@extends('layouts.admin')
@section('title', 'Enrollments')

@section('content')
<div class="ad-page-hd">
  <div class="ad-page-hd-left">
    <h1>Enrollments</h1>
    <div class="ad-breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fas fa-chevron-right"></i>
      <span>Enrollments</span>
    </div>
  </div>
  <a href="{{ route('admin.enrollments.create') }}" class="btn-ad btn-ad-primary">
    <i class="fas fa-plus"></i> Add Enrollment
  </a>
</div>

@if(session('success'))
<div class="ad-alert ad-alert-success">
  <i class="fas fa-circle-check"></i> {{ session('success') }}
  <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif

<div class="ad-card">
  <div class="ad-table-toolbar">
    <div class="ad-search-box">
      <i class="fas fa-magnifying-glass"></i>
      <input class="ad-table-search" data-table="enrollmentsTable" placeholder="Search...">
    </div>
    <span style="font-size:0.75rem;color:var(--ad-muted)">{{ count($enrollments) }} record(s)</span>
  </div>
  <div class="ad-card-body-p0">
    <div class="ad-table-wrap">
      <table class="ad-table" id="enrollmentsTable">
        <thead>
          <tr>
            <th class="cell-sm">#</th>
            <th>Student</th>
            <th>Course</th>
            <th>Status</th>
            <th>Date</th>
            <th class="cell-action">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($enrollments as $i => $e)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $e->student?->full_name ?? trim(($e->student?->first_name ?? '').' '.($e->student?->last_name ?? '')) ?: 'N/A' }}</td>
            <td>{{ $e->course->title ?? 'N/A' }}</td>
            <td>
              <span class="ad-badge ad-badge-{{ $e->status === 'active' ? 'active' : ($e->status === 'completed' ? 'finished' : 'pending') }}">
                {{ ucfirst($e->status ?? 'pending') }}
              </span>
            </td>
            <td style="white-space:nowrap">{{ $e->created_at->format('M d, Y') }}</td>
            <td>
              <div style="display:flex;gap:4px">
                <a href="{{ route('admin.enrollments.show', $e) }}" class="btn-ad-icon" title="View">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.enrollments.edit', $e) }}" class="btn-ad-icon" title="Edit">
                  <i class="fas fa-pen"></i>
                </a>
                <form method="POST" action="{{ route('admin.enrollments.destroy', $e) }}" style="display:inline">
                  @csrf @method('DELETE')
                  <button type="button" class="btn-ad-icon danger" data-confirm-delete title="Delete">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="ad-table-empty">
            <i class="fas fa-layer-group"></i> No enrollments found
          </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
