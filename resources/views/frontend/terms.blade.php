@extends('layouts.frontend')

@section('title', 'Terms & Conditions | DevRoots Academy')
@section('meta_description', 'Read DevRoots Academy\'s Terms and Conditions governing the use of our website and participation in our training programmes.')

@section('content')

{{-- ===== PAGE HERO ===== --}}
<section class="page-hero">
    <div class="container">
        <h1>Terms &amp; Conditions</h1>
        <p>Last updated: March 2026</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Terms &amp; Conditions</li>
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
                    <h3>1. Acceptance of Terms</h3>
                    <p>
                        By accessing or using the DevRoots Academy website (<a href="https://devroots.ac.ug" class="text-primary">devroots.ac.ug</a>)
                        or submitting an application to our programmes, you agree to be bound by these Terms &amp; Conditions.
                        If you do not agree with any part of these terms, please do not use our website or services.
                    </p>
                </div>

                <div class="why-item mb-4">
                    <h3>2. Use of Website</h3>
                    <p>You agree to use this website only for lawful purposes. You must not:</p>
                    <ul>
                        <li>Use the site in any way that violates applicable local or international laws or regulations</li>
                        <li>Transmit any unsolicited or unauthorised advertising or promotional material</li>
                        <li>Attempt to gain unauthorised access to any part of the website or its related systems</li>
                        <li>Upload or transmit any malicious or harmful content</li>
                    </ul>
                </div>

                <div class="why-item mb-4">
                    <h3>3. Application &amp; Enrolment</h3>
                    <p>
                        Submitting an application form (student or instructor) does not guarantee acceptance.
                        DevRoots Academy reserves the right to accept or decline any application at its sole discretion.
                        Successful applicants will be contacted directly to confirm enrolment and next steps.
                    </p>
                    <p>
                        All information submitted in applications must be truthful and accurate. Providing false information
                        may result in immediate disqualification or removal from a programme without refund.
                    </p>
                </div>

                <div class="why-item mb-4">
                    <h3>4. Fees &amp; Payments</h3>
                    <p>
                        Course fees are communicated at enrolment. Fees must be paid in full or according to an agreed
                        payment schedule before access to course materials is granted. DevRoots Academy reserves the right
                        to update course fees at any time, with prior notice given to enrolled students.
                    </p>
                    <p>
                        Refund requests are assessed on a case-by-case basis. Requests made within 7 days of enrolment and
                        before any course materials are accessed may be eligible for a full refund. After this period, fees
                        are generally non-refundable.
                    </p>
                </div>

                <div class="why-item mb-4">
                    <h3>5. Intellectual Property</h3>
                    <p>
                        All content on this website — including text, images, logos, course materials, and code — is the
                        intellectual property of DevRoots Academy unless otherwise stated. You may not reproduce, distribute,
                        or create derivative works without prior written permission from DevRoots Academy.
                    </p>
                </div>

                <div class="why-item mb-4">
                    <h3>6. Student &amp; Instructor Conduct</h3>
                    <p>All participants in DevRoots Academy programmes are expected to:</p>
                    <ul>
                        <li>Treat fellow students, instructors, and staff with respect and professionalism</li>
                        <li>Not share or distribute course materials outside the programme</li>
                        <li>Attend scheduled sessions punctually and complete assigned work honestly</li>
                        <li>Not engage in any form of academic dishonesty or plagiarism</li>
                    </ul>
                    <p>
                        Violations of the code of conduct may result in suspension or removal from the programme
                        without refund.
                    </p>
                </div>

                <div class="why-item mb-4">
                    <h3>7. Certificates</h3>
                    <p>
                        Certificates of completion are issued to students who successfully complete all course requirements,
                        including assessments and attendance thresholds. DevRoots Academy certificates are evidence of
                        programme completion and do not constitute government-accredited qualifications unless explicitly stated.
                    </p>
                </div>

                <div class="why-item mb-4">
                    <h3>8. Limitation of Liability</h3>
                    <p>
                        DevRoots Academy provides its services "as is" and makes no warranties, express or implied, regarding
                        the accuracy, reliability, or suitability of our content for any particular purpose.
                        To the maximum extent permitted by law, DevRoots Academy shall not be liable for any indirect,
                        incidental, or consequential damages arising from your use of our website or programmes.
                    </p>
                </div>

                <div class="why-item mb-4">
                    <h3>9. Changes to Terms</h3>
                    <p>
                        DevRoots Academy reserves the right to modify these Terms &amp; Conditions at any time. Updated terms
                        will be posted on this page with a revised date. Continued use of our website or services constitutes
                        acceptance of the updated terms.
                    </p>
                </div>

                <div class="why-item">
                    <h3>10. Contact</h3>
                    <p>For questions about these terms, please contact us:</p>
                    <p class="mb-1"><i class="fas fa-envelope text-primary me-2"></i><a href="mailto:info@devroots.ac.ug" class="text-primary">info@devroots.ac.ug</a></p>
                    <p class="mb-1"><i class="fas fa-phone text-primary me-2"></i><a href="tel:+256705028592" class="text-primary">+256 705 028 592</a></p>
                    <p class="mb-0"><i class="fas fa-map-marker-alt text-primary me-2"></i>Masaka City, Uganda</p>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
