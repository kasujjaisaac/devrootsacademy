@extends('layouts.frontend')

@section('title', $course->title . ' | DevRoots Academy')
@section('meta_description', Str::limit($course->description, 160))

@section('content')

{{-- ===== PAGE HERO ===== --}}
<section class="page-hero">
    <div class="container">
        <h1>{{ $course->title }}</h1>
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

        {{-- Course Description --}}
        <div class="course-desc-card mb-4">
            <p style="margin:0;font-size:0.9375rem;">{{ $course->description }}</p>
        </div>

        {{-- Details Grid --}}
        <div class="details-grid">

            {{-- Fees Card --}}
            <div class="details-card">
                <h2>Fees Structure</h2>

                <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Amount (UGX)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Course Fees</td>
                            <td>{{ number_format($course->fee) }}</td>
                        </tr>
                        <tr>
                            <td>Registration</td>
                            <td>Free</td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td><strong>{{ number_format($course->fee) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                </div>

                <div class="payments-box">
                    <span class="payments-label">
                        <i class="fas fa-lock me-1"></i> Payments are safe and secure
                    </span>
                    <div class="payments-logos">
                        <img src="{{ asset('images/mtn-momo.png') }}"    alt="MTN Mobile Money">
                        <img src="{{ asset('images/airtel-money.png') }}" alt="Airtel Money">
                        <img src="{{ asset('images/visa.png') }}"         alt="Visa">
                    </div>
                </div>

                <a href="{{ route('apply.now') }}"
                   class="btn btn-primary w-100 mt-4">
                    <i class="fas fa-paper-plane me-2"></i>Apply Now
                </a>
            </div>

            {{-- Course Outline --}}
            <div class="details-card">
                <h2>Course Outline (Weekly)</h2>

                <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Week</th>
                            <th>Topics</th>
                        </tr>
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
