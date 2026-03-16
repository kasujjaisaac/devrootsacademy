@extends('layouts.frontend')

@section('title', 'Privacy Policy | DevRoots Academy')
@section('meta_description', 'Read DevRoots Academy\'s Privacy Policy to understand how we collect, use, and protect your personal information.')

@section('content')

{{-- ===== PAGE HERO ===== --}}
<section class="page-hero">
    <div class="container">
        <h1>Privacy Policy</h1>
        <p>Last updated: March 2026</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Privacy Policy</li>
            </ol>
        </nav>
    </div>
</section>

{{-- ===== CONTENT ===== --}}
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <div class="why-item mb-4">
                    <h3>1. Information We Collect</h3>
                    <p>When you apply to study or teach at DevRoots Academy, or contact us through our website, we may collect the following personal information:</p>
                    <ul>
                        <li>Full name, username, email address, and phone number</li>
                        <li>Date of birth and location (optional)</li>
                        <li>Course interest, learning goals, and professional bio</li>
                        <li>Portfolio or professional profile links (optional)</li>
                        <li>Newsletter subscription email address</li>
                    </ul>
                </div>

                <div class="why-item mb-4">
                    <h3>2. How We Use Your Information</h3>
                    <p>We use the information collected to:</p>
                    <ul>
                        <li>Process and manage student and instructor applications</li>
                        <li>Communicate with you about your application status</li>
                        <li>Send periodic newsletter updates (only if you subscribe)</li>
                        <li>Respond to enquiries submitted through our contact form</li>
                        <li>Improve our website and services</li>
                    </ul>
                </div>

                <div class="why-item mb-4">
                    <h3>3. Data Sharing</h3>
                    <p>
                        DevRoots Academy does <strong>not</strong> sell, trade, or otherwise transfer your personal information
                        to third parties. Your data is used solely for the purposes described in this policy.
                        We may share information with trusted service providers who assist us in operating our website,
                        provided those parties agree to keep this information confidential.
                    </p>
                </div>

                <div class="why-item mb-4">
                    <h3>4. Data Security</h3>
                    <p>
                        We implement appropriate technical and organisational measures to protect your personal information
                        against unauthorised access, alteration, disclosure, or destruction. Our website uses HTTPS encryption
                        for all data transmitted between your browser and our servers.
                    </p>
                </div>

                <div class="why-item mb-4">
                    <h3>5. Cookies</h3>
                    <p>
                        Our website may use cookies to enhance your browsing experience. These are small text files stored on
                        your device that help us remember your preferences and understand how visitors use our site. You may
                        disable cookies in your browser settings; however, some parts of the website may not function correctly
                        without them.
                    </p>
                </div>

                <div class="why-item mb-4">
                    <h3>6. Your Rights</h3>
                    <p>You have the right to:</p>
                    <ul>
                        <li>Access the personal information we hold about you</li>
                        <li>Request correction of inaccurate or incomplete data</li>
                        <li>Request deletion of your personal data (subject to legal requirements)</li>
                        <li>Unsubscribe from our newsletter at any time</li>
                    </ul>
                    <p>To exercise any of these rights, please contact us at <a href="mailto:info@devroots.ac.ug" class="text-primary">info@devroots.ac.ug</a>.</p>
                </div>

                <div class="why-item mb-4">
                    <h3>7. External Links</h3>
                    <p>
                        Our website may contain links to external sites. We are not responsible for the privacy practices
                        or content of those sites. We encourage you to review the privacy policies of any third-party
                        websites you visit.
                    </p>
                </div>

                <div class="why-item mb-4">
                    <h3>8. Changes to This Policy</h3>
                    <p>
                        DevRoots Academy reserves the right to update this Privacy Policy at any time. Changes will be posted
                        on this page with an updated revision date. Continued use of our website after any changes constitutes
                        your acceptance of the revised policy.
                    </p>
                </div>

                <div class="why-item">
                    <h3>9. Contact Us</h3>
                    <p>
                        If you have questions or concerns about this Privacy Policy, please contact us:
                    </p>
                    <p class="mb-1"><i class="fas fa-envelope text-primary me-2"></i><a href="mailto:info@devroots.ac.ug" class="text-primary">info@devroots.ac.ug</a></p>
                    <p class="mb-1"><i class="fas fa-phone text-primary me-2"></i><a href="tel:+256705028592" class="text-primary">+256 705 028 592</a></p>
                    <p class="mb-0"><i class="fas fa-map-marker-alt text-primary me-2"></i>Masaka City, Uganda</p>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
