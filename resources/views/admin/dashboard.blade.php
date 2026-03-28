@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- Page Header --}}
<div class="ad-page-hd">
    <div class="ad-page-hd-left">
        <h1>Dashboard</h1>
        <nav class="ad-breadcrumb">
            <i class="fas fa-chevron-right"></i>
            <span>Dashboard</span>
        </nav>
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

{{-- Stat Cards --}}
<div class="ad-stats-row">
    <div class="ad-stat-card">
        <div class="ad-stat-icon"><i class="fas fa-user-graduate"></i></div>
        <div>
            <div class="ad-stat-num">{{ number_format($students) }}</div>
            <div class="ad-stat-lbl">Total Students</div>
        </div>
    </div>
    <div class="ad-stat-card green">
        <div class="ad-stat-icon"><i class="fas fa-user-check"></i></div>
        <div>
            <div class="ad-stat-num">{{ number_format($activeStudents) }}</div>
            <div class="ad-stat-lbl">Active Students</div>
        </div>
    </div>
    <div class="ad-stat-card blue">
        <div class="ad-stat-icon"><i class="fas fa-book-open"></i></div>
        <div>
            <div class="ad-stat-num">{{ number_format($courses) }}</div>
            <div class="ad-stat-lbl">Total Courses</div>
        </div>
    </div>
    <div class="ad-stat-card purple">
        <div class="ad-stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div>
            <div class="ad-stat-num">{{ number_format($instructors) }}</div>
            <div class="ad-stat-lbl">Instructors</div>
        </div>
    </div>
    <div class="ad-stat-card orange">
        <div class="ad-stat-icon"><i class="fas fa-credit-card"></i></div>
        <div>
            <div class="ad-stat-num">{{ number_format($payments) }}</div>
            <div class="ad-stat-lbl">Payments</div>
        </div>
    </div>
</div>

@if($actionCards->isNotEmpty())
<div class="ad-card" style="margin-bottom:20px;">
    <div class="ad-card-head">
        <h3><i class="fas fa-bolt" style="color:var(--ad-primary);margin-right:6px;"></i> Action Needed</h3>
    </div>
    <div class="ad-card-body">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;">
            @foreach($actionCards as $card)
                <a href="{{ $card['route'] }}" style="display:block;padding:18px;border:1px solid var(--ad-border);border-radius:16px;background:#fff;text-decoration:none;color:inherit;transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease;">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px;">
                        <span style="width:40px;height:40px;border-radius:14px;background:rgba(198,40,40,0.08);color:#C62828;display:flex;align-items:center;justify-content:center;">
                            <i class="fas {{ $card['icon'] }}"></i>
                        </span>
                        <strong style="font-size:1.6rem;color:#14142b;">{{ number_format($card['count']) }}</strong>
                    </div>
                    <div style="font-weight:600;color:#14142b;margin-bottom:6px;">{{ $card['label'] }}</div>
                    <div style="font-size:0.88rem;color:var(--ad-muted);line-height:1.55;">{{ $card['description'] }}</div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Charts Row --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
    <div class="ad-card">
        <div class="ad-card-head">
            <h3><i class="fas fa-chart-line" style="color:var(--ad-primary);margin-right:6px;"></i> Monthly Enrollments</h3>
            <form method="GET" style="display:flex;align-items:center;gap:8px;margin:0;">
                <select name="course" class="ad-select" style="width:auto;padding:4px 8px;font-size:0.75rem;" onchange="this.form.submit()">
                    <option value="">All Courses</option>
                    @foreach($coursesList as $c)
                        <option value="{{ $c->id }}" {{ $selectedCourse == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="ad-card-body">
            <canvas id="enrollmentChart" height="200"></canvas>
        </div>
    </div>
    <div class="ad-card">
        <div class="ad-card-head">
            <h3><i class="fas fa-chart-bar" style="color:#d97706;margin-right:6px;"></i> Revenue Overview (UGX)</h3>
        </div>
        <div class="ad-card-body">
            <canvas id="revenueChart" height="200"></canvas>
        </div>
    </div>
</div>

{{-- Recent Enrollments & Top Courses --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

    {{-- Recent Enrollments --}}
    <div class="ad-card">
        <div class="ad-card-head">
            <h3><i class="fas fa-users" style="color:var(--ad-primary);margin-right:6px;"></i> Recent Enrollments</h3>
            <a href="{{ route('admin.students.index') }}" class="btn-ad btn-ad-outline btn-ad-sm">View All</a>
        </div>
        <div class="ad-table-wrap">
            <table class="ad-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentEnrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment['student_name'] ?? '-' }}</td>
                        <td>{{ $enrollment['course_title'] ?? '-' }}</td>
                        <td>
                            @php $es = $enrollment['status'] ?? 'pending'; @endphp
                            <span class="ad-badge
                                {{ $es === 'active' ? 'ad-badge-active' : ($es === 'finished' ? 'ad-badge-finished' : 'ad-badge-pending') }}">
                                {{ ucfirst($es) }}
                            </span>
                        </td>
                        <td>
                            @if($enrollment['created_at'])
                                {{ $enrollment['created_at']->format('M d, Y') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="ad-table-empty">
                            <i class="fas fa-inbox"></i>
                            No recent enrollments.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Top Courses --}}
    <div class="ad-card">
        <div class="ad-card-head">
            <h3><i class="fas fa-star" style="color:#d97706;margin-right:6px;"></i> Top Courses by Enrollment</h3>
            <a href="{{ route('admin.courses.index') }}" class="btn-ad btn-ad-outline btn-ad-sm">View All</a>
        </div>
        <div class="ad-table-wrap">
            <table class="ad-table">
                <thead>
                    <tr>
                        <th class="cell-sm">#</th>
                        <th>Course Title</th>
                        <th>Enrollments</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topCourses as $course)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $course->title }}</td>
                        <td>{{ number_format($course->enrollments_count) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="ad-table-empty">
                            <i class="fas fa-book-open"></i>
                            No courses found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    const enrollCtx = document.getElementById('enrollmentChart');
    if (enrollCtx) {
        new Chart(enrollCtx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Enrollments',
                    data: @json($monthlyEnrollments),
                    borderColor: '#C62828',
                    backgroundColor: 'rgba(198,40,40,0.08)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointBackgroundColor: '#C62828'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } } }
            }
        });
    }

    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Revenue (UGX)',
                    data: @json($revenueData),
                    backgroundColor: 'rgba(217,119,6,0.75)',
                    borderColor: '#d97706',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }
})();
</script>
@endpush
