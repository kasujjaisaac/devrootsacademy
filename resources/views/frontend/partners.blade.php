@extends('layouts.frontend')

@section('title', 'Our Partners | DevRoots Academy')
@section('meta_description', 'DevRoots Academy collaborates with industry leaders, government bodies, and institutions to deliver world-class IT education in Masaka, Uganda.')

@push('styles')
<style>
.partner-detail-card {
    background: #fff;
    border: 1px solid rgba(15, 23, 42, 0.08);
    padding: .95rem;
    height: 100%;
    text-align: center;
    transition: transform .2s ease, box-shadow .2s ease;
}
.partner-detail-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 32px rgba(15, 23, 42, 0.08);
}
.partner-detail-card img {
    width: 100%;
    max-width: 104px;
    height: 52px;
    object-fit: contain;
    margin: 0 auto .7rem;
}
.partner-detail-card h4 {
    margin-bottom: 0;
    font-size: .95rem;
}
.partner-category {
    display: inline-block;
    margin-bottom: .45rem;
    font-size: .68rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--primary);
}
</style>
@endpush

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
                    @forelse($partners as $partner)
                        <div class="col-md-6 col-xl-4">
                            <div class="partner-detail-card">
                                <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}">
                                @if($partner->category)
                                    <span class="partner-category">{{ $partner->category }}</span>
                                @endif
                                <h4>{{ $partner->name }}</h4>
                                @if($partner->website_url)
                                    <div class="mt-2">
                                        <a href="{{ $partner->website_url }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">
                                            Visit Website
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="why-item h-100">
                                <h4>No partners published yet</h4>
                                <p>Use the admin area to add partner records and they will appear here automatically.</p>
                            </div>
                        </div>
                    @endforelse
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
