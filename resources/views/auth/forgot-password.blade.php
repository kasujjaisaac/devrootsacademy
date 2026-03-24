<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Student Password - DevRoots Academy</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="ad-login-body" style="background:linear-gradient(135deg,#f8fafc 0%,#fff7ed 100%);">

<div class="ad-login-card">
  <div class="ad-login-top">
    <div class="ad-login-brand">
      <img src="{{ asset('images/logo-horizontal.png') }}" alt="DevRoots Academy" onerror="this.style.display='none'">
      <span>DevRoots Academy</span>
    </div>
    <h2>Reset Password</h2>
    <p>Enter your student email address and we will send you a password setup link.</p>
  </div>

  @if (session('status') || $errors->any())
  <div style="padding: 16px 36px 0;">
    @if (session('status'))
      <div class="ad-alert ad-alert-info">
        <i class="fas fa-info-circle"></i>
        {{ session('status') }}
      </div>
    @endif
    @if ($errors->any())
      <div class="ad-alert ad-alert-error">
        <i class="fas fa-circle-exclamation"></i>
        <div>
          @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
  @endif

  <form method="POST" action="{{ route('password.email') }}" class="ad-login-form">
    @csrf

    <div class="ad-form-group">
      <label class="ad-label" for="email">Email Address</label>
      <div class="ad-login-input-wrap">
        <i class="fas fa-envelope"></i>
        <input type="email" id="email" name="email" class="ad-input" value="{{ old('email') }}" placeholder="student@example.com" required autofocus autocomplete="email">
      </div>
    </div>

    <button type="submit" class="btn-ad-login">
      <i class="fas fa-paper-plane" style="margin-right:6px"></i>
      Send Reset Link
    </button>
  </form>

  <div class="ad-login-footer" style="justify-content:space-between;">
    <a href="{{ route('login') }}">Back to student login</a>
    <a href="{{ route('home') }}">Return to website</a>
  </div>
</div>

</body>
</html>
