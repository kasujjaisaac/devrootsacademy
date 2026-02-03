<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Become an Instructor | DevRoots Academy</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Main Styles -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- HEADER -->
<header class="glass-header">
  <div class="container nav-container">
    <div class="logo">DevRoots <span>Academy</span></div>
    <nav>
      <ul class="nav-links">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ url('/courses') }}">Courses</a></li>
        <li><a href="{{ url('/apply-now') }}">Apply Now</a></li>
        <li><a href="{{ route('login') }}" class="btn btn-outline">Login</a></li>
      </ul>
    </nav>
  </div>
</header>

<!-- HERO -->
<section class="instructor-hero">
  <div class="container">
    <h1>Teach. Inspire. Build the Future.</h1>
    <p>Join DevRoots Academy and empower the next generation with real-world tech skills.</p>
  </div>
</section>

<!-- APPLICATION SECTION -->
<section class="instructor-apply">
  <div class="container instructor-grid">

    <!-- INFO PANEL -->
    <div class="instructor-info">
      <h2>Why Teach at DevRoots?</h2>
      <ul>
        <li>✔ Flexible teaching schedules</li>
        <li>✔ Teach practical, real-world skills</li>
        <li>✔ Impact learners across Uganda & beyond</li>
        <li>✔ Earn while growing your professional brand</li>
        <li>✔ Moodle-powered learning environment</li>
      </ul>
    </div>

    <!-- FORM CARD -->
    <div class="instructor-form-card">
      <h2>Instructor Application</h2>

      @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
      @endif

      <form action="{{ route('frontend.instructor.submit') }}" method="POST">
        @csrf

        <div class="form-row">
          <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" required>
          </div>

          <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" name="phone" placeholder="+256 7xx xxx xxx" required>
          </div>

          <div class="form-group">
            <label>Area of Expertise</label>
            <select name="expertise" required>
              <option value="">Select expertise</option>
              <option>Programming</option>
              <option>Web Development</option>
              <option>AI & Machine Learning</option>
              <option>Networking</option>
              <option>Hardware Repair</option>
              <option>Cloud Computing</option>
              <option>Mobile App Development</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group full-width">
            <label>Years of Experience</label>
            <input type="number" name="experience_years" min="0" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group full-width">
            <label>Short Bio</label>
            <textarea name="bio" rows="4" required></textarea>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group full-width">
            <label>Portfolio / LinkedIn / GitHub (Optional)</label>
            <input type="url" name="portfolio">
          </div>
        </div>

        <button type="submit" class="btn-submit">
          Submit Application
        </button>

      </form>
    </div>

  </div>
</section>

</body>
</html>
