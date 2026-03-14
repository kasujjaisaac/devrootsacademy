@extends('layouts.frontend')

@section('title', 'Become an Instructor | DevRoots Academy')
@section('meta_description', 'Join DevRoots Academy as an instructor. Teach practical IT skills and empower the next generation of tech innovators in Uganda.')

@section('content')

{{-- ===== PAGE TOP BAR ===== --}}
<div class="form-page-top">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <div class="fp-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <h1>Instructor Application</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Become an Instructor</li>
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

                    <h2>Why Teach at DevRoots?</h2>
                    <p class="bp-subtitle">
                        Share your expertise and make a direct impact on the next
                        generation of IT professionals across Uganda.
                    </p>

                    <ul class="benefits-list">
                        <li>
                            <div class="bl-icon"><i class="fas fa-calendar-alt"></i></div>
                            <span class="bl-text">Flexible teaching schedules that fit your life</span>
                        </li>
                        <li>
                            <div class="bl-icon"><i class="fas fa-tools"></i></div>
                            <span class="bl-text">Teach practical, real-world applicable skills</span>
                        </li>
                        <li>
                            <div class="bl-icon"><i class="fas fa-globe-africa"></i></div>
                            <span class="bl-text">Impact learners across Uganda &amp; beyond</span>
                        </li>
                        <li>
                            <div class="bl-icon"><i class="fas fa-wallet"></i></div>
                            <span class="bl-text">Earn while growing your professional brand</span>
                        </li>
                        <li>
                            <div class="bl-icon"><i class="fas fa-cloud"></i></div>
                            <span class="bl-text">Moodle-powered learning environment</span>
                        </li>
                        <li>
                            <div class="bl-icon"><i class="fas fa-users-cog"></i></div>
                            <span class="bl-text">Join a community of dedicated educators</span>
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
                            <span class="bps-num">8+</span>
                            <span class="bps-lbl">Partners</span>
                        </div>
                        <div class="bps-item">
                            <span class="bps-num">95%</span>
                            <span class="bps-lbl">Satisfaction</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ===== RIGHT: FORM PANEL ===== --}}
            <div class="col-lg-8">
                <div class="form-panel">

                    {{-- Panel header --}}
                    <div class="form-panel-top">
                        <h3><i class="fas fa-id-card text-primary me-2"></i>Instructor Application</h3>
                        <p>Tell us about yourself and your expertise. We'll review your application promptly.</p>
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

                    <form action="{{ route('frontend.instructor.submit') }}" method="POST" novalidate>
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
                                        <label for="email" class="form-label">
                                            Email Address <span class="text-primary">*</span>
                                        </label>
                                        <input type="email" id="email" name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               placeholder="you@example.com"
                                               value="{{ old('email') }}" required>
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
                                        <label for="portfolio" class="form-label">
                                            Portfolio / LinkedIn / GitHub
                                            <span class="fw-normal" style="color:var(--text-muted);">(Optional)</span>
                                        </label>
                                        <input type="url" id="portfolio" name="portfolio"
                                               class="form-control @error('portfolio') is-invalid @enderror"
                                               placeholder="https://..."
                                               value="{{ old('portfolio') }}">
                                        @error('portfolio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Section: Expertise --}}
                            <div class="form-section-group">
                                <p class="form-section-hd">
                                    <i class="fas fa-briefcase"></i>Expertise &amp; Experience
                                </p>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="expertise" class="form-label">
                                            Area of Expertise <span class="text-primary">*</span>
                                        </label>
                                        <select id="expertise" name="expertise"
                                                class="form-select @error('expertise') is-invalid @enderror"
                                                required>
                                            <option value="">Select your expertise</option>
                                            @foreach([
                                                'Programming',
                                                'Web Development',
                                                'AI & Machine Learning',
                                                'Networking',
                                                'Hardware Repair',
                                                'Cloud Computing',
                                                'Mobile App Development',
                                            ] as $area)
                                                <option value="{{ $area }}"
                                                    {{ old('expertise') === $area ? 'selected' : '' }}>
                                                    {{ $area }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('expertise')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="experience_years" class="form-label">
                                            Years of Experience <span class="text-primary">*</span>
                                        </label>
                                        <input type="number" id="experience_years" name="experience_years"
                                               class="form-control @error('experience_years') is-invalid @enderror"
                                               min="0" placeholder="e.g. 3"
                                               value="{{ old('experience_years') }}" required>
                                        @error('experience_years')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="bio" class="form-label">
                                            Short Bio <span class="text-primary">*</span>
                                        </label>
                                        <textarea id="bio" name="bio"
                                                  class="form-control @error('bio') is-invalid @enderror"
                                                  rows="4"
                                                  placeholder="Tell us about your background, teaching philosophy, and what you'd like to teach..."
                                                  required>{{ old('bio') }}</textarea>
                                        @error('bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>{{-- /form-panel-body --}}

                        {{-- Submit area --}}
                        <div class="submit-area">
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
