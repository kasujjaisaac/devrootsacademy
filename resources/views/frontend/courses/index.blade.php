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

    {{-- Sidebar --}}
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

    {{-- Courses Grid --}}
    <div class="courses-content p-4">
        <div class="courses-grid-listing">
            @forelse($courses as $course)
                <x-frontend.course-card
                    :image="$course->image ? asset('storage/' . $course->image) : asset('images/courses/programming.png')"
                    :title="$course->title"
                    :desc="$course->short_description ?: Str::limit(strip_tags($course->description), 110)"
                    :duration="$course->duration_weeks ? $course->duration_weeks . ' Weeks' : ''"
                    :level="$course->level ?: ''"
                    :enrollment-status="$course->enrollmentStatus()"
                    :fee="$course->fee ? 'UGX ' . number_format($course->fee) : 'Free'"
                    action-label="View Course"
                    :slug="$course->slug" />
            @empty
                <p class="no-courses">No courses found in this category.</p>
            @endforelse
        </div>

        <div class="pagination-wrapper">
            {{ $courses->links() }}
        </div>
    </div>
</div>

@endsection
