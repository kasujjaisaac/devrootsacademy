<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | DevRoots Academy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">

        <!-- Header -->
        <div class="login-header">
            <h1>DevRoots Academy</h1>
            <p>Management Centre – Admin Access Only</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert success">
                {{ session('status') }}
            </div>
        @endif

        <!-- Errors -->
        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-options">
                <label>
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn-login">
                Login to Admin Panel
            </button>

            @if (Route::has('password.request'))
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                </div>
            @endif
        </form>

        <div class="login-footer">
            <small>© {{ date('Y') }} DevRoots Academy</small>
        </div>

    </div>
</div>

<!-- JS -->
<script src="{{ asset('js/admin-login.js') }}"></script>
</body>
</html>
