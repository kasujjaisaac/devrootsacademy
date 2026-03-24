@extends('layouts.admin')
@section('title', 'Instructors')

@section('content')

{{-- Page Header --}}
<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Instructors</h1>
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
                    <th>Created</th>
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
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="ad-table-empty">
                        <i class="fas fa-chalkboard-teacher"></i>
                        No instructors found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
