@extends('layouts.frontend')

@section('title', 'DevRoots Academy | Growing IT Talent in Masaka')
@section('meta_description', 'DevRoots Academy empowers IT innovators in Masaka with hands-on programming, hardware repair, networking, and software development courses.')

@section('content')

{{-- ===== HERO ===== --}}
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <span class="section-label">Based in Masaka, Uganda</span>
                <h1>Building Africa's Next<br><span>Tech Innovators</span></h1>
                <p>
                    Practical programming, hardware repair, networking, and innovation —
                    taught by doing, not just theory.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-book-open me-2"></i>Explore Courses
                    </a>
                    <a href="{{ route('instructor.form') }}" class="btn btn-primary btn-lg">
                        Become an Instructor
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== STATS BAR ===== --}}
<div class="stats-bar">
    <div class="container">
        <div class="row g-0 text-center">
            <div class="col-6 col-md-3 stat-item">
                <span class="stat-number">500+</span>
                <span class="stat-label">Students Trained</span>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <span class="stat-number">12+</span>
                <span class="stat-label">Active Courses</span>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <span class="stat-number">8+</span>
                <span class="stat-label">Industry Partners</span>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <span class="stat-number">95%</span>
                <span class="stat-label">Student Satisfaction</span>
            </div>
        </div>
    </div>
</div>

{{-- ===== ABOUT / WHY DEVROOTS ===== --}}
<section id="about" class="section about-section">
    <div class="container">
        <div class="row g-5 align-items-center">

            <div class="col-lg-6">
                <span class="section-label">Our Mission</span>
                <h2 class="section-title">Why DevRoots Academy?</h2>
                <span class="title-bar"></span>
                <p>
                    We believe strong roots create strong innovators. DevRoots Academy exists to equip
                    learners in Masaka with hands-on IT skills, mentorship, and the confidence to build
                    solutions that matter — locally and globally.
                </p>
                <p>
                    Our curriculum is designed with industry professionals, ensuring every course prepares
                    you for real-world challenges from day one.
                </p>
                <a href="{{ route('about') }}" class="btn btn-primary mt-2">
                    Learn More About Us
                </a>
            </div>

            <div class="col-lg-6">
                <ul class="about-feature-list">
                    <li>
                        <span class="icon"><i class="fas fa-code"></i></span>
                        <div>
                            <strong>Practical, project-based learning</strong><br>
                            <small style="color:var(--text-muted);">Build real projects from week one, not just theory.</small>
                        </div>
                    </li>
                    <li>
                        <span class="icon"><i class="fas fa-briefcase"></i></span>
                        <div>
                            <strong>Industry-aligned curriculum</strong><br>
                            <small style="color:var(--text-muted);">Courses designed with and for real employers.</small>
                        </div>
                    </li>
                    <li>
                        <span class="icon"><i class="fas fa-users"></i></span>
                        <div>
                            <strong>Mentorship &amp; innovation culture</strong><br>
                            <small style="color:var(--text-muted);">Supportive community of learners and experienced mentors.</small>
                        </div>
                    </li>
                    <li>
                        <span class="icon"><i class="fas fa-certificate"></i></span>
                        <div>
                            <strong>Recognised certification</strong><br>
                            <small style="color:var(--text-muted);">Complete each course with a verifiable certificate.</small>
                        </div>
                    </li>
                    <li>
                        <span class="icon"><i class="fas fa-laptop"></i></span>
                        <div>
                            <strong>Moodle-powered learning platform</strong><br>
                            <small style="color:var(--text-muted);">Access materials, submit work, and track progress online.</small>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>

{{-- ===== FEATURED COURSES ===== --}}
<section id="courses" class="section featured-courses-section">
    <div class="container">
        <div class="text-center">
            <span class="section-label">What We Offer</span>
            <h2 class="section-title">Featured Courses</h2>
            <span class="title-bar centered"></span>
            <p class="section-subtitle centered">
                Industry-relevant programs designed to build practical and job-ready IT skills.
            </p>
        </div>

        <div class="courses-grid-hp">
            <x-frontend.course-card
                image="programming.png"
                title="Programming Fundamentals"
                desc="Learn logic, problem-solving, and Python basics through hands-on coding."
                duration="8 Weeks"
                level="Beginner"
                slug="programming-fundamentals" />

            <x-frontend.course-card
                image="web-development.png"
                title="Web Development"
                desc="Build modern, responsive websites using HTML, CSS, JavaScript, and Git."
                duration="12 Weeks"
                level="Intermediate"
                slug="web-development" />

            <x-frontend.course-card
                image="hardware.png"
                title="Computer Repair &amp; Maintenance"
                desc="Diagnose, repair, and maintain computers with real hands-on lab practice."
                duration="10 Weeks"
                level="Beginner"
                slug="computer-repair-maintenance" />

            <x-frontend.course-card
                image="ai.png"
                title="AI &amp; Machine Learning"
                desc="Understand AI concepts and build intelligent systems using real datasets."
                duration="14 Weeks"
                level="Advanced"
                slug="ai-machine-learning" />

            <x-frontend.course-card
                image="networking.png"
                title="Networking Essentials"
                desc="Learn networking fundamentals, protocols, and hands-on configuration skills."
                duration="10 Weeks"
                level="Beginner"
                slug="networking-essentials" />

            <x-frontend.course-card
                image="mobile-apps.png"
                title="Mobile App Development"
                desc="Create engaging mobile applications for Android using Java and Kotlin."
                duration="12 Weeks"
                level="Intermediate"
                slug="mobile-app-development" />

            <x-frontend.course-card
                image="cloud-computing.png"
                title="Cloud Computing Basics"
                desc="Explore cloud concepts and services with hands-on labs on AWS and Azure."
                duration="8 Weeks"
                level="Beginner"
                slug="cloud-computing-basics" />

            <x-frontend.course-card
                image="iot.png"
                title="Internet of Things (IoT)"
                desc="Learn to connect devices, collect data, and build smart IoT solutions."
                duration="14 Weeks"
                level="Advanced"
                slug="internet-of-things" />
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-lg">
                View All Courses <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- ===== WHY CHOOSE US ===== --}}
<section class="section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-label">The DevRoots Advantage</span>
            <h2 class="section-title">Built for Real-World Impact</h2>
            <span class="title-bar centered"></span>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="why-item h-100">
                    <div class="why-icon"><i class="fas fa-tools"></i></div>
                    <h4>Hands-On Training</h4>
                    <p>Every lesson includes labs and real projects to build your portfolio.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="why-item h-100">
                    <div class="why-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h4>Expert Instructors</h4>
                    <p>Learn from professionals with years of industry experience.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="why-item h-100">
                    <div class="why-icon"><i class="fas fa-clock"></i></div>
                    <h4>Flexible Schedules</h4>
                    <p>Morning, afternoon, and weekend sessions to fit your life.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="why-item h-100">
                    <div class="why-icon"><i class="fas fa-handshake"></i></div>
                    <h4>Career Support</h4>
                    <p>Job placement assistance and networking with partner companies.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== TESTIMONIALS ===== --}}
<section id="testimonials" class="section testimonials-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-label">Student Stories</span>
            <h2 class="section-title">What Our Students Say</h2>
            <span class="title-bar centered"></span>
        </div>

        <div class="testimonial-slider">

            <div class="testimonial-slide active">
                <div class="testimonial-card">
                    <p class="testimonial-text">
                        DevRoots Academy gave me the confidence to code, solve real problems, and believe in my future as a software developer.
                    </p>
                    <div class="testimonial-author">
                        <div style="width:44px;height:44px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1rem;flex-shrink:0;">G</div>
                        <div>
                            <span class="name">Gloria K.</span>
                            <span class="role">Junior Software Developer</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="testimonial-slide">
                <div class="testimonial-card">
                    <p class="testimonial-text">
                        The trainers are practical, supportive, and industry-focused. I now build real applications with confidence.
                    </p>
                    <div class="testimonial-author">
                        <div style="width:44px;height:44px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1rem;flex-shrink:0;">J</div>
                        <div>
                            <span class="name">James M.</span>
                            <span class="role">IT Support Specialist</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="testimonial-slide">
                <div class="testimonial-card">
                    <p class="testimonial-text">
                        DevRoots is not just an academy — it is a community that pushes you to grow, innovate, and succeed.
                    </p>
                    <div class="testimonial-author">
                        <div style="width:44px;height:44px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1rem;flex-shrink:0;">S</div>
                        <div>
                            <span class="name">Sarah N.</span>
                            <span class="role">UI/UX Designer</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="testimonial-controls mt-4">
            <button class="prev" aria-label="Previous testimonial">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="testimonial-dots">
                <button class="dot active" aria-label="Slide 1"></button>
                <button class="dot" aria-label="Slide 2"></button>
                <button class="dot" aria-label="Slide 3"></button>
            </div>
            <button class="next" aria-label="Next testimonial">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

    </div>
</section>

{{-- ===== PARTNERS ===== --}}
<section id="partners" class="section partners-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-label">Our Network</span>
            <h2 class="section-title">Trusted Partners</h2>
            <span class="title-bar centered"></span>
        </div>

        <div class="row g-3 justify-content-center">
            <div class="col-6 col-md-4 col-lg-2">
                <div class="partner-logo-card">
                    <img src="{{ asset('images/partners/butende.png') }}" alt="Butende">
                    <span>Butende</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="partner-logo-card">
                    <img src="{{ asset('images/partners/mru.png') }}" alt="MRU">
                    <span>MRU</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="partner-logo-card">
                    <img src="{{ asset('images/partners/mahipso.png') }}" alt="Mahipso">
                    <span>Mahipso</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="partner-logo-card">
                    <img src="{{ asset('images/partners/adic.png') }}" alt="ADIC">
                    <span>ADIC</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="partner-logo-card">
                    <img src="{{ asset('images/partners/masakacity.png') }}" alt="Masaka City">
                    <span>Masaka City</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="partner-logo-card">
                    <img src="{{ asset('images/partners/nita.svg') }}" alt="NITA">
                    <span>NITA</span>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('partners') }}" class="btn btn-outline-primary">
                View All Partners
            </a>
        </div>
    </div>
</section>

{{-- ===== CTA BANNER ===== --}}
<section class="cta-banner">
    <div class="container">
        <h2>Ready to Start Your Tech Journey?</h2>
        <p>Join hundreds of students already building their future at DevRoots Academy.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('apply.now') }}" class="btn btn-outline-light btn-lg">Apply Now</a>
            <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">Contact Us</a>
        </div>
    </div>
</section>

@endsection
