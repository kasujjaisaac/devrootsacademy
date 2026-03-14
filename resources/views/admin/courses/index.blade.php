@extends('layouts.admin')
@section('title', 'Courses')

@section('content')

{{-- Page Header --}}
<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Courses</h1>
        <nav class="ad-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <span>Courses</span>
        </nav>
    </div>
    <a href="{{ route('admin.courses.create') }}" class="btn-ad btn-ad-primary">
        <i class="fas fa-plus"></i> Add Course
    </a>
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

{{-- Courses Table Card --}}
<div class="ad-card">
    <div class="ad-table-toolbar">
        <div class="ad-search-box">
            <i class="fas fa-search"></i>
            <input class="ad-table-search" data-table="coursesTable" placeholder="Search courses...">
        </div>
    </div>
    <div class="ad-table-wrap">
        <table class="ad-table" id="coursesTable">
            <thead>
                <tr>
                    <th class="cell-sm">#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Fee (UGX)</th>
                    <th class="cell-action">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->category ?? '-' }}</td>
                    <td>
                        @if($course->fee)
                            UGX {{ number_format($course->fee, 0) }}
                        @else
                            <span style="color:var(--ad-muted);">Free</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;align-items:center;">
                            <a href="{{ route('admin.courses.edit', $course->id) }}"
                               class="btn-ad btn-ad-outline btn-ad-sm">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                            <form action="{{ route('admin.courses.destroy', $course->id) }}"
                                  method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="btn-ad btn-ad-danger btn-ad-sm"
                                        data-confirm-delete>
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="ad-table-empty">
                        <i class="fas fa-book-open"></i>
                        No courses found. <a href="{{ route('admin.courses.create') }}" style="color:var(--ad-primary);">Add a course</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
