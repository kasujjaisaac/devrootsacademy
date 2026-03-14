{{-- ===== SITE FOOTER ===== --}}
<footer class="site-footer">
    <div class="container">
        <div class="row g-4 g-lg-5">

            {{-- Column 1: Brand --}}
            <div class="col-lg-4 col-md-6">
                <img src="{{ asset('images/logo-horizontal.png') }}"
                     alt="DevRoots Academy"
                     class="footer-brand-logo">
                <p class="footer-tagline">
                    Empowering IT innovators in Masaka with practical, hands-on tech education.
                    Learn programming, hardware repair, networking, and more.
                </p>
                <div class="footer-social">
                    <a href="#" target="_blank" rel="noopener" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" target="_blank" rel="noopener" aria-label="Twitter / X">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="#" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" target="_blank" rel="noopener" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" target="_blank" rel="noopener" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            {{-- Column 2: Quick Links --}}
            <div class="col-lg-2 col-md-3 col-6">
                <h4 class="footer-heading">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}"><i class="fas fa-angle-right"></i> Home</a></li>
                    <li><a href="{{ route('courses.index') }}"><i class="fas fa-angle-right"></i> Courses</a></li>
                    <li><a href="{{ route('about') }}"><i class="fas fa-angle-right"></i> About Us</a></li>
                    <li><a href="{{ route('partners') }}"><i class="fas fa-angle-right"></i> Partners</a></li>
                    <li><a href="{{ route('contact') }}"><i class="fas fa-angle-right"></i> Contact</a></li>
                </ul>
            </div>

            {{-- Column 3: Programs --}}
            <div class="col-lg-2 col-md-3 col-6">
                <h4 class="footer-heading">Programs</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('courses.index', ['category' => 'Programming']) }}"><i class="fas fa-angle-right"></i> Programming</a></li>
                    <li><a href="{{ route('courses.index', ['category' => 'Web Development']) }}"><i class="fas fa-angle-right"></i> Web Dev</a></li>
                    <li><a href="{{ route('courses.index', ['category' => 'Hardware']) }}"><i class="fas fa-angle-right"></i> IT Support</a></li>
                    <li><a href="{{ route('courses.index', ['category' => 'Networking']) }}"><i class="fas fa-angle-right"></i> Networking</a></li>
                    <li><a href="{{ route('courses.index', ['category' => 'Cloud']) }}"><i class="fas fa-angle-right"></i> Cloud</a></li>
                </ul>
            </div>

            {{-- Column 4: Contact + Newsletter --}}
            <div class="col-lg-4 col-md-6">
                <h4 class="footer-heading">Contact Us</h4>

                <div class="footer-contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Masaka City, Uganda</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-phone"></i>
                    <a href="tel:+256705028592">+256 705 028 592</a>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:info@devroots.ac.ug">info@devroots.ac.ug</a>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-clock"></i>
                    <span>Mon–Fri 8 AM–6 PM &bull; Sat 9 AM–1 PM</span>
                </div>

                <h4 class="footer-heading mt-4">Newsletter</h4>
                <form id="newsletterForm" class="footer-newsletter" novalidate>
                    @csrf
                    <div class="input-group">
                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Your email address"
                               required
                               aria-label="Email address">
                        <button type="submit" class="btn-subscribe">Subscribe</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <p>&copy; {{ date('Y') }} DevRoots Academy. All rights reserved.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('contact') }}">Privacy Policy</a>
                    <a href="{{ route('contact') }}">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </div>

</footer>
{{-- ===== END FOOTER ===== --}}
