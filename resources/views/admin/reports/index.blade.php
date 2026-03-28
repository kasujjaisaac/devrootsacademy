@extends('layouts.admin')
@section('title', 'Reports')

@push('styles')
<style>
    .ad-report-stack {
        display: grid;
        gap: 20px;
    }

    .ad-report-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(280px, 0.8fr);
        gap: 20px;
    }

    .ad-report-banner {
        background: linear-gradient(135deg, #7f1d1d 0%, #b91c1c 58%, #ef4444 100%);
        color: #fff;
        border-radius: var(--ad-radius);
        box-shadow: 0 18px 45px rgba(185, 28, 28, 0.22);
        padding: 24px 26px;
    }

    .ad-report-banner h1 {
        margin: 0 0 8px;
        font-size: 1.5rem;
    }

    .ad-report-banner p {
        margin: 0;
        line-height: 1.7;
        color: rgba(255,255,255,0.86);
        max-width: 60ch;
    }

    .ad-report-spotlight {
        background: var(--ad-card-bg);
        border: 1px solid var(--ad-border);
        border-radius: var(--ad-radius);
        box-shadow: var(--ad-shadow);
        padding: 24px;
    }

    .ad-report-spotlight-label {
        color: var(--ad-muted);
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .ad-report-spotlight-value {
        color: var(--ad-text);
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 10px;
    }

    .ad-report-spotlight p {
        margin: 0;
        color: var(--ad-muted);
        line-height: 1.7;
    }

    .ad-report-kpis {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .ad-report-kpi {
        background: var(--ad-card-bg);
        border: 1px solid var(--ad-border);
        border-radius: var(--ad-radius);
        box-shadow: var(--ad-shadow);
        padding: 18px 20px;
    }

    .ad-report-kpi-label {
        color: var(--ad-muted);
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .ad-report-kpi-value {
        color: var(--ad-text);
        font-size: 1.6rem;
        font-weight: 700;
        line-height: 1.05;
    }

    .ad-report-kpi-note {
        margin-top: 8px;
        color: var(--ad-muted);
        font-size: 0.8rem;
    }

    .ad-report-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .ad-report-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    .ad-report-card {
        background: var(--ad-card-bg);
        border: 1px solid var(--ad-border);
        border-radius: var(--ad-radius);
        box-shadow: var(--ad-shadow);
        overflow: hidden;
    }

    .ad-report-card-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        padding: 18px 20px;
        border-bottom: 1px solid var(--ad-border);
    }

    .ad-report-card-head h3 {
        margin: 0 0 4px;
        font-size: 1rem;
    }

    .ad-report-card-head p {
        margin: 0;
        color: var(--ad-muted);
        font-size: 0.82rem;
    }

    .ad-report-card-body {
        padding: 20px;
    }

    .ad-report-canvas {
        position: relative;
        height: 320px;
    }

    .ad-report-canvas.sm {
        height: 260px;
    }

    @media (max-width: 1200px) {
        .ad-report-kpis {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .ad-report-grid-3 {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 991px) {
        .ad-report-hero,
        .ad-report-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .ad-report-kpis {
            grid-template-columns: 1fr;
        }

        .ad-report-canvas,
        .ad-report-canvas.sm {
            height: 240px;
        }
    }
</style>
@endpush

@section('content')
<div class="ad-report-stack">
    <div class="ad-report-hero">
        <div class="ad-report-banner">
            <h1>Reports Dashboard</h1>
            <p>Track revenue, enrollment growth, course demand, and application pipelines in one place with visual reports for {{ $year }}.</p>
        </div>

        <div class="ad-report-spotlight">
            <div class="ad-report-spotlight-label">Completed Revenue</div>
            <div class="ad-report-spotlight-value">UGX {{ number_format($completedRevenue) }}</div>
            <p>Average monthly completed revenue for {{ $year }} is UGX {{ number_format($monthlyRevenueAverage) }}.</p>
        </div>
    </div>

    <div class="ad-report-kpis">
        <div class="ad-report-kpi">
            <div class="ad-report-kpi-label">Students</div>
            <div class="ad-report-kpi-value">{{ number_format($totalStudents) }}</div>
            <div class="ad-report-kpi-note">{{ number_format($activeEnrollments) }} active enrollments</div>
        </div>
        <div class="ad-report-kpi">
            <div class="ad-report-kpi-label">Instructors</div>
            <div class="ad-report-kpi-value">{{ number_format($totalInstructors) }}</div>
            <div class="ad-report-kpi-note">{{ number_format($totalCourses) }} courses currently tracked</div>
        </div>
        <div class="ad-report-kpi">
            <div class="ad-report-kpi-label">Recorded Payments</div>
            <div class="ad-report-kpi-value">UGX {{ number_format($totalPayments) }}</div>
            <div class="ad-report-kpi-note">All payment records to date</div>
        </div>
        <div class="ad-report-kpi">
            <div class="ad-report-kpi-label">Pending Student Apps</div>
            <div class="ad-report-kpi-value">{{ number_format($pendingApplications) }}</div>
            <div class="ad-report-kpi-note">Submitted and waiting for action</div>
        </div>
    </div>

    <div class="ad-report-grid-2">
        <div class="ad-report-card">
            <div class="ad-report-card-head">
                <div>
                    <h3>Enrollment and Revenue Trend</h3>
                    <p>Year-to-date volume and cash flow by month</p>
                </div>
            </div>
            <div class="ad-report-card-body">
                <div class="ad-report-canvas">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>

        <div class="ad-report-card">
            <div class="ad-report-card-head">
                <div>
                    <h3>Top Courses by Enrollment</h3>
                    <p>Which programs are attracting the most learners</p>
                </div>
            </div>
            <div class="ad-report-card-body">
                <div class="ad-report-canvas">
                    <canvas id="courseChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="ad-report-grid-3">
        <div class="ad-report-card">
            <div class="ad-report-card-head">
                <div>
                    <h3>Enrollment Status Mix</h3>
                    <p>Current distribution across lifecycle stages</p>
                </div>
            </div>
            <div class="ad-report-card-body">
                <div class="ad-report-canvas sm">
                    <canvas id="enrollmentStatusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="ad-report-card">
            <div class="ad-report-card-head">
                <div>
                    <h3>Payment Status Mix</h3>
                    <p>Operational view of payment outcomes</p>
                </div>
            </div>
            <div class="ad-report-card-body">
                <div class="ad-report-canvas sm">
                    <canvas id="paymentStatusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="ad-report-card">
            <div class="ad-report-card-head">
                <div>
                    <h3>Recent Enrollments</h3>
                    <p>Latest learner-course activity</p>
                </div>
            </div>
            <div class="ad-card-body-p0">
                <div class="ad-table-wrap">
                    <table class="ad-table">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEnrollments as $enrollment)
                                <tr>
                                    <td>{{ $enrollment->student->full_name ?? $enrollment->student->first_name ?? 'N/A' }}</td>
                                    <td>{{ $enrollment->course->title ?? 'N/A' }}</td>
                                    <td>{{ $enrollment->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="ad-table-empty">No enrollments yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="ad-report-grid-2">
        <div class="ad-report-card">
            <div class="ad-report-card-head">
                <div>
                    <h3>Student Application Pipeline</h3>
                    <p>How student applications are moving through review</p>
                </div>
            </div>
            <div class="ad-report-card-body">
                <div class="ad-report-canvas sm">
                    <canvas id="studentApplicationChart"></canvas>
                </div>
            </div>
        </div>

        <div class="ad-report-card">
            <div class="ad-report-card-head">
                <div>
                    <h3>Instructor Application Pipeline</h3>
                    <p>Visibility into onboarding progress for instructors</p>
                </div>
            </div>
            <div class="ad-report-card-body">
                <div class="ad-report-canvas sm">
                    <canvas id="instructorApplicationChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(() => {
    const baseGrid = 'rgba(148, 163, 184, 0.16)';
    const tickColor = '#64748b';

    const trendCtx = document.getElementById('trendChart');
    if (trendCtx) {
        new Chart(trendCtx, {
            data: {
                labels: @json($months),
                datasets: [
                    {
                        type: 'bar',
                        label: 'Revenue (UGX)',
                        data: @json($paymentsPerMonth),
                        backgroundColor: 'rgba(217, 119, 6, 0.75)',
                        borderRadius: 8,
                        yAxisID: 'yRevenue',
                    },
                    {
                        type: 'line',
                        label: 'Enrollments',
                        data: @json($enrollmentsPerMonth),
                        borderColor: '#c62828',
                        backgroundColor: 'rgba(198, 40, 40, 0.10)',
                        tension: 0.35,
                        fill: true,
                        pointRadius: 4,
                        pointBackgroundColor: '#c62828',
                        yAxisID: 'yEnrollments',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                scales: {
                    x: { grid: { color: baseGrid }, ticks: { color: tickColor } },
                    yEnrollments: {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,
                        grid: { color: baseGrid },
                        ticks: { color: tickColor, precision: 0 }
                    },
                    yRevenue: {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                        grid: { drawOnChartArea: false },
                        ticks: { color: tickColor }
                    }
                }
            }
        });
    }

    const courseCtx = document.getElementById('courseChart');
    if (courseCtx) {
        new Chart(courseCtx, {
            type: 'bar',
            data: {
                labels: @json($topCourseLabels),
                datasets: [{
                    label: 'Enrollments',
                    data: @json($topCourseData),
                    backgroundColor: [
                        '#c62828',
                        '#dc2626',
                        '#ef4444',
                        '#f97316',
                        '#f59e0b',
                        '#fb7185'
                    ],
                    borderRadius: 10
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, grid: { color: baseGrid }, ticks: { color: tickColor, precision: 0 } },
                    y: { grid: { display: false }, ticks: { color: tickColor } }
                }
            }
        });
    }

    const makeDoughnut = (id, labels, data, colors) => {
        const ctx = document.getElementById(id);
        if (!ctx) return;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data,
                    backgroundColor: colors,
                    borderWidth: 0,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 10,
                        }
                    }
                },
                cutout: '64%',
            }
        });
    };

    makeDoughnut(
        'enrollmentStatusChart',
        @json($enrollmentStatusLabels),
        @json($enrollmentStatusData),
        ['#f59e0b', '#2563eb', '#16a34a', '#6b7280']
    );

    makeDoughnut(
        'paymentStatusChart',
        @json($paymentStatusLabels),
        @json($paymentStatusData),
        ['#f59e0b', '#16a34a', '#dc2626', '#6b7280', '#7c3aed']
    );

    const makePipelineChart = (id, labels, data, color) => {
        const ctx = document.getElementById(id);
        if (!ctx) return;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Count',
                    data,
                    backgroundColor: color,
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: tickColor } },
                    y: { beginAtZero: true, grid: { color: baseGrid }, ticks: { color: tickColor, precision: 0 } }
                }
            }
        });
    };

    makePipelineChart(
        'studentApplicationChart',
        @json($studentApplicationLabels),
        @json($studentApplicationData),
        'rgba(198, 40, 40, 0.78)'
    );

    makePipelineChart(
        'instructorApplicationChart',
        @json($instructorApplicationLabels),
        @json($instructorApplicationData),
        'rgba(37, 99, 235, 0.75)'
    );
})();
</script>
@endpush
