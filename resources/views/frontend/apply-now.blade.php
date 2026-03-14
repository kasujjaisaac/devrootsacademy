@extends('layouts.frontend')

@section('title', 'Apply Now | DevRoots Academy')
@section('meta_description', 'Apply to study at DevRoots Academy. Start your hands-on IT learning journey today in Masaka, Uganda.')

@section('content')

{{-- ===== PAGE TOP BAR ===== --}}
<div class="form-page-top">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <div class="fp-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <h1>Student Application</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Apply Now</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- ===== MAIN CONTENT ===== --}}
<section class="section section-sm">
    <div class="container">
        <div class="row g-4 g-xl-5 align-items-start">

            {{-- ===== LEFT: BENEFITS PANEL ===== --}}
            <div class="col-lg-4">
                <div class="benefits-panel">

                    <img src="{{ asset('images/logo-square.png') }}"
                         alt="DevRoots Academy"
                         class="bp-logo">

                    <h2>Why Learn at DevRoots?</h2>
                    <p class="bp-subtitle">
                        Join hundreds of students already building real-world
                        IT skills and transforming their careers in Masaka.
                    </p>

                    <ul class="benefits-list">
                        <li>
                            <div class="bl-icon"><i class="fas fa-laptop-code"></i></div>
                            <span class="bl-text">Practical, hands-on training from day one</span>
                        </li>
                        <li>
                            <div class="bl-icon"><i class="fas fa-industry"></i></div>
                            <span class="bl-text">Industry-relevant, up-to-date curriculum</span>
                        </li>
                        <li>
                            <div class="bl-icon"><i class="fas fa-layer-group"></i></div>
                            <span class="bl-text">Beginner to advanced learning paths</span>
                        </li>
                        <li>
                            <div class="bl-icon"><i class="fas fa-users"></i></div>
                            <span class="bl-text">Supportive mentors &amp; dedicated instructors</span>
                        </li>
                        <li>
                            <div class="bl-icon"><i class="fas fa-cloud"></i></div>
                            <span class="bl-text">Moodle-powered online learning platform</span>
                        </li>
                        <li>
                            <div class="bl-icon"><i class="fas fa-certificate"></i></div>
                            <span class="bl-text">Recognised certification on completion</span>
                        </li>
                    </ul>

                    <hr class="bp-divider">

                    <div class="bp-stats">
                        <div class="bps-item">
                            <span class="bps-num">500+</span>
                            <span class="bps-lbl">Students</span>
                        </div>
                        <div class="bps-item">
                            <span class="bps-num">12+</span>
                            <span class="bps-lbl">Courses</span>
                        </div>
                        <div class="bps-item">
                            <span class="bps-num">95%</span>
                            <span class="bps-lbl">Satisfaction</span>
                        </div>
                        <div class="bps-item">
                            <span class="bps-num">8+</span>
                            <span class="bps-lbl">Partners</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ===== RIGHT: FORM PANEL ===== --}}
            <div class="col-lg-8">
                <div class="form-panel">

                    {{-- Panel header --}}
                    <div class="form-panel-top">
                        <h3><i class="fas fa-file-alt text-primary me-2"></i>Application Form</h3>
                        <p>Fill in the details below and we'll get back to you within 24 hours.</p>
                    </div>

                    {{-- Alerts --}}
                    @if(session('success'))
                        <div class="alert-success-msg mx-4 mt-3">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert-error-msg mx-4 mt-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('frontend.apply.submit') }}" method="POST" novalidate>
                        @csrf

                        <div class="form-panel-body">

                            {{-- Section: Personal Info --}}
                            <div class="form-section-group">
                                <p class="form-section-hd">
                                    <i class="fas fa-user"></i>Personal Information
                                </p>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="full_name" class="form-label">
                                            Full Name <span class="text-primary">*</span>
                                        </label>
                                        <input type="text" id="full_name" name="full_name"
                                               class="form-control @error('full_name') is-invalid @enderror"
                                               placeholder="Your full name"
                                               value="{{ old('full_name') }}" required>
                                        @error('full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" id="username" name="username"
                                               class="form-control @error('username') is-invalid @enderror"
                                               placeholder="Choose a username"
                                               value="{{ old('username') }}">
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" id="email" name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               placeholder="you@example.com"
                                               value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">
                                            Phone Number <span class="text-primary">*</span>
                                        </label>
                                        <input type="tel" id="phone" name="phone"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               placeholder="+256 7xx xxx xxx"
                                               value="{{ old('phone') }}" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" id="dob" name="dob"
                                               class="form-control @error('dob') is-invalid @enderror"
                                               value="{{ old('dob') }}">
                                        @error('dob')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="location" class="form-label">Location</label>
                                        <input type="text" id="location" name="location"
                                               class="form-control @error('location') is-invalid @enderror"
                                               placeholder="City, Country"
                                               value="{{ old('location') }}">
                                        @error('location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Section: Course Selection --}}
                            <div class="form-section-group">
                                <p class="form-section-hd">
                                    <i class="fas fa-book-open"></i>Course Selection
                                </p>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="course_interest" class="form-label">
                                            Select Course <span class="text-primary">*</span>
                                        </label>
                                        <select id="course_interest" name="course_interest"
                                                class="form-select @error('course_interest') is-invalid @enderror"
                                                required>
                                            <option value="">Choose your course of interest</option>
                                            @foreach([
                                                'Programming Fundamentals',
                                                'Web Development',
                                                'AI & Machine Learning',
                                                'Mobile App Development',
                                                'Cloud Computing',
                                                'Networking Essentials',
                                                'Computer Repair & Maintenance',
                                                'Internet of Things (IoT)',
                                            ] as $course)
                                                <option value="{{ $course }}"
                                                    {{ old('course_interest') === $course ? 'selected' : '' }}>
                                                    {{ $course }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('course_interest')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="goals" class="form-label">
                                            Why do you want to join?
                                            <span class="fw-normal" style="color:var(--text-muted);">(Optional)</span>
                                        </label>
                                        <textarea id="goals" name="goals"
                                                  class="form-control @error('goals') is-invalid @enderror"
                                                  rows="3"
                                                  placeholder="Tell us about your learning goals and what you hope to achieve...">{{ old('goals') }}</textarea>
                                        @error('goals')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>{{-- /form-panel-body --}}

                        {{-- Submit area --}}
                        <div class="submit-area">
                            <div class="form-check">
                                <input type="checkbox" id="terms" name="terms"
                                       class="form-check-input @error('terms') is-invalid @enderror"
                                       {{ old('terms') ? 'checked' : '' }} required>
                                <label class="form-check-label" for="terms">
                                    I agree to the
                                    <a href="{{ route('contact') }}" class="text-primary">terms &amp; conditions</a>.
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Submit Application
                            </button>

                            <p class="trust-note">
                                <i class="fas fa-lock"></i>
                                Your information is secure and will never be shared.
                            </p>
                        </div>

                    </form>
                </div>{{-- /form-panel --}}
            </div>

        </div>
    </div>
</section>

@endsection
