{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin') — DevRoots Academy</title>

  {{-- Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  {{-- Icons --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  {{-- Admin CSS --}}
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

  @stack('styles')
</head>
<body>

{{-- Mobile overlay --}}
<div class="ad-overlay" id="adOverlay"></div>

<div class="ad-wrapper">

  {{-- ====================== SIDEBAR ====================== --}}
  <aside class="ad-sidebar" id="adSidebar">

    {{-- Brand --}}
    <a href="{{ route('admin.dashboard') }}" class="ad-sidebar-brand">
      <img src="{{ asset('images/logo-horizontal.png') }}" alt="DevRoots Academy"
           onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
      <span class="ad-sidebar-brand-text" style="display:none">
        DevRoots
        <small>Academy</small>
      </span>
      <button class="ad-sidebar-close" id="adSidebarClose" type="button">
        <i class="fas fa-times"></i>
      </button>
    </a>

    {{-- Logged-in user --}}
    @auth
    <div class="ad-sidebar-user">
      <div class="ad-sidebar-avatar">
        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
      </div>
      <div>
        <div class="ad-sidebar-uname">{{ Auth::user()->name ?? 'Admin' }}</div>
        <div class="ad-sidebar-role">Administrator</div>
      </div>
    </div>
    @endauth

    {{-- Navigation --}}
    <nav class="ad-nav">
      <ul>
        <li class="ad-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <a href="{{ route('admin.dashboard') }}">
            <i class="fas fa-gauge-high"></i> Dashboard
          </a>
        </li>

        <li class="ad-nav-section">Academic</li>

        <li class="ad-nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
          <a href="{{ route('admin.students.index') }}">
            <i class="fas fa-user-graduate"></i> Students
          </a>
        </li>

        <li class="ad-nav-item {{ request()->routeIs('admin.student-applications.*') ? 'active' : '' }}">
          <a href="{{ route('admin.student-applications.index') }}">
            <i class="fas fa-file-signature"></i> Applications
          </a>
        </li>

        <li class="ad-nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
          <a href="{{ route('admin.courses.index') }}">
            <i class="fas fa-book-open"></i> Courses
          </a>
        </li>

        <li class="ad-nav-item {{ request()->routeIs('admin.timetables.*') ? 'active' : '' }}">
          <a href="{{ route('admin.timetables.index') }}">
            <i class="fas fa-calendar-days"></i> Timetables
          </a>
        </li>

        <li class="ad-nav-item {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
          <a href="{{ route('admin.partners.index') }}">
            <i class="fas fa-handshake"></i> Partners
          </a>
        </li>

        <li class="ad-nav-item {{ request()->routeIs('admin.instructors.*') ? 'active' : '' }}">
          <a href="{{ route('admin.instructors.index') }}">
            <i class="fas fa-chalkboard-teacher"></i> Instructors
          </a>
        </li>

        <li class="ad-nav-item {{ request()->routeIs('admin.instructor-applications.*') ? 'active' : '' }}">
          <a href="{{ route('admin.instructor-applications.index') }}">
            <i class="fas fa-user-check"></i> Instructor Apps
          </a>
        </li>

        <li class="ad-nav-item {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}">
          <a href="{{ route('admin.enrollments.index') }}">
            <i class="fas fa-layer-group"></i> Enrollments
          </a>
        </li>

        <li class="ad-nav-section">Finance</li>

        <li class="ad-nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
          <a href="{{ route('admin.payments.index') }}">
            <i class="fas fa-credit-card"></i> Payments
          </a>
        </li>

        <li class="ad-nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
          <a href="{{ route('admin.reports.index') }}">
            <i class="fas fa-chart-bar"></i> Reports
          </a>
        </li>

        <li class="ad-nav-section">System</li>

        <li class="ad-nav-item {{ request()->routeIs('admin.chats.*') ? 'active' : '' }}">
          <a href="{{ route('admin.chats.index') }}">
            <i class="fas fa-comments"></i> Messages
          </a>
        </li>

        <li class="ad-nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
          <a href="{{ route('admin.settings.index') }}">
            <i class="fas fa-gear"></i> Settings
          </a>
        </li>
      </ul>
    </nav>

    {{-- Logout --}}
    <div class="ad-sidebar-footer">
      <form method="POST" action="{{ route('admin.logout') }}" style="width:100%">
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
  {{-- ====================== / SIDEBAR ====================== --}}

  {{-- ====================== MAIN ====================== --}}
  <div class="ad-main">

    {{-- Top bar --}}
    <header class="ad-topbar">
      <div class="ad-topbar-left">
        <button class="ad-topbar-toggle" id="adSidebarToggle" type="button">
          <i class="fas fa-bars"></i>
        </button>
        <span class="ad-page-title">@yield('title', 'Dashboard')</span>
      </div>
      <div class="ad-topbar-right">
        <a href="{{ route('home') }}" class="ad-topbar-btn" target="_blank">
          <i class="fas fa-arrow-up-right-from-square"></i>
          <span>View Site</span>
        </a>

        {{-- User dropdown --}}
        <div class="ad-user-menu">
          <div class="ad-user-trigger">
            <div class="ad-user-avatar-sm">
              {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
            </div>
            <span class="ad-user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
            <i class="fas fa-chevron-down ad-user-caret"></i>
          </div>
          <div class="ad-user-dropdown">
            <a href="{{ route('admin.settings.index') }}">
              <i class="fas fa-gear"></i> Settings
            </a>
            <hr>
            <form method="POST" action="{{ route('admin.logout') }}">
              @csrf
              <button type="submit" class="danger">
                <i class="fas fa-right-from-bracket"></i> Logout
              </button>
            </form>
          </div>
        </div>
      </div>
    </header>

    {{-- Content --}}
    <main class="ad-content">
      @yield('content')
    </main>

  </div>
  {{-- ====================== / MAIN ====================== --}}

</div>

{{-- Delete confirm modal --}}
<div class="ad-confirm-overlay" id="adConfirmOverlay">
  <div class="ad-confirm-box">
    <h4>Confirm Delete</h4>
    <p>This action cannot be undone. Are you sure you want to delete this record?</p>
    <div class="ad-confirm-actions">
      <button class="btn-ad btn-ad-outline" id="adConfirmNo">Cancel</button>
      <button class="btn-ad btn-ad-danger" id="adConfirmYes">
        <i class="fas fa-trash"></i> Delete
      </button>
    </div>
  </div>
</div>

{{-- Scripts --}}
<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')

</body>
</html>
