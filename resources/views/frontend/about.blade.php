@extends('layouts.frontend')

@section('title', 'About Us | DevRoots Academy')
@section('meta_description', 'Learn about DevRoots Academy — our mission, vision, values, and the team driving IT education in Masaka, Uganda.')

@section('content')

{{-- ===== PAGE HERO ===== --}}
<section class="page-hero">
    <div class="container">
        <h1>About DevRoots Academy</h1>
        <p>Bridging the digital skills gap in Masaka and beyond.</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">About</li>
            </ol>
        </nav>
    </div>
</section>

{{-- ===== MISSION & VISION ===== --}}
<section class="section">
    <div class="container">
        <div class="row g-5 align-items-center">

            <div class="col-lg-6">
                <span class="section-label">Our Story</span>
                <h2 class="section-title">Who We Are</h2>
                <span class="title-bar"></span>
                <p>
                    DevRoots Academy is a practical IT training institution based in Masaka City, Uganda.
                    We are dedicated to empowering learners with the digital skills, mindset, and hands-on
                    experience required to thrive in today's technology-driven economy.
                </p>
                <p>
                    Founded on the belief that strong roots create strong innovators, we offer courses
                    in programming, software development, hardware repair, networking, cloud computing,
                    and more — all designed around real-world application.
                </p>
            </div>

            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <div class="why-item">
                            <div class="why-icon"><i class="fas fa-eye"></i></div>
                            <h4>Our Vision</h4>
                            <p>To be the leading hub for tech education and innovation in Uganda.</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="why-item">
                            <div class="why-icon"><i class="fas fa-bullseye"></i></div>
                            <h4>Our Mission</h4>
                            <p>To equip learners with practical IT skills for real-world impact.</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="why-item">
                            <div class="why-icon"><i class="fas fa-users"></i></div>
                            <h4>Community</h4>
                            <p>Building a strong network of tech professionals and innovators.</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="why-item">
                            <div class="why-icon"><i class="fas fa-award"></i></div>
                            <h4>Excellence</h4>
                            <p>Maintaining high standards in every course and interaction.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ===== VALUES ===== --}}
<section class="section" style="background: var(--surface);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-label">What Drives Us</span>
            <h2 class="section-title">Our Core Values</h2>
            <span class="title-bar centered"></span>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="why-item h-100">
                    <div class="why-icon"><i class="fas fa-star"></i></div>
                    <h4>Excellence</h4>
                    <p>We hold ourselves and our students to the highest standards of learning and professionalism.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-item h-100">
                    <div class="why-icon"><i class="fas fa-hands-helping"></i></div>
                    <h4>Inclusivity</h4>
                    <p>We welcome learners from all backgrounds, creating a diverse and supportive environment.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-item h-100">
                    <div class="why-icon"><i class="fas fa-lightbulb"></i></div>
                    <h4>Innovation</h4>
                    <p>We encourage creative thinking and embrace new technologies in everything we do.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-item h-100">
                    <div class="why-icon"><i class="fas fa-handshake"></i></div>
                    <h4>Integrity</h4>
                    <p>We act with transparency and professionalism in all our interactions.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-item h-100">
                    <div class="why-icon"><i class="fas fa-globe-africa"></i></div>
                    <h4>Community Engagement</h4>
                    <p>We are rooted in Masaka and committed to giving back to the community we serve.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-item h-100">
                    <div class="why-icon"><i class="fas fa-tools"></i></div>
                    <h4>Practical Focus</h4>
                    <p>Every lesson is grounded in real-world application and project-based learning.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CONTACT INFO ===== --}}
<section class="section">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <span class="section-label">Find Us</span>
                <h2 class="section-title">Get In Touch</h2>
                <span class="title-bar"></span>
                <p>Have questions about our programs? We'd love to hear from you.</p>
                <div class="mt-3">
                    <p class="mb-2"><i class="fas fa-map-marker-alt text-primary me-2"></i> Masaka City, Uganda</p>
                    <p class="mb-2"><i class="fas fa-phone text-primary me-2"></i>
                        <a href="tel:+256705028592">+256 705 028 592</a></p>
                    <p class="mb-2"><i class="fas fa-envelope text-primary me-2"></i>
                        <a href="mailto:info@devroots.ac.ug">info@devroots.ac.ug</a></p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex flex-column gap-3">
                    <a href="{{ route('apply.now') }}" class="action-card">
                        <div class="icon"><i class="fas fa-user-graduate"></i></div>
                        <div>
                            <span class="label">Apply as a Student</span>
                            <span class="sub">Start your learning journey today</span>
                        </div>
                    </a>
                    <a href="{{ route('instructor.form') }}" class="action-card">
                        <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div>
                            <span class="label">Become an Instructor</span>
                            <span class="sub">Share your expertise with learners</span>
                        </div>
                    </a>
                    <a href="{{ route('contact') }}" class="action-card">
                        <div class="icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <span class="label">Contact Us</span>
                            <span class="sub">Have a question? We're here to help</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
