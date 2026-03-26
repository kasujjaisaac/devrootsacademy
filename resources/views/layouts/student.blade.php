<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Portal') — DevRoots Academy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .sp-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.3fr) minmax(320px, 0.7fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        .sp-hero-card {
            background: linear-gradient(135deg, #7f1d1d 0%, #b91c1c 58%, #ef4444 100%);
            color: #fff;
            border: none;
            box-shadow: 0 18px 45px rgba(185, 28, 28, 0.22);
        }
        .sp-hero-card h2 {
            margin: 0 0 8px;
            font-size: 1.75rem;
            line-height: 1.2;
        }
        .sp-hero-card p {
            margin: 0;
            max-width: 52ch;
            color: rgba(255,255,255,0.8);
            line-height: 1.7;
        }
        .sp-hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 18px;
        }
        .sp-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255,255,255,0.1);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .sp-quick-card .sp-quick-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--ad-muted);
            margin-bottom: 10px;
        }
        .sp-quick-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .sp-quick-item {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--ad-border);
        }
        .sp-quick-item:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }
        .sp-grid {
            display: grid;
            gap: 20px;
        }
        .sp-card {
            background: var(--ad-card-bg);
            border: 1px solid var(--ad-border);
            box-shadow: var(--ad-shadow);
            padding: 22px;
        }
        .sp-grid-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        .sp-grid-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .sp-stat-num {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--ad-text);
        }
        .sp-stat-note {
            margin-top: 10px;
            color: var(--ad-muted);
            font-size: 0.75rem;
        }
        .sp-card-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }
        .sp-card-title h3 {
            margin: 0;
            font-size: 1rem;
        }
        .sp-table {
            width: 100%;
            border-collapse: collapse;
        }
        .sp-table th,
        .sp-table td {
            text-align: left;
            padding: 12px 0;
            border-bottom: 1px solid var(--ad-border);
            font-size: 0.85rem;
        }
        .sp-table th {
            color: var(--ad-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.72rem;
        }
        .sp-table tbody tr:last-child td {
            border-bottom: none;
        }
        .sp-empty {
            padding: 20px 0;
            color: var(--ad-muted);
            text-align: center;
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
            border-bottom: 1px solid var(--ad-border);
        }
        .sp-list-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .sp-muted {
            color: var(--ad-muted);
        }
        .sp-section-gap {
            margin-top: 20px;
        }
        .sp-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
            background: #fef2f2;
            color: var(--ad-primary);
            border: 1px solid #fecaca;
        }
        @media (max-width: 1100px) {
            .sp-hero,
            .sp-grid-3,
            .sp-grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="ad-overlay" id="adOverlay"></div>

<div class="ad-wrapper">
    <aside class="ad-sidebar" id="adSidebar">
        <a href="{{ route('student.dashboard') }}" class="ad-sidebar-brand">
            <img src="{{ asset('images/logo-horizontal.png') }}" alt="DevRoots Academy"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <span class="ad-sidebar-brand-text" style="display:none">
                DevRoots
                <small>Student Portal</small>
            </span>
            <button class="ad-sidebar-close" id="adSidebarClose" type="button">
                <i class="fas fa-times"></i>
            </button>
        </a>

        <div class="ad-sidebar-user">
            <div class="ad-sidebar-avatar">
                {{ strtoupper(substr($student->full_name ?? auth()->user()->name ?? 'S', 0, 2)) }}
            </div>
            <div>
                <div class="ad-sidebar-uname">{{ $student->full_name ?? auth()->user()->name }}</div>
                <div class="ad-sidebar-role">Student</div>
            </div>
        </div>

        <nav class="ad-nav">
            <ul>
                <li class="ad-nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('student.dashboard') }}">
                        <i class="fas fa-gauge-high"></i> Dashboard
                    </a>
                </li>

                <li class="ad-nav-section">Academic</li>

                <li class="ad-nav-item {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                    <a href="{{ route('student.profile') }}">
                        <i class="fas fa-id-card"></i> Profile
                    </a>
                </li>

                <li class="ad-nav-item {{ request()->routeIs('student.calendar') ? 'active' : '' }}">
                    <a href="{{ route('student.calendar') }}">
                        <i class="fas fa-calendar-days"></i> Calendar
                    </a>
                </li>

                <li class="ad-nav-item {{ request()->routeIs('user.chat.*') ? 'active' : '' }}">
                    <a href="{{ route('user.chat.index') }}">
                        <i class="fas fa-comments"></i> Messages
                    </a>
                </li>

                <li class="ad-nav-section">Finance</li>

                <li class="ad-nav-item {{ request()->routeIs('student.payments') ? 'active' : '' }}">
                    <a href="{{ route('student.payments') }}">
                        <i class="fas fa-credit-card"></i> Payments
                    </a>
                </li>
            </ul>
        </nav>

        <div class="ad-sidebar-footer">
            <form method="POST" action="{{ route('logout') }}" style="width:100%">
                @csrf
                <button type="submit" style="background:none;border:none;width:100%;cursor:pointer;
                  display:flex;align-items:center;gap:10px;padding:9px 20px;
                  color:rgba(255,255,255,0.5);font-size:0.8125rem;font-family:'Poppins',sans-serif;
                  transition:color 0.15s;">
                    <i class="fas fa-right-from-bracket" style="width:18px;text-align:center;font-size:0.875rem;"></i>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="ad-main">
        <header class="ad-topbar">
            <div class="ad-topbar-left">
                <button class="ad-topbar-toggle" id="adSidebarToggle" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="ad-page-title">@yield('title', 'Student Dashboard')</span>
            </div>
            <div class="ad-topbar-right">
                <a href="{{ route('home') }}" class="ad-topbar-btn" target="_blank">
                    <i class="fas fa-arrow-up-right-from-square"></i>
                    <span>View Site</span>
                </a>

                <div class="ad-user-menu">
                    <div class="ad-user-trigger">
                        <div class="ad-user-avatar-sm">
                            {{ strtoupper(substr($student->full_name ?? auth()->user()->name ?? 'S', 0, 2)) }}
                        </div>
                        <span class="ad-user-name">{{ $student->student_number ?? 'Student Account' }}</span>
                        <i class="fas fa-chevron-down ad-user-caret"></i>
                    </div>
                    <div class="ad-user-dropdown">
                        <a href="{{ route('student.profile') }}">
                            <i class="fas fa-id-card"></i> Profile
                        </a>
                        <a href="{{ route('student.payments') }}">
                            <i class="fas fa-credit-card"></i> Payments
                        </a>
                        <hr>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="danger">
                                <i class="fas fa-right-from-bracket"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="ad-content">
            <div class="ad-page-hd">
                <div class="ad-page-hd-left">
                    <h1>@yield('page_title', 'Student Dashboard')</h1>
                    <nav class="ad-breadcrumb">
                        <a href="{{ route('student.dashboard') }}">Student Portal</a>
                        <i class="fas fa-chevron-right"></i>
                        <span>@yield('page_title', 'Student Dashboard')</span>
                    </nav>
                </div>
            </div>

            @if(session('success'))
                <div class="ad-alert ad-alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
                </div>
            @endif

            @if($errors->any())
                <div class="ad-alert ad-alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Please fix the following errors:</strong>
                        <ul class="ad-alert-list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="ad-alert-close" type="button"><i class="fas fa-times"></i></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
