<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — DevRoots Academy</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="ad-login-body">

<div class="ad-login-card">

  {{-- Top: brand + heading --}}
  <div class="ad-login-top">
    <div class="ad-login-brand">
      <img src="{{ asset('images/logo-horizontal.png') }}" alt="DevRoots Academy"
           onerror="this.style.display='none'">
      <span>DevRoots Academy</span>
    </div>
    <h2>Admin Panel</h2>
    <p>Sign in to manage the academy</p>
  </div>

  {{-- Alerts --}}
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

  {{-- Form --}}
  <form method="POST" action="{{ route('admin.login') }}" class="ad-login-form">
    @csrf

    <div class="ad-form-group">
      <label class="ad-label" for="email">Email Address</label>
      <div class="ad-login-input-wrap">
        <i class="fas fa-envelope"></i>
        <input
          type="email"
          id="email"
          name="email"
          class="ad-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
          value="{{ old('email') }}"
          placeholder="admin@devroots.ac.ug"
          required
          autofocus
          autocomplete="email"
        >
      </div>
    </div>

    <div class="ad-form-group">
      <label class="ad-label" for="password">Password</label>
      <div class="ad-login-input-wrap">
        <i class="fas fa-lock"></i>
        <input
          type="password"
          id="password"
          name="password"
          class="ad-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
          placeholder="••••••••"
          required
          autocomplete="current-password"
        >
      </div>
    </div>

    <div class="ad-login-check">
      <input type="checkbox" id="remember" name="remember">
      <label for="remember">Keep me signed in</label>
    </div>

    <button type="submit" class="btn-ad-login">
      <i class="fas fa-right-to-bracket" style="margin-right:6px"></i>
      Sign In
    </button>
  </form>

  {{-- Footer --}}
  <div class="ad-login-footer">
    <a href="{{ route('home') }}">
      <i class="fas fa-arrow-left" style="margin-right:4px;font-size:0.6875rem"></i>
      Back to site
    </a>
    <span style="font-size:0.6875rem;color:#9ca3af">© {{ date('Y') }} DevRoots Academy</span>
  </div>

</div>

</body>
</html>
