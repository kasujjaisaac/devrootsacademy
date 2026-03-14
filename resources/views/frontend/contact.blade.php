@extends('layouts.frontend')

@section('title', 'Contact Us | DevRoots Academy')
@section('meta_description', 'Get in touch with DevRoots Academy. We are located in Masaka City, Uganda. Reach us by phone, email, or apply online.')

@section('content')

{{-- ===== PAGE HERO ===== --}}
<section class="page-hero">
    <div class="container">
        <h1>Get In Touch</h1>
        <p>We'd love to hear from you. Reach out and let's talk about your learning journey.</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Contact</li>
            </ol>
        </nav>
    </div>
</section>

{{-- ===== CONTACT SECTION ===== --}}
<section class="section">
    <div class="container">
        <div class="row g-5">

            {{-- Contact Info Column --}}
            <div class="col-lg-5">
                <span class="section-label">Reach Us</span>
                <h2 class="section-title">Contact Information</h2>
                <span class="title-bar"></span>

                <div class="d-flex flex-column gap-3 mt-4">

                    <div style="display:flex; align-items:flex-start; gap:14px;">
                        <div style="width:40px;height:40px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <strong style="font-size:0.875rem;color:var(--text);display:block;margin-bottom:2px;">Address</strong>
                            <span style="font-size:0.875rem;color:var(--text-muted);">Masaka City, Uganda</span>
                        </div>
                    </div>

                    <div style="display:flex; align-items:flex-start; gap:14px;">
                        <div style="width:40px;height:40px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <strong style="font-size:0.875rem;color:var(--text);display:block;margin-bottom:2px;">Phone</strong>
                            <a href="tel:+256705028592" style="font-size:0.875rem;color:var(--primary);">+256 705 028 592</a>
                        </div>
                    </div>

                    <div style="display:flex; align-items:flex-start; gap:14px;">
                        <div style="width:40px;height:40px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <strong style="font-size:0.875rem;color:var(--text);display:block;margin-bottom:2px;">Email</strong>
                            <a href="mailto:info@devroots.ac.ug" style="font-size:0.875rem;color:var(--primary);">info@devroots.ac.ug</a>
                        </div>
                    </div>

                    <div style="display:flex; align-items:flex-start; gap:14px;">
                        <div style="width:40px;height:40px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <strong style="font-size:0.875rem;color:var(--text);display:block;margin-bottom:2px;">Working Hours</strong>
                            <span style="font-size:0.875rem;color:var(--text-muted);">
                                Mon – Fri: 8:00 AM – 6:00 PM<br>
                                Saturday: 9:00 AM – 1:00 PM
                            </span>
                        </div>
                    </div>

                </div>

                <hr class="my-4">

                <p style="font-size:0.875rem;margin-bottom:12px;color:var(--text-muted);">Follow us on social media:</p>
                <div class="footer-social">
                    <a href="#" target="_blank" rel="noopener" aria-label="Facebook"
                       style="background:var(--primary);border-color:var(--primary);color:#fff;">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" target="_blank" rel="noopener" aria-label="Twitter"
                       style="background:var(--primary);border-color:var(--primary);color:#fff;">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="#" target="_blank" rel="noopener" aria-label="LinkedIn"
                       style="background:var(--primary);border-color:var(--primary);color:#fff;">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" target="_blank" rel="noopener" aria-label="Instagram"
                       style="background:var(--primary);border-color:var(--primary);color:#fff;">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            {{-- Quick Actions Column --}}
            <div class="col-lg-7">
                <span class="section-label">How Can We Help?</span>
                <h2 class="section-title">Quick Actions</h2>
                <span class="title-bar"></span>

                <div class="d-flex flex-column gap-3 mt-4">

                    <a href="{{ route('apply.now') }}" class="action-card">
                        <div class="icon"><i class="fas fa-user-graduate"></i></div>
                        <div class="action-card-text">
                            <span class="label">Apply as a Student</span>
                            <span class="sub">Start your hands-on learning journey today</span>
                        </div>
                        <i class="fas fa-chevron-right flex-shrink-0" style="color:var(--text-muted);font-size:0.75rem;"></i>
                    </a>

                    <a href="{{ route('instructor.form') }}" class="action-card">
                        <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="action-card-text">
                            <span class="label">Become an Instructor</span>
                            <span class="sub">Share your expertise and inspire learners</span>
                        </div>
                        <i class="fas fa-chevron-right flex-shrink-0" style="color:var(--text-muted);font-size:0.75rem;"></i>
                    </a>

                    <a href="{{ route('courses.index') }}" class="action-card">
                        <div class="icon"><i class="fas fa-book-open"></i></div>
                        <div class="action-card-text">
                            <span class="label">Browse Courses</span>
                            <span class="sub">Explore all available IT programs and courses</span>
                        </div>
                        <i class="fas fa-chevron-right flex-shrink-0" style="color:var(--text-muted);font-size:0.75rem;"></i>
                    </a>

                </div>

                <div style="background:var(--surface);border:1px solid var(--border);padding:24px;margin-top:24px;">
                    <p style="font-size:0.9375rem;color:var(--text);margin:0;line-height:1.7;">
                        <i class="fas fa-envelope text-primary me-2"></i>
                        Have a question or enquiry? Send us an email at
                        <a href="mailto:info@devroots.ac.ug" style="color:var(--primary);font-weight:500;">info@devroots.ac.ug</a>
                        and we'll get back to you within 24 hours.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
