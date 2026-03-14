@extends('layouts.admin')
@section('title', 'Instructor Applications')

@section('content')

{{-- Page Header --}}
<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Instructor Applications</h1>
        <nav class="ad-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <span>Instructors</span>
        </nav>
    </div>
</div>

{{-- Session Alerts --}}
@if(session('success'))
<div class="ad-alert ad-alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
    <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif
@if(session('error'))
<div class="ad-alert ad-alert-error">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
    <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
</div>
@endif

{{-- Instructors Table Card --}}
<div class="ad-card">
    <div class="ad-table-toolbar">
        <div class="ad-search-box">
            <i class="fas fa-search"></i>
            <input class="ad-table-search" data-table="instructorsTable" placeholder="Search instructors...">
        </div>
    </div>
    <div class="ad-table-wrap">
        <table class="ad-table" id="instructorsTable">
            <thead>
                <tr>
                    <th class="cell-sm">#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Expertise</th>
                    <th>Experience</th>
                    <th>Status</th>
                    <th>Applied</th>
                    <th class="cell-action">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($instructors as $instructor)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $instructor->full_name }}</td>
                    <td>{{ $instructor->email }}</td>
                    <td>{{ $instructor->expertise ?? '-' }}</td>
                    <td>
                        @if($instructor->experience_years)
                            {{ $instructor->experience_years }} yr{{ $instructor->experience_years == 1 ? '' : 's' }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @php $is = $instructor->status ?? 'pending'; @endphp
                        <span class="ad-badge
                            {{ $is === 'approved' ? 'ad-badge-approved' : ($is === 'rejected' ? 'ad-badge-rejected' : 'ad-badge-pending') }}">
                            {{ ucfirst($is) }}
                        </span>
                    </td>
                    <td>{{ $instructor->created_at->format('M d, Y') }}</td>
                    <td>
                        @if(($instructor->status ?? 'pending') === 'pending')
                            <div style="display:flex;gap:6px;align-items:center;">
                                <form method="POST"
                                      action="{{ route('admin.instructors.approve', $instructor->id) }}"
                                      style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-ad btn-ad-success btn-ad-sm">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                <form method="POST"
                                      action="{{ route('admin.instructors.reject', $instructor->id) }}"
                                      style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-ad btn-ad-danger btn-ad-sm">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </form>
                            </div>
                        @else
                            <span style="font-size:0.75rem;color:var(--ad-muted);">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="ad-table-empty">
                        <i class="fas fa-chalkboard-teacher"></i>
                        No instructor applications found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
