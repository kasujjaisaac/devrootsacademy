{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="flex min-h-screen bg-gray-100">

  <!-- Sidebar -->
  <aside class="w-56 bg-white shadow-md flex flex-col">
    <div class="p-4 flex items-center space-x-2 border-b">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-7 h-7">
      <span class="font-bold text-blue-700 text-base">DevRoots</span>
    </div>
    <nav class="flex-1 p-3 space-y-1 text-sm">
      <a href="{{ route('admin.dashboard') }}" class="block py-1.5 px-2 rounded hover:bg-blue-100 text-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 font-semibold' : '' }}">Dashboard</a>
      <a href="{{ route('admin.students.index') }}" class="block py-1.5 px-2 rounded hover:bg-blue-100 text-gray-700 {{ request()->routeIs('admin.students.*') ? 'bg-blue-100 font-semibold' : '' }}">Students</a>
      <a href="{{ route('admin.courses.index') }}" class="block py-1.5 px-2 rounded hover:bg-blue-100 text-gray-700 {{ request()->routeIs('admin.courses.*') ? 'bg-blue-100 font-semibold' : '' }}">Courses</a>
      <a href="{{ route('admin.instructors.index') }}" class="block py-1.5 px-2 rounded hover:bg-blue-100 text-gray-700 {{ request()->routeIs('admin.instructors.*') ? 'bg-blue-100 font-semibold' : '' }}">Instructors</a>
      <a href="{{ route('admin.payments.index') }}" class="block py-1.5 px-2 rounded hover:bg-blue-100 text-gray-700 {{ request()->routeIs('admin.payments.*') ? 'bg-blue-100 font-semibold' : '' }}">Payments</a>
      <a href="{{ route('admin.reports.index') }}" class="block py-1.5 px-2 rounded hover:bg-blue-100 text-gray-700 {{ request()->routeIs('admin.reports.*') ? 'bg-blue-100 font-semibold' : '' }}">Reports</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <div class="flex-1 p-4">

    <!-- Top Bar -->
    <div class="flex justify-between items-center mb-4">
      <form action="{{ route('admin.search') }}" method="GET">
        <input type="text" name="query" placeholder="Search..." class="px-3 py-1.5 rounded shadow border focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
      </form>
      <div class="flex items-center space-x-3">
        <span class="text-gray-700 font-medium text-sm">Hello, {{ Auth::user()->name }}</span>
        <img src="{{ asset('images/avatar.png') }}" alt="Admin Avatar" class="w-7 h-7 rounded-full">
      </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-4 gap-2">
      <div class="bg-white p-3 rounded shadow hover:shadow-md transition-shadow text-xs">
        <p class="text-gray-500">Total Students</p>
        <p class="text-blue-600 font-bold text-lg">{{ $students }}</p>
      </div>
      <div class="bg-white p-3 rounded shadow hover:shadow-md transition-shadow text-xs">
        <p class="text-gray-500">Active Courses</p>
        <p class="text-blue-600 font-bold text-lg">{{ $courses }}</p>
      </div>
      <div class="bg-white p-3 rounded shadow hover:shadow-md transition-shadow text-xs">
        <p class="text-gray-500">Instructors</p>
        <p class="text-blue-600 font-bold text-lg">{{ $instructors }}</p>
      </div>
      <div class="bg-white p-3 rounded shadow hover:shadow-md transition-shadow text-xs">
        <p class="text-gray-500">Pending Payments</p>
        <p class="text-blue-600 font-bold text-lg">{{ $payments }}</p>
      </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-2 gap-2 mt-4">
      <!-- Line Chart -->
      <div class="bg-white p-3 rounded shadow">
        <p class="text-gray-700 font-medium text-sm mb-1">Student Enrollments</p>
        <canvas id="lineChart" class="h-40"></canvas>
      </div>
      <!-- Bar Chart -->
      <div class="bg-white p-3 rounded shadow">
        <p class="text-gray-700 font-medium text-sm mb-1">Payments Overview</p>
        <canvas id="barChart" class="h-40"></canvas>
      </div>
    </div>

  </div>
</div>

<!-- Chart.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const lineCtx = document.getElementById('lineChart').getContext('2d');
const lineChart = new Chart(lineCtx, {
    type: 'line',
    data: {
        labels: @json($enrollmentMonths),
        datasets: [{
            label: 'Enrollments',
            data: @json($enrollmentCounts),
            borderColor: 'rgba(59, 130, 246, 1)',
            backgroundColor: 'rgba(59, 130, 246, 0.2)',
            fill: true,
            tension: 0.3
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, maintainAspectRatio: false }
});

const barCtx = document.getElementById('barChart').getContext('2d');
const barChart = new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: @json($paymentMonths),
        datasets: [{
            label: 'Payments',
            data: @json($paymentCounts),
            backgroundColor: 'rgba(59, 130, 246, 0.7)'
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, maintainAspectRatio: false }
});
</script>
@endsection
