@extends('layouts.frontend')

@section('title', $course->title . ' | DevRoots Academy')
@section('meta_description', Str::limit(strip_tags($course->description), 160))

@section('content')

{{-- ===== PAGE HERO ===== --}}
<section class="page-hero">
    <div class="container">
        <div class="d-flex flex-wrap gap-2 mb-3">
            @if($course->category)
                <span class="badge" style="background:var(--primary);color:#fff;padding:6px 14px;font-size:0.8rem;">{{ $course->category }}</span>
            @endif
            @if($course->level)
                <span class="badge" style="background:rgba(255,255,255,0.2);color:#fff;padding:6px 14px;font-size:0.8rem;">{{ $course->level }}</span>
            @endif
        </div>
        <h1>{{ $course->title }}</h1>
        @if($course->short_description)
            <p>{{ $course->short_description }}</p>
        @endif
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
                <li class="breadcrumb-item active">{{ $course->title }}</li>
            </ol>
        </nav>
    </div>
</section>

{{-- ===== MAIN CONTENT ===== --}}
<section class="section">
    <div class="container">

        {{-- Course meta strip --}}
        @if($course->duration_weeks || $course->schedule || $course->mode)
        <div class="d-flex flex-wrap gap-4 mb-4 p-3" style="background:var(--surface);border:1px solid var(--border);">
            @if($course->duration_weeks)
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-clock text-primary"></i>
                <span style="font-size:0.875rem;"><strong>Duration:</strong> {{ $course->duration_weeks }} weeks</span>
            </div>
            @endif
            @if($course->schedule)
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-calendar-alt text-primary"></i>
                <span style="font-size:0.875rem;"><strong>Schedule:</strong> {{ $course->schedule }}</span>
            </div>
            @endif
            @if($course->mode)
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-laptop text-primary"></i>
                <span style="font-size:0.875rem;"><strong>Mode:</strong> {{ $course->mode }}</span>
            </div>
            @endif
        </div>
        @endif

        {{-- Course image --}}
        @if($course->image)
        <div class="mb-4" style="max-height:380px;overflow:hidden;">
            <img src="{{ asset('storage/' . $course->image) }}"
                 alt="{{ $course->title }}"
                 class="w-100" style="object-fit:cover;max-height:380px;">
        </div>
        @endif

        {{-- Course Description --}}
        <div class="course-desc-card mb-4">
            <div style="font-size:0.9375rem;">{!! $course->description !!}</div>
        </div>

        {{-- Details Grid --}}
        <div class="details-grid">

            {{-- Fees Card --}}
            <div class="details-card">
                <h2>Fees Structure</h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr><th>Item</th><th>Amount (UGX)</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Course Fees</td>
                                <td>{{ $course->fee ? number_format($course->fee) : 'Free' }}</td>
                            </tr>
                            <tr>
                                <td>Registration</td>
                                <td>Free</td>
                            </tr>
                            <tr>
                                <td><strong>Total</strong></td>
                                <td><strong>{{ $course->fee ? number_format($course->fee) : 'Free' }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="payments-box">
                    <span class="payments-label"><i class="fas fa-lock me-1"></i> Payments are safe and secure</span>
                    <div class="payments-logos">
                        <img src="{{ asset('images/mtn-momo.png') }}" alt="MTN Mobile Money">
                        <img src="{{ asset('images/airtel-money.png') }}" alt="Airtel Money">
                        <img src="{{ asset('images/visa.png') }}" alt="Visa">
                    </div>
                </div>

                <a href="{{ route('apply.now') }}" class="btn btn-primary w-100 mt-4">
                    <i class="fas fa-paper-plane me-2"></i>Apply Now
                </a>
            </div>

            {{-- Course Outline --}}
            <div class="details-card">
                <h2>Course Outline (Weekly)</h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr><th>Week</th><th>Topics</th></tr>
                        </thead>
                        <tbody>
                            @forelse($course->outline ?? [] as $week => $topic)
                                <tr>
                                    <td>{{ is_numeric($week) ? 'Week ' . ($week + 1) : $week }}</td>
                                    <td>{{ $topic }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" style="color:var(--text-muted);font-style:italic;">
                                        Course outline will be available soon.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
