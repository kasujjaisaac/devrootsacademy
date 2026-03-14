@extends('layouts.frontend')

@section('title', 'All Courses | DevRoots Academy')
@section('meta_description', 'Browse all IT courses at DevRoots Academy — programming, networking, hardware repair, cloud computing and more.')

@section('content')

{{-- ===== PAGE HERO ===== --}}
<section class="page-hero">
    <div class="container">
        <h1>Courses at DevRoots Academy</h1>
        <p>A career in your desired Computer Science field starts here.</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Courses</li>
            </ol>
        </nav>
    </div>
</section>

{{-- ===== COURSES LAYOUT ===== --}}
<div class="courses-layout">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="courses-sidebar">
        <p class="courses-sidebar-heading">Categories</p>
        <ul class="courses-sidebar-nav">
            <li>
                <a href="{{ route('courses.index') }}"
                   class="{{ !request()->has('category') ? 'active' : '' }}">
                    All Courses
                </a>
            </li>
            @foreach($categories as $cat)
                <li>
                    <a href="{{ route('courses.index', ['category' => $cat->category]) }}"
                       class="{{ request('category') == $cat->category ? 'active' : '' }}">
                        {{ $cat->category }}
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    {{-- ===== COURSES CONTENT ===== --}}
    <div class="courses-content p-4">

        {{-- Grid --}}
        <div class="courses-grid-listing">
            @forelse($courses as $course)
                <div class="course-card">
                    <div class="course-card-img">
                        <img src="{{ asset('images/' . $course->image) }}"
                             alt="{{ $course->title }}"
                             loading="lazy">
                    </div>
                    <div class="course-card-body">
                        <div class="course-meta-tags">
                            <span class="badge-primary">{{ $course->category }}</span>
                        </div>
                        <h3>{{ $course->title }}</h3>
                        <p>{{ Str::limit($course->description, 110) }}</p>
                        <div class="d-flex align-items-center justify-content-between mt-auto mb-3">
                            <span class="course-fee">
                                {{ $course->fee ? 'UGX ' . number_format($course->fee) : 'Free' }}
                            </span>
                        </div>
                        <a href="{{ route('courses.show', $course->slug) }}"
                           class="btn btn-primary btn-sm w-100">
                            View Course
                        </a>
                    </div>
                </div>
            @empty
                <p class="no-courses">No courses found in this category.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper">
            {{ $courses->links() }}
        </div>

    </div>
</div>

@endsection
