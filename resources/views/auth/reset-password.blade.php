<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Student Password - DevRoots Academy</title>
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
    <h2>Create Your Password</h2>
    <p>Set your student portal password to continue to sign in at <strong>{{ url('/student') }}</strong>.</p>
  </div>

  @if ($errors->any())
  <div style="padding: 16px 36px 0;">
    <div class="ad-alert ad-alert-error">
      <i class="fas fa-circle-exclamation"></i>
      <div>
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    </div>
  </div>
  @endif

  <form method="POST" action="{{ route('password.store') }}" class="ad-login-form">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="ad-form-group">
      <label class="ad-label" for="email">Email Address</label>
      <div class="ad-login-input-wrap">
        <i class="fas fa-envelope"></i>
        <input type="email" id="email" name="email" class="ad-input" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
      </div>
    </div>

    <div class="ad-form-group">
      <label class="ad-label" for="password">New Password</label>
      <div class="ad-login-input-wrap">
        <i class="fas fa-lock"></i>
        <input type="password" id="password" name="password" class="ad-input" required autocomplete="new-password">
      </div>
    </div>

    <div class="ad-form-group">
      <label class="ad-label" for="password_confirmation">Confirm Password</label>
      <div class="ad-login-input-wrap">
        <i class="fas fa-shield-halved"></i>
        <input type="password" id="password_confirmation" name="password_confirmation" class="ad-input" required autocomplete="new-password">
      </div>
    </div>

    <button type="submit" class="btn-ad-login">
      <i class="fas fa-key" style="margin-right:6px"></i>
      Save Password
    </button>
  </form>

  <div class="ad-login-footer" style="justify-content:space-between;">
    <a href="{{ route('login') }}">Back to student login</a>
    <a href="{{ route('home') }}">Return to website</a>
  </div>
</div>

</body>
</html>
