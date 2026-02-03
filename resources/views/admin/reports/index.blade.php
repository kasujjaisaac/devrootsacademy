@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="space-y-6">

    <!-- ================= KPI CARDS ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="p-4 bg-blue-50 rounded shadow hover:shadow-lg transform hover:scale-105 transition">
            <h3 class="text-sm font-medium text-gray-500">Total Students</h3>
            <p class="mt-1 text-2xl font-bold text-blue-600">{{ $totalStudents ?? 0 }}</p>
        </div>

        <div class="p-4 bg-green-50 rounded shadow hover:shadow-lg transform hover:scale-105 transition">
            <h3 class="text-sm font-medium text-gray-500">Total Instructors</h3>
            <p class="mt-1 text-2xl font-bold text-green-600">{{ $totalInstructors ?? 0 }}</p>
        </div>

        <div class="p-4 bg-yellow-50 rounded shadow hover:shadow-lg transform hover:scale-105 transition">
            <h3 class="text-sm font-medium text-gray-500">Total Courses</h3>
            <p class="mt-1 text-2xl font-bold text-yellow-600">{{ $totalCourses ?? 0 }}</p>
        </div>

        <div class="p-4 bg-purple-50 rounded shadow hover:shadow-lg transform hover:scale-105 transition">
            <h3 class="text-sm font-medium text-gray-500">Total Payments</h3>
            <p class="mt-1 text-2xl font-bold text-purple-600">${{ $totalPayments ?? 0 }}</p>
        </div>
    </div>

    <!-- ================= REPORT CARDS ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="p-4 bg-blue-50 rounded shadow hover:shadow-lg transform hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-lg">Enrollment Report</h2>
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 17v-6h6v6M5 12h14"></path>
                </svg>
            </div>
            <p class="text-gray-600 mt-2">Overview of student enrollments per course.</p>
            <a href="{{ route('admin.enrollments.index') }}" class="mt-3 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">View Report</a>
        </div>

        <div class="p-4 bg-green-50 rounded shadow hover:shadow-lg transform hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-lg">Payments Report</h2>
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 8v8M8 12h8"></path>
                </svg>
            </div>
            <p class="text-gray-600 mt-2">Track payments made by students and instructors.</p>
            <a href="{{ route('admin.payments.index') }}" class="mt-3 inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">View Report</a>
        </div>

        <div class="p-4 bg-yellow-50 rounded shadow hover:shadow-lg transform hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-lg">Courses Report</h2>
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14M12 5v14"></path>
                </svg>
            </div>
            <p class="text-gray-600 mt-2">Analyze course activity, popularity, and enrollment numbers.</p>
            <a href="{{ route('admin.courses.index') }}" class="mt-3 inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">View Report</a>
        </div>
    </div>

    <!-- ================= CHARTS ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold mb-4">Monthly Enrollments</h2>
            <canvas id="enrollmentChart" class="w-full h-64"></canvas>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold mb-4">Monthly Payments</h2>
            <canvas id="paymentsChart" class="w-full h-64"></canvas>
        </div>
    </div>

    <!-- ================= RECENT ENROLLMENTS ================= -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Recent Enrollments</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Student</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Course</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentEnrollments as $enrollment)
                    <tr>
                        <td class="px-4 py-2">{{ $enrollment->student->name }}</td>
                        <td class="px-4 py-2">{{ $enrollment->course->title }}</td>
                        <td class="px-4 py-2">{{ $enrollment->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Enrollment Chart
    const ctxEnroll = document.getElementById('enrollmentChart').getContext('2d');
    new Chart(ctxEnroll, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Enrollments',
                data: @json($enrollmentsPerMonth),
                backgroundColor: 'rgba(59, 130, 246, 0.6)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // Payments Chart
    const ctxPay = document.getElementById('paymentsChart').getContext('2d');
    new Chart(ctxPay, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Payments',
                data: @json($paymentsPerMonth),
                fill: true,
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                borderColor: 'rgba(16, 185, 129, 1)',
                tension: 0.3
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
</script>
@endpush
@endsection
