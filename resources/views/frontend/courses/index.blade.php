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
                <div class="course-card">
                    <div class="course-card-img">
                        <img src="{{ $course->image ? asset('storage/' . $course->image) : asset('images/courses/programming.png') }}"
                             alt="{{ $course->title }}"
                             loading="lazy">
                    </div>
                    <div class="course-card-body">
                        @php($enrollmentStatus = $course->enrollmentStatus())
                        <div class="course-meta-tags" style="margin-bottom:10px;display:flex;gap:8px;flex-wrap:wrap;">
                            @if($course->level)
                                <span class="course-tag level-{{ strtolower($course->level) }}">{{ $course->level }}</span>
                            @endif
                            <span class="course-tag" style="{{ $enrollmentStatus['tone'] === 'closed' ? 'background:rgba(198,40,40,0.12);color:#9f1d26;' : ($enrollmentStatus['tone'] === 'closing' ? 'background:rgba(217,119,6,0.14);color:#b45309;' : 'background:rgba(22,163,74,0.12);color:#166534;') }}">
                                {{ $enrollmentStatus['label'] }}
                            </span>
                        </div>
                        <h3>{{ $course->title }}</h3>
                        <p>{{ $course->short_description ?: Str::limit(strip_tags($course->description), 110) }}</p>
                        <div class="d-flex align-items-center justify-content-between mt-auto mb-3 flex-wrap gap-1">
                            @if($course->duration_weeks)
                                <small style="color:var(--text-muted);"><i class="fas fa-clock me-1"></i>{{ $course->duration_weeks }} weeks</small>
                            @endif
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

        <div class="pagination-wrapper">
            {{ $courses->links() }}
        </div>
    </div>
</div>

@endsection
