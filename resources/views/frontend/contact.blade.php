@extends('layouts.frontend')

@section('title', 'Contact Us | DevRoots Academy')
@section('meta_description', 'Get in touch with DevRoots Academy. Located in Masaka City, Uganda. Send us a message, call, or email us.')

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

            {{-- LEFT: Contact Info --}}
            <div class="col-lg-5">
                <span class="section-label">Reach Us</span>
                <h2 class="section-title">Contact Information</h2>
                <span class="title-bar"></span>

                <div class="d-flex flex-column gap-3 mt-4">
                    <div style="display:flex;align-items:flex-start;gap:14px;">
                        <div style="width:40px;height:40px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <strong style="font-size:0.875rem;color:var(--text);display:block;margin-bottom:2px;">Address</strong>
                            <span style="font-size:0.875rem;color:var(--text-muted);">Masaka City, Uganda</span>
                        </div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:14px;">
                        <div style="width:40px;height:40px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <strong style="font-size:0.875rem;color:var(--text);display:block;margin-bottom:2px;">Phone</strong>
                            <a href="tel:+256705028592" style="font-size:0.875rem;color:var(--primary);">+256 705 028 592</a>
                        </div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:14px;">
                        <div style="width:40px;height:40px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <strong style="font-size:0.875rem;color:var(--text);display:block;margin-bottom:2px;">Email</strong>
                            <a href="mailto:info@devroots.ac.ug" style="font-size:0.875rem;color:var(--primary);">info@devroots.ac.ug</a>
                        </div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:14px;">
                        <div style="width:40px;height:40px;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <strong style="font-size:0.875rem;color:var(--text);display:block;margin-bottom:2px;">Working Hours</strong>
                            <span style="font-size:0.875rem;color:var(--text-muted);">
                                Mon – Fri: 8:00 AM – 6:00 PM<br>Saturday: 9:00 AM – 1:00 PM
                            </span>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <p style="font-size:0.875rem;margin-bottom:12px;color:var(--text-muted);">Follow us on social media:</p>
                <div class="footer-social">
                    <a href="https://facebook.com/devroots" target="_blank" rel="noopener" aria-label="Facebook" style="background:var(--primary);border-color:var(--primary);color:#fff;"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://x.com/devroots" target="_blank" rel="noopener" aria-label="Twitter" style="background:var(--primary);border-color:var(--primary);color:#fff;"><i class="fab fa-x-twitter"></i></a>
                    <a href="https://linkedin.com/company/devroots" target="_blank" rel="noopener" aria-label="LinkedIn" style="background:var(--primary);border-color:var(--primary);color:#fff;"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://instagram.com/devroots" target="_blank" rel="noopener" aria-label="Instagram" style="background:var(--primary);border-color:var(--primary);color:#fff;"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            {{-- RIGHT: Contact Form --}}
            <div class="col-lg-7">
                <span class="section-label">Send a Message</span>
                <h2 class="section-title">We'd Love to Hear From You</h2>
                <span class="title-bar"></span>

                @if(session('contact_success'))
                    <div class="alert-success-msg mt-4">
                        <i class="fas fa-check-circle me-2"></i>{{ session('contact_success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-error-msg mt-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" novalidate class="mt-4">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name <span class="text-primary">*</span></label>
                            <input type="text" id="name" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Your full name"
                                   value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address <span class="text-primary">*</span></label>
                            <input type="email" id="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="you@example.com"
                                   value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="subject" class="form-label">Subject <span class="text-primary">*</span></label>
                            <input type="text" id="subject" name="subject"
                                   class="form-control @error('subject') is-invalid @enderror"
                                   placeholder="What is your message about?"
                                   value="{{ old('subject') }}" required>
                            @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label">Message <span class="text-primary">*</span></label>
                            <textarea id="message" name="message"
                                      class="form-control @error('message') is-invalid @enderror"
                                      rows="6"
                                      placeholder="Write your message here..."
                                      required>{{ old('message') }}</textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection
