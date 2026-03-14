{{-- ===== SITE HEADER ===== --}}
<nav class="navbar navbar-expand-lg site-header">
    <div class="container">

        {{-- Logo --}}
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo-horizontal.png') }}"
                 alt="DevRoots Academy"
                 height="32">
        </a>

        {{-- Mobile toggle --}}
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#siteNav"
                aria-controls="siteNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Nav links --}}
        <div class="collapse navbar-collapse" id="siteNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}"
                       href="{{ route('courses.index') }}">Courses</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                       href="{{ route('about') }}">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('partners') ? 'active' : '' }}"
                       href="{{ route('partners') }}">Partners</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                       href="{{ route('contact') }}">Contact</a>
                </li>

                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-primary btn-sm px-3"
                       href="{{ route('apply.now') }}">Apply Now</a>
                </li>

                <li class="nav-item ms-lg-1 mt-1 mt-lg-0">
                    <a class="btn btn-outline-primary btn-sm px-3"
                       href="{{ route('admin.login') }}">Login</a>
                </li>

            </ul>
        </div>

    </div>
</nav>
{{-- ===== END HEADER ===== --}}
