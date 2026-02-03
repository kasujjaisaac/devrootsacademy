@extends('layouts.frontend')

@section('title', 'All Courses - DevRoots Academy')

{{-- Link new CSS --}}
@push('styles')
<link rel="stylesheet" href="{{ asset('css/courses-modern.css') }}">
@endpush

@section('content')

<!-- HERO -->
<section class="instructor-hero" style="background-color: #FF4C4C; color: white; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1>Courses at DevRoots Academy</h1>
        <p>A career in your desired Computer Science field start now</p>
    </div>
</section>

<!-- ================= COURSES PAGE ================= -->
<div class="container courses-page">

    <div class="courses-layout">

        {{-- ================= SIDEBAR ================= --}}
        <aside class="courses-sidebar">
            <h2>Categories</h2>
            <ul>
                <li>
                    <a href="{{ route('courses.index') }}" class="{{ request()->has('category') ? '' : 'active' }}">
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

        {{-- ================= COURSES GRID ================= --}}
        <section class="courses-grid">
            @forelse($courses as $course)
                <div class="course-card">
                    <img src="{{ asset('images/' . $course->image) }}" alt="{{ $course->title }}">
                    <div class="course-card-content">
                        <span class="course-category">{{ $course->category }}</span>
                        <h3>{{ $course->title }}</h3>
                        <p>{{ Str::limit($course->description, 120) }}</p>
                        <div class="course-meta">
                            <span class="course-fee">{{ $course->fee ? 'UGX '.number_format($course->fee) : 'Free' }}</span>
                            <span class="course-duration">8 weeks</span>
                        </div>
                        <a href="{{ route('courses.show', $course->slug) }}" class="apply-btn">View Course</a>
                    </div>
                </div>
            @empty
                <p class="no-courses">No courses found in this category.</p>
            @endforelse
        </section>

    </div>

    <!-- ================= PAGINATION ================= -->
    <div class="pagination-wrapper">
        {{ $courses->links() }}
    </div>


</div>
@endsection
@push('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
@endpush
