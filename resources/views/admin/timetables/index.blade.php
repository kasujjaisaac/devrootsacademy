@extends('layouts.admin')
@section('title', 'Timetables')

@section('content')
<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Timetables</h1>
        <nav class="ad-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <span>Timetables</span>
        </nav>
    </div>
    <a href="{{ route('admin.timetables.create') }}" class="btn-ad btn-ad-primary">
        <i class="fas fa-plus"></i> Add Timetable
    </a>
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

<div class="ad-card">
    <div class="ad-table-toolbar">
        <div class="ad-search-box">
            <i class="fas fa-search"></i>
            <input class="ad-table-search" data-table="timetablesTable" placeholder="Search timetable entries...">
        </div>
    </div>
    <div class="ad-table-wrap">
        <table class="ad-table" id="timetablesTable">
            <thead>
                <tr>
                    <th class="cell-sm">#</th>
                    <th>Course</th>
                    <th>Session</th>
                    <th>Starts</th>
                    <th>Ends</th>
                    <th>Status</th>
                    <th class="cell-action">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($timetables as $timetable)
                <tr>
                    <td>{{ $timetables->firstItem() + $loop->index }}</td>
                    <td>{{ $timetable->course?->title ?? 'Unassigned course' }}</td>
                    <td>
                        <div style="font-weight:600;">{{ $timetable->title }}</div>
                        <div style="font-size:0.75rem;color:var(--ad-muted);">{{ \Illuminate\Support\Str::limit($timetable->description ?: 'No description provided.', 70) }}</div>
                    </td>
                    <td>{{ $timetable->starts_at->format('M d, Y g:i A') }}</td>
                    <td>{{ $timetable->ends_at?->format('M d, Y g:i A') ?? '—' }}</td>
                    <td>
                        <span class="ad-badge {{ $timetable->is_active ? 'ad-badge-active' : 'ad-badge-pending' }}">
                            {{ $timetable->is_active ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;align-items:center;">
                            <a href="{{ route('admin.timetables.edit', $timetable) }}" class="btn-ad btn-ad-outline btn-ad-sm">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                            <form action="{{ route('admin.timetables.destroy', $timetable) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-ad btn-ad-danger btn-ad-sm" data-confirm-delete>
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="ad-table-empty">
                        <i class="fas fa-calendar-days"></i>
                        No timetable entries found. <a href="{{ route('admin.timetables.create') }}" style="color:var(--ad-primary);">Create one now</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($timetables->hasPages())
    <div style="padding:12px 16px;border-top:1px solid var(--ad-border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
        <span style="font-size:0.75rem;color:var(--ad-muted);">
            Showing {{ $timetables->firstItem() }}-{{ $timetables->lastItem() }} of {{ $timetables->total() }} timetable entries
        </span>
        {{ $timetables->links() }}
    </div>
    @endif
</div>
@endsection
