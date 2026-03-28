@extends('layouts.admin')
@section('title', 'Lecture Recordings')

@section('content')
<div class="ad-page-hd">
  <div class="ad-page-hd-left">
    <h1>Lecture Recordings</h1>
    <div class="ad-breadcrumb">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <i class="fas fa-chevron-right"></i>
      <span>Lecture Recordings</span>
    </div>
  </div>
  <div class="ad-page-hd-right">
    <a href="{{ route('admin.lecture-recordings.create') }}" class="btn-ad btn-ad-primary">
      <i class="fas fa-plus"></i> Add Recording
    </a>
  </div>
</div>

<div class="ad-card">
  <div class="ad-card-head">
    <h3>Published Lectures</h3>
  </div>
  <div class="ad-table-wrap">
    <table class="ad-table">
      <thead>
        <tr>
          <th>Lecture</th>
          <th>Course</th>
          <th>Class Date</th>
          <th>Status</th>
          <th>Added By</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($recordings as $recording)
          <tr>
            <td>
              <div style="font-weight:600;">{{ $recording->title }}</div>
              <div style="font-size:0.75rem;color:var(--ad-muted);">{{ $recording->topic ?: 'Google Drive lecture recording' }}</div>
            </td>
            <td>{{ $recording->course?->title ?? 'Course removed' }}</td>
            <td>{{ $recording->class_date->format('M d, Y') }}</td>
            <td>
              <span class="ad-badge {{ $recording->is_published ? 'ad-badge-active' : 'ad-badge-pending' }}">
                {{ $recording->is_published ? 'Published' : 'Draft' }}
              </span>
            </td>
            <td>{{ $recording->uploader?->name ?? 'Staff' }}</td>
            <td>
              <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end;">
                <a href="{{ $recording->google_drive_url }}" target="_blank" rel="noopener noreferrer" class="btn-ad btn-ad-outline btn-ad-sm">
                  <i class="fas fa-link"></i> Open
                </a>
                <a href="{{ route('admin.lecture-recordings.edit', $recording) }}" class="btn-ad btn-ad-outline btn-ad-sm">
                  <i class="fas fa-pen"></i> Edit
                </a>
                <form method="POST" action="{{ route('admin.lecture-recordings.destroy', $recording) }}" onsubmit="return confirm('Remove this lecture recording?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-ad btn-ad-danger btn-ad-sm">
                    <i class="fas fa-trash"></i> Remove
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="ad-table-empty">
              <i class="fas fa-circle-play"></i> No lecture recordings have been added yet.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
