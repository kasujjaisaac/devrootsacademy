<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevRoots Academy | Growing IT Talent in Masaka</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- ================= HEADER ================= -->
<header class="glass-header">
    <div class="container nav-container">
        <div class="logo">
            DevRoots <span>Academy</span>
        </div>

        <nav>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="{{ route('courses.index') }}">Courses</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#testimonials">Stories</a></li>
                <li><a href="#partners">Partners</a></li>
                <li><a href="{{ route('apply.now') }}">Apply Now</a></li>
                <li><a href="moodle-login.html" class="btn btn-outline">Login</a></li>
            </ul>
        </nav>

        <div class="hamburger">
            <span></span><span></span><span></span>
        </div>
    </div>
</header>

<!-- ================= HERO ================= -->
    <section class="hero">
        <div class="hero-overlay"></div>

        <div class="container hero-content">
            <h1>Building Africa’s Next<br><span>Tech Innovators</span></h1>
            <p>
                Practical programming, hardware repair, networking, and innovation —
                taught by doing, not just theory.
            </p>

            <div class="hero-actions">
                <a href="{{ route('courses.index') }}" class="btn btn-primary">Explore Courses</a>
                <a href="{{ route('instructor.form') }}" class="btn btn-outline">Become An Instructor</a>
            </div>
        </div>
    </section>
    
<!-- ================= ABOUT / WHY DEVROOTS ================= -->
    <section id="about" class="about">
        <div class="container about-container">
            <h2 class="section-title">Why DevRoots Academy?</h2>

            <div class="about-columns">
                <!-- Left Column -->
                <div class="about-left">
                    <p>
                        We believe strong roots create strong innovators. DevRoots Academy exists to equip learners in Masaka with hands-on IT skills, mentorship, and confidence to build solutions that matter.
                    </p>
                </div>

                <!-- Divider -->
                <div class="about-divider"></div>

                <!-- Right Column -->
                <div class="about-right">
                    <ul class="about-points">
                        <li>Practical, project-based learning</li>
                        <li>Industry-aligned curriculum</li>
                        <li>Mentorship & innovation culture</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

<!-- ================= FEATURED COURSES ================= --> 
    <section id="courses" class="featured-courses">
        <div class="container">
            <h2>Featured Courses</h2>
            <p class="section-subtitle">
                Industry-relevant programs designed to build practical and job-ready IT skills.
            </p>

            <!-- Courses Grid -->
            <div class="courses-grid">

                <!-- Course 1 -->
                <div class="course-card">
                    <div class="course-image">
                        <img src="images/courses/programming.png" alt="Programming Fundamentals">
                        <div class="course-tags">
                            <span class="tag">8 Weeks</span>
                            <span class="tag level">Beginner</span>
                        </div>
                    </div>
                    <h3>Programming Fundamentals</h3>
                    <p>Learn logic, problem-solving, and Python basics through hands-on coding.</p>
                    <a href="courses/programming_fundamentals.html" class="apply-btn">Apply Now <span class="finger">👉</span></a>
                </div>

                <!-- Course 2 -->
                <div class="course-card">
                    <div class="course-image">
                        <img src="images/courses/web-development.png" alt="Web Development">
                        <div class="course-tags">
                            <span class="tag">12 Weeks</span>
                            <span class="tag level">Intermediate</span>
                        </div>
                    </div>
                    <h3>Web Development</h3>
                    <p>Build modern, responsive websites using HTML, CSS, JavaScript, and Git.</p>
                    <a href="#contact" class="apply-btn">Apply Now <span class="finger">👉</span></a>
                </div>

                <!-- Course 3 -->
                <div class="course-card">
                    <div class="course-image">
                        <img src="images/courses/hardware.png" alt="Computer Repair & Maintenance">
                        <div class="course-tags">
                            <span class="tag">10 Weeks</span>
                            <span class="tag level">Beginner</span>
                        </div>
                    </div>
                    <h3>Computer Repair & Maintenance</h3>
                    <p>Diagnose, repair, and maintain computers with real hands-on lab practice.</p>
                    <a href="#contact" class="apply-btn">Apply Now <span class="finger">👉</span></a>
                </div>

                <!-- Course 4 -->
                <div class="course-card">
                    <div class="course-image">
                        <img src="images/courses/ai.png" alt="Artificial Intelligence & Machine Learning">
                        <div class="course-tags">
                            <span class="tag">14 Weeks</span>
                            <span class="tag level advanced">Advanced</span>
                        </div>
                    </div>
                    <h3>AI & Machine Learning</h3>
                    <p>Understand AI concepts and build intelligent systems using real datasets.</p>
                    <a href="#contact" class="apply-btn">Apply Now <span class="finger">👉</span></a>
                </div>

                <!-- Course 5 -->
                <div class="course-card">
                    <div class="course-image">
                        <img src="images/courses/networking.png" alt="Networking Essentials">
                        <div class="course-tags">
                            <span class="tag">10 Weeks</span>
                            <span class="tag level">Beginner</span>
                        </div>
                    </div>
                    <h3>Networking Essentials</h3>
                    <p>Learn networking fundamentals, protocols, and hands-on configuration skills.</p>
                    <a href="#contact" class="apply-btn">Apply Now <span class="finger">👉</span></a>
                </div>

                <!-- Course 6 -->
                <div class="course-card">
                    <div class="course-image">
                        <img src="images/courses/mobile-apps.png" alt="Mobile App Development">
                        <div class="course-tags">
                            <span class="tag">12 Weeks</span>
                            <span class="tag level">Intermediate</span>
                        </div>
                    </div>
                    <h3>Mobile App Development</h3>
                    <p>Create engaging mobile applications for Android using Java and Kotlin.</p>
                    <a href="#contact" class="apply-btn">Apply Now <span class="finger">👉</span></a>
                </div>

                <!-- Course 7 -->
                <div class="course-card">
                    <div class="course-image">
                        <img src="images/courses/cloud-computing.png" alt="Cloud Computing Basics">
                        <div class="course-tags">
                            <span class="tag">8 Weeks</span>
                            <span class="tag level">Beginner</span>
                        </div>
                    </div>
                    <h3>Cloud Computing Basics</h3>
                    <p>Explore cloud concepts and services with hands-on labs on AWS and Azure.</p>
                    <a href="#contact" class="apply-btn">Apply Now <span class="finger">👉</span></a>
                </div>

                <!-- Course 8 -->
                <div class="course-card">
                    <div class="course-image">
                        <img src="images/courses/iot.png" alt="Internet of Things (IoT)">
                        <div class="course-tags">
                            <span class="tag">14 Weeks</span>
                            <span class="tag level advanced">Advanced</span>
                        </div>
                    </div>
                    <h3>Internet of Things (IoT)</h3>
                    <p>Learn to connect devices, collect data, and build smart IoT solutions.</p>
                    <a href="#contact" class="apply-btn">Apply Now <span class="finger">👉</span></a>
                </div>

            </div>

            <!-- View All Courses CTA -->
            <div class="view-all-courses">
                <a href="courses.html" class="btn-outline">View All Courses</a>
            </div>

        </div>
    </section>

<!-- ================= TESTIMONIALS ================= -->
<section id="testimonials" class="testimonials">
  <div class="container">
    <h2 class="section-title">What Our Students Say</h2>
    <p class="section-subtitle">
      Real stories from learners who transformed their skills with DevRoots Academy.
    </p>

    <div class="testimonial-slider">

      <!-- Slide 1 -->
      <div class="testimonial-slide active">
        <p class="testimonial-text">
          DevRoots Academy gave me the confidence to code, solve real problems, and believe in my future as a software developer.
        </p>
        <div class="testimonial-author">
          <img src="images/testimonials/gloria.jpg" alt="Gloria K.">
          <div>
            <h4>Gloria K.</h4>
            <span class="testimonial-role">Junior Software Developer</span>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="testimonial-slide">
        <p class="testimonial-text">
          The trainers are practical, supportive, and industry-focused. I now build real applications with confidence.
        </p>
        <div class="testimonial-author">
          <img src="images/testimonials/james.jpg" alt="James M.">
          <div>
            <h4>James M.</h4>
            <span class="testimonial-role">IT Support Specialist</span>
          </div>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="testimonial-slide">
        <p class="testimonial-text">
          DevRoots is not just an academy — it is a community that pushes you to grow, innovate, and succeed.
        </p>
        <div class="testimonial-author">
          <img src="images/testimonials/sarah.jpg" alt="Sarah N.">
          <div>
            <h4>Sarah N.</h4>
            <span class="testimonial-role">UI/UX Designer</span>
          </div>
        </div>
      </div>

      <!-- Navigation -->
      <button class="prev">&#10094;</button>
      <button class="next">&#10095;</button>

      <!-- Dots -->
      <div class="dots">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
      </div>
    </div>
</section>


<!-- ================= LIVE CHAT ================= -->
    <div id="live-chat">
        <button class="chat-btn">💬</button>
        <div class="chat-box">
            <div class="chat-header">DevRoots Support</div>
            <div class="chat-messages" id="chat-messages">
                <p>Hello 👋 How can we help you?</p>
            </div>
            <input type="text" id="chat-input" placeholder="Type a message…">
            <button id="send-btn">Send</button>
        </div>
    </div>

<!-- ================= OUR PARTNERS ================= -->
<section id="partners" class="partners">
    <div class="container">
        <h2 class="section-title">Our Partners</h2>
        <p class="section-subtitle">
            We collaborate with industry leaders to bring you the best learning opportunities.
        </p>

        <div class="partners-grid">
            <!-- Row 1 -->
            <div class="partner-card"><img src="images/partners/butende.png" alt="Partner 1"></div>
            <div class="partner-card"><img src="images/partners/mru.png" alt="Partner 2"></div>
            <div class="partner-card"><img src="images/partners/mahipso.png" alt="Partner 3"></div>
            <div class="partner-card"><img src="images/partners/adic.png" alt="Partner 4"></div>
            <div class="partner-card"><img src="images/partners/masakacity.png" alt="Partner 5"></div>
            <div class="partner-card"><img src="images/partners/nita.svg" alt="Partner 6"></div>
        </div>
    </div>
</section>

<!-- BACK TO TOP -->
<button id="back-to-top">↑</button>

<!-- ================= FOOTER ================= -->
<footer class="footer">
  <div class="footer-container">

    <!-- Column 1: Brand & About -->
    <div class="footer-column footer-brand">
      <h2>DevRoots Academy</h2>
      <p>Empowering IT innovators in Masaka. Learn programming, IT repair, software development, and more.</p>
      <div class="social-links">
        <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
      </div>
    </div>

    <!-- Column 2: Quick Links -->
    <div class="footer-column">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Courses</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Blog</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>

    <!-- Column 3: Programs / Departments -->
    <div class="footer-column">
      <h3>Programs</h3>
      <ul>
        <li><a href="#">Programming</a></li>
        <li><a href="#">IT Support & Repair</a></li>
        <li><a href="#">Cybersecurity</a></li>
        <li><a href="#">UI/UX Design</a></li>
        <li><a href="#">Mobile Development</a></li>
      </ul>
    </div>

    <!-- Column 4: Contact Info -->
    <div class="footer-column">
      <h3>Contact</h3>
      <ul>
        <li><i class="fas fa-map-marker-alt"></i> Masaka, Uganda</li>
        <li><i class="fas fa-phone"></i> +256 705 028 592</li>
        <li><i class="fas fa-envelope"></i> info@devroots.ac.ug</li>
        <li><i class="fas fa-globe"></i> www.devrootsacademy.ac.ug</li>
      </ul>
    </div>

    <!-- Column 5: Newsletter -->
    <div class="footer-column">
      <h3>Newsletter</h3>
      <p>Subscribe for updates, free tutorials, and tips:</p>
      <form id="newsletterForm">
        <input type="email" placeholder="Your email" required>
        <button type="submit">Subscribe</button>
      </form>
    </div>

  </div>

  <div class="footer-bottom">
    <p>&copy; 2026 DevRoots Academy. All rights reserved.</p>
    <div class="footer-legal">
      <a href="#">Privacy Policy</a> | 
      <a href="#">Terms & Conditions</a>
    </div>
  </div>
</footer>


<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
