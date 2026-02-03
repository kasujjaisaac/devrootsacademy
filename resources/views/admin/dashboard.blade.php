@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')

<!-- ================= WELCOME BANNER & NAV ================= -->
<div class="relative w-full mb-10">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-purple-50 opacity-80 -z-10"></div>
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 px-2 py-6 rounded-2xl shadow-sm">
        <div class="flex items-center gap-4">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=4f46e5&color=fff&size=64" alt="Avatar" class="w-16 h-16 rounded-full border-4 border-blue-200 shadow">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-blue-700 tracking-tight drop-shadow-sm">Welcome, {{ auth()->user()->name ?? 'Admin' }}!</h1>
                <p class="text-gray-600 mt-1 text-lg">Role: <span class="font-semibold text-blue-500">{{ auth()->user()->role ?? 'Administrator' }}</span></p>
                <p class="text-gray-400 text-base mt-1">{{ $totalStudents }} Students • {{ $totalCourses }} Courses • {{ $totalInstructors }} Instructors</p>
            </div>
        </div>
        <nav class="text-sm text-gray-400 bg-white/80 px-4 py-2 rounded-lg shadow-inner flex items-center gap-2">
            <i class="fas fa-home text-blue-400"></i> Home <span class="mx-1">/</span> Admin <span class="mx-1">/</span> <span class="text-blue-600 font-semibold">Dashboard</span>
        </nav>
        <button id="darkModeToggle" class="ml-4 px-3 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold shadow transition hidden md:block" aria-label="Toggle dark mode">
            <i class="fas fa-moon"></i> <span class="ml-1">Dark Mode</span>
        </button>
    </div>
</div>

<!-- ================= KPI STATS ================= -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
    @php
        $stats = [
            [
                'label' => 'Total Students',
                'value' => $totalStudents,
                'icon'  => 'fa-user-graduate',
                'bg'    => 'from-red-500 to-red-700',
                'link'  => route('admin.students.index')
            ],
            [
                'label' => 'Pending Students',
                'value' => $pendingStudents,
                'icon'  => 'fa-user-clock',
                'bg'    => 'from-red-400 to-red-600',
                'link'  => route('admin.students.index', ['status' => 'pending'])
            ],
            [
                'label' => 'Active Students',
                'value' => $activeStudents,
                'icon'  => 'fa-user-check',
                'bg'    => 'from-red-600 to-red-800',
                'link'  => route('admin.students.index', ['status' => 'active'])
            ],
            [
                'label' => 'Finished Students',
                'value' => $finishedStudents,
                'icon'  => 'fa-user-tie',
                'bg'    => 'from-red-700 to-red-900',
                'link'  => route('admin.students.index', ['status' => 'finished'])
            ],
            [
                'label' => 'Total Courses',
                'value' => $totalCourses,
                'icon'  => 'fa-book',
                'bg'    => 'from-red-500 to-red-700',
                'link'  => route('admin.courses.index')
            ],
            [
                'label' => 'Total Instructors',
                'value' => $totalInstructors,
                'icon'  => 'fa-chalkboard-teacher',
                'bg'    => 'from-red-600 to-red-800',
                'link'  => route('admin.instructors.index')
            ],
        ];
    @endphp
    @php
        $iconColors = [
            'fa-user-graduate' => 'text-blue-500',
            'fa-user-clock' => 'text-yellow-500',
            'fa-user-check' => 'text-green-500',
            'fa-user-tie' => 'text-purple-500',
            'fa-book' => 'text-indigo-500',
            'fa-chalkboard-teacher' => 'text-pink-500',
        ];
        $trendIcons = [
            'up' => 'fa-arrow-up text-green-500',
            'down' => 'fa-arrow-down text-red-500',
            'flat' => 'fa-minus text-gray-400',
        ];
        // Example trends, replace with real data if available
        $trends = [10, -5, 0, 3, 7, -2];
    @endphp
        @foreach ($stats as $i => $stat)
            <a href="{{ $stat['link'] }}" class="group" aria-label="{{ $stat['label'] }}">
                <div class="relative flex items-center gap-4 bg-white rounded-xl shadow-md border border-blue-100 px-6 py-5 hover:shadow-lg transition-all focus-within:ring-2 focus-within:ring-blue-300" tabindex="0">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full {{ $iconBg[$stat['icon']] ?? 'bg-blue-100 text-blue-600' }} shadow">
                        <i class="fas {{ $stat['icon'] }} text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="text-2xl font-extrabold text-blue-900 leading-tight">{{ number_format($stat['value']) }}</div>
                        <div class="text-xs font-semibold text-blue-500 uppercase tracking-wider mt-1">{{ $stat['label'] }}</div>
                    </div>
                </div>
            </a>
        @endforeach
</div>

<!-- ================= QUICK ACTIONS ================= -->
<div class="mt-10 bg-white rounded-2xl shadow-lg p-8">
    <h3 class="font-bold text-xl mb-6 text-blue-700 flex items-center gap-2"><i class="fas fa-bolt"></i> Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <a href="{{ route('admin.courses.create') }}" class="dashboard-action flex flex-col items-center justify-center gap-2 py-6 rounded-xl bg-blue-50 text-blue-700 font-semibold shadow hover:bg-blue-100 transition" aria-label="Add Course">
            <i class="fas fa-plus text-2xl"></i> Add Course
        </a>
        <a href="{{ route('admin.courses.index') }}" class="dashboard-action flex flex-col items-center justify-center gap-2 py-6 rounded-xl bg-purple-50 text-purple-700 font-semibold shadow hover:bg-purple-100 transition" aria-label="Manage Courses">
            <i class="fas fa-book text-2xl"></i> Manage Courses
        </a>
        <a href="{{ route('admin.students.index') }}" class="dashboard-action flex flex-col items-center justify-center gap-2 py-6 rounded-xl bg-green-50 text-green-700 font-semibold shadow hover:bg-green-100 transition" aria-label="Manage Students">
            <i class="fas fa-user-graduate text-2xl"></i> Manage Students
        </a>
        <a href="{{ route('admin.payments.index') }}" class="dashboard-action flex flex-col items-center justify-center gap-2 py-6 rounded-xl bg-yellow-50 text-yellow-700 font-semibold shadow hover:bg-yellow-100 transition" aria-label="Payments">
            <i class="fas fa-dollar-sign text-2xl"></i> Payments
        </a>
    </div>
</div>

<!-- ================= CHARTS ================= -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-12">
    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <h3 class="font-bold mb-6 text-lg text-blue-700 flex items-center gap-2"><i class="fas fa-chart-pie"></i> Student Status Distribution</h3>
        <canvas id="studentsChart" class="rounded-xl shadow-sm bg-blue-50"></canvas>
    </div>
    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <div class="flex flex-col md:flex-row justify-between mb-6 items-center gap-4">
            <h3 class="font-bold mb-0 text-lg text-purple-700 flex items-center gap-2"><i class="fas fa-chart-line"></i> Monthly Enrollments</h3>
            <form method="GET" class="flex items-center gap-2">
                <label for="course" class="text-sm text-gray-500">Filter by Course:</label>
                <select name="course" id="course" onchange="this.form.submit()" class="border rounded px-2 py-1">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ ($selectedCourse == $course->id) ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <canvas id="enrollmentChart" class="rounded-xl shadow-sm bg-purple-50"></canvas>
    </div>
</div>

<!-- ================= ADDITIONAL INSIGHTS ================= -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-12">
    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <h3 class="font-bold mb-6 text-lg text-yellow-700 flex items-center gap-2"><i class="fas fa-star"></i> Top Courses by Enrollment</h3>
        <canvas id="topCoursesChart" class="rounded-xl shadow-sm bg-yellow-50"></canvas>
    </div>
    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <h3 class="font-bold mb-6 text-lg text-green-700 flex items-center gap-2"><i class="fas fa-coins"></i> Revenue Overview</h3>
        <canvas id="revenueChart" class="rounded-xl shadow-sm bg-green-50"></canvas>
    </div>
</div>

<!-- ================= RECENT ENROLLMENTS & ACTIVITY FEED ================= -->
<div class="mt-12 grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="bg-white rounded-2xl shadow-lg p-8 lg:col-span-2">
        <h3 class="font-bold text-xl mb-6 text-blue-700 flex items-center gap-2"><i class="fas fa-users"></i> Recent Enrollments</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b-2 border-blue-100">
                    <tr class="text-left text-gray-500">
                        <th class="py-2">Student</th>
                        <th>Course</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentEnrollments as $enrollment)
                        <tr class="border-b hover:bg-blue-50/60 transition">
                            <td class="py-2 flex items-center gap-2">
                                <img src="{{ $enrollment->student_avatar ?? 'https://via.placeholder.com/30' }}" alt="Avatar" class="w-7 h-7 rounded-full border border-blue-200 shadow-sm">
                                <span class="font-semibold text-gray-700">{{ $enrollment->student_name }}</span>
                            </td>
                            <td class="font-medium text-gray-600">{{ $enrollment->course_title }}</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'active' => 'bg-green-100 text-green-800',
                                        'finished' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColors[$enrollment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($enrollment->status) }}
                                </span>
                            </td>
                            <td class="text-gray-500">{{ $enrollment->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-400 py-8">
                                <img src="https://www.svgrepo.com/show/489434/empty-box.svg" alt="No data" class="mx-auto mb-2 w-16 h-16 opacity-60">
                                <div>No recent enrollments<br><a href="{{ route('admin.students.create') }}" class="text-blue-500 underline">Add a new student</a></div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Activity Feed -->
    <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col">
        <h3 class="font-bold text-xl mb-6 text-purple-700 flex items-center gap-2"><i class="fas fa-history"></i> Recent Activity</h3>
        <ul class="flex-1 space-y-4 overflow-y-auto max-h-96">
            <li class="flex items-center gap-3 text-gray-500"><i class="fas fa-sign-in-alt text-blue-400"></i> Admin logged in <span class="ml-auto text-xs text-gray-400">1 min ago</span></li>
            <li class="flex items-center gap-3 text-gray-500"><i class="fas fa-user-plus text-green-400"></i> New student registered <span class="ml-auto text-xs text-gray-400">5 min ago</span></li>
            <li class="flex items-center gap-3 text-gray-500"><i class="fas fa-book-open text-indigo-400"></i> Course updated <span class="ml-auto text-xs text-gray-400">10 min ago</span></li>
            <li class="flex items-center gap-3 text-gray-500"><i class="fas fa-dollar-sign text-yellow-400"></i> Payment received <span class="ml-auto text-xs text-gray-400">20 min ago</span></li>
            <!-- Add dynamic activity items here -->
        </ul>
        <div class="mt-6 flex items-center gap-2">
            <i class="fas fa-bell text-blue-500"></i>
            <span class="font-semibold text-blue-700">Notifications</span>
            <span class="ml-auto bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-bold">2 new</span>
        </div>
    </div>
</div>

@endsection



<!-- Floating Chat Widget Button -->
<button id="adminChatWidgetBtn" class="fixed z-50 bottom-8 right-8 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg p-4 flex items-center gap-2 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-300" aria-label="Open admin chat">
    <i class="fas fa-comments text-2xl"></i>
    <span class="hidden md:inline font-semibold">Admin Chat</span>
</button>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    /* Dashboard custom styles for smooth, modern look */
    body { background: linear-gradient(120deg, #f8fafc 0%, #f3e8ff 100%) !important; }
    .dashboard-action {
        box-shadow: 0 2px 8px 0 rgba(59,130,246,0.04);
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .dashboard-action:hover {
        transform: translateY(-2px) scale(1.04);
        box-shadow: 0 6px 24px 0 rgba(59,130,246,0.10);
    }
    #adminChatWidgetBtn {
        box-shadow: 0 4px 24px 0 rgba(59,130,246,0.15);
    }
    /* Micro-animations */
    .rounded-2xl, .rounded-xl, .shadow-lg, .shadow, .dashboard-action, .bg-white, .p-7, .p-8 {
        transition: box-shadow 0.2s, background 0.2s, border 0.2s, color 0.2s, transform 0.2s;
    }
    /* Accessibility: focus ring */
    a:focus, button:focus, .dashboard-action:focus {
        outline: none;
        box-shadow: 0 0 0 3px #3b82f6;
    }
    /* Responsive tweaks */
    @media (max-width: 768px) {
        .p-7, .p-8 { padding: 1.25rem !important; }
        .rounded-2xl { border-radius: 1rem !important; }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/dashboard.js') }}"></script>
<script>
    // Floating chat widget
    document.getElementById('adminChatWidgetBtn').addEventListener('click', function() {
        window.location.href = "{{ route('admin.chats.index') }}";
    });
    // Dark mode toggle
    document.getElementById('darkModeToggle')?.addEventListener('click', function() {
        document.body.classList.toggle('dark');
        if(document.body.classList.contains('dark')) {
            document.body.style.background = 'linear-gradient(120deg, #18181b 0%, #312e81 100%)';
            document.body.style.color = '#f3f4f6';
        } else {
            document.body.style.background = 'linear-gradient(120deg, #f8fafc 0%, #f3e8ff 100%)';
            document.body.style.color = '';
        }
    });
</script>
@endpush
