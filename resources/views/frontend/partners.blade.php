@extends('layouts.frontend')

@section('title', 'Our Partners | DevRoots Academy')
@section('meta_description', 'DevRoots Academy collaborates with industry leaders, government bodies, and institutions to deliver world-class IT education in Masaka, Uganda.')

@section('content')

{{-- ===== PAGE HERO ===== --}}
<section class="page-hero">
    <div class="container">
        <h1>Our Partners</h1>
        <p>Building bridges between education and industry.</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Partners</li>
            </ol>
        </nav>
    </div>
</section>

{{-- ===== INTRO ===== --}}
<section class="section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <span class="section-label">Our Network</span>
                <h2 class="section-title">Trusted Collaborators</h2>
                <span class="title-bar"></span>
                <p>
                    We collaborate with industry leaders, government bodies, and institutions
                    to provide the best learning opportunities and real-world experiences for
                    our students.
                </p>
                <p>
                    Our partnerships ensure that DevRoots graduates are recognised, job-ready,
                    and connected to opportunities across Uganda and beyond.
                </p>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-6 col-md-4">
                        <div class="partner-logo-card">
                            <img src="{{ asset('images/partners/butende.png') }}" alt="Butende">
                            <span>Butende</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="partner-logo-card">
                            <img src="{{ asset('images/partners/mru.png') }}" alt="MRU">
                            <span>MRU</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="partner-logo-card">
                            <img src="{{ asset('images/partners/mahipso.png') }}" alt="Mahipso">
                            <span>Mahipso</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="partner-logo-card">
                            <img src="{{ asset('images/partners/adic.png') }}" alt="ADIC">
                            <span>ADIC</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="partner-logo-card">
                            <img src="{{ asset('images/partners/masakacity.png') }}" alt="Masaka City">
                            <span>Masaka City</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="partner-logo-card">
                            <img src="{{ asset('images/partners/nita.svg') }}" alt="NITA">
                            <span>NITA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== BENEFITS ===== --}}
<section class="section" style="background: var(--surface);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-label">Why Partner With Us</span>
            <h2 class="section-title">Partnership Benefits</h2>
            <span class="title-bar centered"></span>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="why-item h-100">
                    <div class="why-icon"><i class="fas fa-user-graduate"></i></div>
                    <h4>Skilled Graduates</h4>
                    <p>Access to a pool of practically trained, job-ready IT graduates each cohort.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-item h-100">
                    <div class="why-icon"><i class="fas fa-bullhorn"></i></div>
                    <h4>Brand Visibility</h4>
                    <p>Your logo and brand featured across our platforms, campus, and events.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-item h-100">
                    <div class="why-icon"><i class="fas fa-handshake"></i></div>
                    <h4>Community Impact</h4>
                    <p>Directly contribute to digital skills development in the Masaka region.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== BECOME A PARTNER CTA ===== --}}
<section class="cta-banner">
    <div class="container">
        <h2>Interested in Partnering With Us?</h2>
        <p>Let's work together to empower the next generation of tech innovators in Uganda.</p>
        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
            <i class="fas fa-envelope me-2"></i>Get In Touch
        </a>
    </div>
</section>

@endsection
