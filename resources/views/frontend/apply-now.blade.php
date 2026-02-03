<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply Now | DevRoots Academy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Red-themed CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- HEADER -->
<header class="glass-header" style="background-color: #ffffff; color: white;">
    <div class="container nav-container">
        <div class="logo">DevRoots <span>Academy</span></div>
        <nav>
            <ul class="nav-links">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/courses') }}">Courses</a></li>
                <li><a href="{{ url('/apply-now') }}" class="active">Apply Now</a></li>
                <li><a href="{{ url('/login') }}" class="btn btn-outline">Login</a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- HERO -->
<section class="instructor-hero" style="background-color: #FF4C4C; color: white; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1>Start Your Learning Journey</h1>
        <p>Apply today and gain hands-on tech skills designed for real-world impact.</p>
    </div>
</section>

<!-- APPLICATION SECTION -->
<section class="instructor-apply" style="padding: 50px 0; background-color: #FFF5F5;">
    <div class="container instructor-grid" style="display: flex; gap: 40px; flex-wrap: wrap;">

        <!-- INFO PANEL -->
        <div class="instructor-info" style="flex: 1; min-width: 300px;">
            <h2 style="color: #8B0000;">Why Learn at DevRoots?</h2>
            <ul style="list-style: none; padding-left: 0; color: #333;">
                <li>✔ Practical, hands-on training</li>
                <li>✔ Industry-relevant courses</li>
                <li>✔ Beginner to advanced learning paths</li>
                <li>✔ Supportive mentors & instructors</li>
                <li>✔ Moodle-powered learning platform</li>
            </ul>
        </div>

        <!-- FORM CARD -->
        <div class="instructor-form-card" style="flex: 1; min-width: 300px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <h2 style="color: #8B0000;">Student Application</h2>

            @if(session('success'))
                <div class="success-message" style="background: #DFF2BF; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('frontend.apply.submit') }}" method="POST">
                @csrf

                <div class="form-row" style="display: flex; gap: 15px; margin-bottom: 15px;">
                    <div class="form-group" style="flex:1;">
                        <label>Full Name</label>
                        <input type="text" name="full_name" placeholder="Your full name" required>
                    </div>

                    <div class="form-group" style="flex:1;">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Choose a username">
                    </div>
                </div>

                <div class="form-row" style="display: flex; gap: 15px; margin-bottom: 15px;">
                    <div class="form-group" style="flex:1;">
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="you@example.com">
                    </div>

                    <div class="form-group" style="flex:1;">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" placeholder="+256 7xx xxx xxx" required>
                    </div>
                </div>

                <div class="form-row" style="display: flex; gap: 15px; margin-bottom: 15px;">
                    <div class="form-group" style="flex:1;">
                        <label>Date of Birth</label>
                        <input type="date" name="dob">
                    </div>

                    <div class="form-group" style="flex:1;">
                        <label>Location</label>
                        <input type="text" name="location" placeholder="City, Country">
                    </div>
                </div>

                <div class="form-row" style="margin-bottom: 15px;">
                    <div class="form-group full-width">
                        <label>Select Course</label>
                        <select name="course_interest" required>
                            <option value="">Choose your course</option>
                            <option>Programming Fundamentals</option>
                            <option>Web Development</option>
                            <option>AI & Machine Learning</option>
                            <option>Mobile App Development</option>
                            <option>Cloud Computing</option>
                            <option>Networking Essentials</option>
                            <option>Computer Repair & Maintenance</option>
                            <option>Internet of Things (IoT)</option>
                        </select>
                    </div>
                </div>

                <div class="form-row" style="margin-bottom: 15px;">
                    <div class="form-group full-width">
                        <label>Why do you want to join? (Optional)</label>
                        <textarea name="goals" rows="3" placeholder="Tell us your learning goals..."></textarea>
                    </div>
                </div>

                <div class="form-row terms" style="margin-bottom: 15px;">
                    <input type="checkbox" name="terms" required>
                    <label>I agree to the <a href="#" style="color:#8B0000;">terms & conditions</a>.</label>
                </div>

                <button type="submit" class="btn-submit" style="background-color:#8B0000; color:white; padding:10px 20px; border:none; border-radius:5px; cursor:pointer;">
                    Submit Application
                </button>

            </form>
        </div>

    </div>
</section>

<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
