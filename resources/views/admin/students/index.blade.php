@extends('layouts.admin')
@section('title', 'Students')

@section('content')

{{-- Page Header --}}
<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Students</h1>
        <nav class="ad-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <span>Students</span>
        </nav>
    </div>
    <div style="font-size:0.8125rem;color:var(--ad-muted);align-self:center;">
        {{ $students->total() }} total records
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

{{-- Students Table Card --}}
<div class="ad-card">
    <div class="ad-table-toolbar">
        <div class="ad-search-box">
            <i class="fas fa-search"></i>
            <input class="ad-table-search" data-table="studentsTable" placeholder="Search students...">
        </div>
    </div>
    <div class="ad-table-wrap">
        <table class="ad-table" id="studentsTable">
            <thead>
                <tr>
                    <th class="cell-sm">#</th>
                    <th>Student No.</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Course Interest</th>
                    <th>Status</th>
                    <th>Applied</th>
                    <th class="cell-action">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td>{{ $students->firstItem() + $loop->index }}</td>
                    <td>{{ $student->student_number ?? 'Pending' }}</td>
                    <td>{{ $student->full_name }}</td>
                    <td>{{ $student->email ?? '-' }}</td>
                    <td>{{ $student->phone ?? '-' }}</td>
                    <td>{{ $student->course_interest ?? '-' }}</td>
                    <td>
                        @php $st = $student->status ?? 'pending'; @endphp
                        <span class="ad-badge
                            {{ $st === 'active' ? 'ad-badge-active' : ($st === 'finished' ? 'ad-badge-finished' : ($st === 'inactive' ? 'ad-badge-rejected' : 'ad-badge-pending')) }}">
                            {{ ucfirst($st) }}
                        </span>
                    </td>
                    <td>{{ $student->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.students.show', $student->id) }}"
                           class="btn-ad btn-ad-outline btn-ad-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="ad-table-empty">
                        <i class="fas fa-user-graduate"></i>
                        No students found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($students->hasPages())
    <div style="padding:12px 16px;border-top:1px solid var(--ad-border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
        <span style="font-size:0.75rem;color:var(--ad-muted);">
            Showing {{ $students->firstItem() }}–{{ $students->lastItem() }} of {{ $students->total() }} records
        </span>
        {{ $students->links() }}
    </div>
    @endif
</div>

@endsection
