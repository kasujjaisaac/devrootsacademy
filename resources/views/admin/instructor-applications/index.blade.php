@extends('layouts.admin')
@section('title', 'Instructor Applications')

@php
    $statusLabels = [
        'submitted' => 'Submitted',
        'reviewed' => 'Under Review',
        'accepted' => 'Accepted',
        'rejected' => 'Rejected',
        'activated' => 'Activated',
    ];

    $badgeMap = [
        'submitted' => 'ad-badge-pending',
        'reviewed' => 'ad-badge-pending',
        'accepted' => 'ad-badge-active',
        'rejected' => 'ad-badge-rejected',
        'activated' => 'ad-badge-finished',
    ];
@endphp

@section('content')

<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Instructor Applications</h1>
        <nav class="ad-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <span>Instructor Applications</span>
        </nav>
    </div>
    <div style="font-size:0.8125rem;color:var(--ad-muted);align-self:center;">
        {{ $applications->total() }} total records
    </div>
</div>

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

<div class="ad-stats-row" style="grid-template-columns:repeat(auto-fit,minmax(150px,1fr));margin-bottom:20px;">
    <a href="{{ route('admin.instructor-applications.index') }}" class="ad-stat-card blue" style="text-decoration:none;">
        <div>
            <div class="ad-stat-num">{{ $statusCounts->sum() }}</div>
            <div class="ad-stat-lbl">All Applications</div>
        </div>
    </a>
    @foreach($statusLabels as $statusKey => $label)
        <a href="{{ route('admin.instructor-applications.index', ['status' => $statusKey]) }}"
           class="ad-stat-card {{ $status === $statusKey ? 'green' : 'purple' }}"
           style="text-decoration:none;">
            <div>
                <div class="ad-stat-num">{{ $statusCounts[$statusKey] ?? 0 }}</div>
                <div class="ad-stat-lbl">{{ $label }}</div>
            </div>
        </a>
    @endforeach
</div>

<div class="ad-card">
    <div class="ad-table-toolbar">
        <div class="ad-search-box">
            <i class="fas fa-search"></i>
            <input class="ad-table-search" data-table="instructorApplicationsTable" placeholder="Search instructor applications...">
        </div>
    </div>
    <div class="ad-table-wrap">
        <table class="ad-table" id="instructorApplicationsTable">
            <thead>
                <tr>
                    <th class="cell-sm">#</th>
                    <th>Applicant</th>
                    <th>Expertise</th>
                    <th>Experience</th>
                    <th>Status</th>
                    <th>Applied</th>
                    <th>Reviewed By</th>
                    <th class="cell-action">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $application)
                <tr>
                    <td>{{ $applications->firstItem() + $loop->index }}</td>
                    <td>
                        <div style="font-weight:600;">{{ $application->full_name }}</div>
                        <div style="font-size:0.75rem;color:var(--ad-muted);">{{ $application->email }}</div>
                    </td>
                    <td>{{ $application->expertise }}</td>
                    <td>{{ $application->experience_years ? $application->experience_years . ' yrs' : '—' }}</td>
                    <td>
                        <span class="ad-badge {{ $badgeMap[$application->status] ?? 'ad-badge-pending' }}">
                            {{ $statusLabels[$application->status] ?? ucfirst($application->status) }}
                        </span>
                    </td>
                    <td>{{ $application->created_at->format('M d, Y') }}</td>
                    <td>{{ $application->reviewer?->name ?? '—' }}</td>
                    <td>
                        <a href="{{ route('admin.instructor-applications.show', $application) }}" class="btn-ad btn-ad-outline btn-ad-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
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

    @if($applications->hasPages())
    <div style="padding:12px 16px;border-top:1px solid var(--ad-border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
        <span style="font-size:0.75rem;color:var(--ad-muted);">
            Showing {{ $applications->firstItem() }}–{{ $applications->lastItem() }} of {{ $applications->total() }} records
        </span>
        {{ $applications->links() }}
    </div>
    @endif
</div>

@endsection
