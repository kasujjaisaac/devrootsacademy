@extends('layouts.frontend')

@section('title', $course->title . ' - DevRoots Academy')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/programming_fundamentals.css') }}">
@endpush

@section('content')

<!-- ================= HERO BANNER ================= -->
<header class="course-header">
    <h1>{{ $course->title }}</h1>
</header>

<!-- ================= MAIN CONTENT ================= -->
<main class="container">

    <!-- COURSE DESCRIPTION -->
    <section class="course-description">
        <p>
            {{ $course->description }}
        </p>
    </section>

    <!-- DETAILS GRID -->
    <section class="course-details">

        <!-- FEES CARD -->
        <div class="details-card">
            <h2>Fees Structure</h2>

            <table>
                <tr>
                    <th>Item</th>
                    <th>Amount (UGX)</th>
                </tr>
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
            </table>

            <!-- PAYMENTS -->
            <div class="payments-box">
                <span class="payments-legend">Payments are safe and secure</span>
                <div class="payments-logos">
                    <img src="{{ asset('images/mtn-momo.png') }}" alt="MTN Mobile Money">
                    <img src="{{ asset('images/airtel-money.png') }}" alt="Airtel Money">
                    <img src="{{ asset('images/visa.png') }}" alt="Visa">
                </div>
            </div>

            <!-- APPLY BUTTON -->
            <div class="apply-button-container">
                <a href="{{ route('apply.now') }}" class="apply-btn">Apply Now</a>
            </div>
        </div>

        <!-- COURSE OUTLINE -->
        <div class="details-card">
            <h2>Course Outline (Weekly)</h2>

            <table>
                <tr>
                    <th>Week</th>
                    <th>Topics</th>
                </tr>

                @forelse($course->outline ?? [] as $week => $topic)
                    <tr>
                        <td>{{ is_numeric($week) ? 'Week ' . ($week + 1) : $week }}</td>
                        <td>{{ $topic }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Course outline will be available soon.</td>
                    </tr>
                @endforelse
            </table>
        </div>

    </section>

</main>
@endsection
@push('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
@endpush
