<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DevRoots Academy')</title>

    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    @stack('styles')
</head>
<body>

    {{-- HEADER --}}
    @include('frontend.partials.header')

    {{-- PAGE CONTENT --}}

    @yield('content')

    <!-- LIVE CHAT -->
    <div id="live-chat">
        <button class="chat-btn">💬</button>
        <div class="chat-box" style="display:none;flex-direction:column;">
            <div class="chat-header">DevRoots Support</div>
            <div class="chat-messages" id="chat-messages">
                <p>Hello 👋 How can we help you?</p>
            </div>
            <input type="text" id="chat-input" placeholder="Type a message…">
            <button id="send-btn">Send</button>
        </div>
    </div>

    <!-- BACK TO TOP BUTTON -->
    <button id="back-to-top" style="display:none;position:fixed;bottom:30px;right:30px;z-index:999;background:#e63946;color:#fff;border:none;padding:0.7rem 1.2rem;border-radius:50%;font-size:1.5rem;box-shadow:0 2px 8px rgba(0,0,0,0.15);cursor:pointer;">↑</button>

    {{-- FOOTER --}}
    @include('frontend.partials.footer')

    @stack('scripts')
</body>
</html>
