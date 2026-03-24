<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Portal') | DevRoots Academy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --sp-bg: #f8fafc;
            --sp-surface: #ffffff;
            --sp-text: #0f172a;
            --sp-muted: #64748b;
            --sp-border: #e2e8f0;
            --sp-primary: #0f766e;
            --sp-primary-soft: #ccfbf1;
            --sp-accent: #ea580c;
            --sp-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(180deg, #f8fafc 0%, #fff7ed 100%);
            color: var(--sp-text);
        }
        a { color: inherit; text-decoration: none; }
        .sp-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 280px 1fr;
        }
        .sp-sidebar {
            background: #0f172a;
            color: #e2e8f0;
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            gap: 22px;
        }
        .sp-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-size: 1rem;
        }
        .sp-brand img { height: 34px; width: auto; }
        .sp-user {
            padding: 18px;
            border-radius: 18px;
            background: rgba(255,255,255,0.06);
        }
        .sp-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sp-primary), var(--sp-accent));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 12px;
        }
        .sp-user-name { font-weight: 600; }
        .sp-user-sub { font-size: 0.8rem; color: #94a3b8; margin-top: 4px; }
        .sp-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .sp-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 12px;
            color: #cbd5e1;
            transition: background .2s ease, color .2s ease;
        }
        .sp-nav a.active,
        .sp-nav a:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .sp-main {
            padding: 28px;
        }
        .sp-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 20px;
        }
        .sp-topbar h1 {
            margin: 0;
            font-size: 1.75rem;
        }
        .sp-topbar p {
            margin: 4px 0 0;
            color: var(--sp-muted);
        }
        .sp-top-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sp-btn,
        .sp-top-actions button {
            border: 1px solid var(--sp-border);
            background: #fff;
            color: var(--sp-text);
            border-radius: 12px;
            padding: 10px 14px;
            font-family: inherit;
            font-size: 0.9rem;
            cursor: pointer;
        }
        .sp-btn-primary {
            background: var(--sp-primary);
            border-color: var(--sp-primary);
            color: #fff;
        }
        .sp-grid {
            display: grid;
            gap: 20px;
        }
        .sp-grid-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        .sp-grid-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .sp-card {
            background: var(--sp-surface);
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 20px;
            box-shadow: var(--sp-shadow);
            padding: 22px;
        }
        .sp-card h3 {
            margin: 0 0 14px;
            font-size: 1rem;
        }
        .sp-stat-num {
            font-size: 1.9rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .sp-muted { color: var(--sp-muted); }
        .sp-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 0.75rem;
            font-weight: 600;
            background: var(--sp-primary-soft);
            color: var(--sp-primary);
        }
        .sp-table {
            width: 100%;
            border-collapse: collapse;
        }
        .sp-table th,
        .sp-table td {
            text-align: left;
            padding: 12px 0;
            border-bottom: 1px solid var(--sp-border);
            font-size: 0.88rem;
        }
        .sp-table th { color: var(--sp-muted); font-weight: 600; }
        .sp-empty {
            padding: 28px 0;
            text-align: center;
            color: var(--sp-muted);
        }
        .sp-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .sp-list-item {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--sp-border);
        }
        .sp-list-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        @media (max-width: 1100px) {
            .sp-shell { grid-template-columns: 1fr; }
            .sp-sidebar { padding-bottom: 12px; }
            .sp-grid-3, .sp-grid-2 { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sp-shell">
        <aside class="sp-sidebar">
            <a href="{{ route('student.dashboard') }}" class="sp-brand">
                <img src="{{ asset('images/logo-horizontal.png') }}" alt="DevRoots Academy">
                <span>Student Portal</span>
            </a>

            <div class="sp-user">
                <div class="sp-avatar">{{ strtoupper(substr($student->full_name ?? auth()->user()->name ?? 'S', 0, 2)) }}</div>
                <div class="sp-user-name">{{ $student->full_name ?? auth()->user()->name }}</div>
                <div class="sp-user-sub">{{ $student->course_interest ?? 'Student account' }}</div>
            </div>

            <nav class="sp-nav">
                <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}"><i class="fas fa-gauge-high"></i> Dashboard</a>
                <a href="{{ route('student.profile') }}" class="{{ request()->routeIs('student.profile') ? 'active' : '' }}"><i class="fas fa-id-card"></i> Profile</a>
                <a href="{{ route('student.payments') }}" class="{{ request()->routeIs('student.payments') ? 'active' : '' }}"><i class="fas fa-credit-card"></i> Payments</a>
                <a href="{{ route('student.calendar') }}" class="{{ request()->routeIs('student.calendar') ? 'active' : '' }}"><i class="fas fa-calendar-days"></i> Calendar</a>
                <a href="{{ route('user.chat.index') }}" class="{{ request()->routeIs('user.chat.*') ? 'active' : '' }}"><i class="fas fa-comments"></i> Messages</a>
            </nav>
        </aside>

        <main class="sp-main">
            <div class="sp-topbar">
                <div>
                    <h1>@yield('page_title', 'Student Dashboard')</h1>
                    <p>@yield('page_subtitle', 'Manage your academic journey in one place.')</p>
                </div>
                <div class="sp-top-actions">
                    <a href="{{ route('home') }}" class="sp-btn">Public Site</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="sp-card" style="margin-bottom:20px;border-color:#bbf7d0;background:#f0fdf4;color:#166534;">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="sp-card" style="margin-bottom:20px;border-color:#fecaca;background:#fef2f2;color:#991b1b;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
