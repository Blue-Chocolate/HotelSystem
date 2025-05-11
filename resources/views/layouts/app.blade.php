<!DOCTYPE html>
<html lang="en" data-bs-theme="light"> {{-- Default: light mode --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel System</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">


    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">🏨 Hotel System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    {{-- Light/Dark toggle --}}
                    <li class="nav-item me-3">
                        <button id="toggle-theme" class="btn btn-outline-secondary btn-sm">
                            🌓 Toggle Mode
                        </button>
                    </li>

                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rooms.index') }}">Rooms</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('booking.my-reservations') }}">My Reservations</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main content --}}
    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Light/Dark Mode Script --}}
    <script>
        const html = document.documentElement;
        const toggleBtn = document.getElementById('toggle-theme');

        function applyTheme(mode) {
            html.setAttribute('data-bs-theme', mode);
            localStorage.setItem('theme', mode);
        }

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(savedTheme);

        // Toggle on click
        toggleBtn.addEventListener('click', () => {
            const newTheme = html.getAttribute('data-bs-theme') === 'light' ? 'dark' : 'light';
            applyTheme(newTheme);
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>

</body>
</html>
