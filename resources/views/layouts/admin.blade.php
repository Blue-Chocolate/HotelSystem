<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Custom styles to match guest layout --}}
    <style>
        body {
            background-color: rgb(243 244 246);
        }
        .navbar {
            background-color: rgb(31 41 55) !important;
        }
        .container {
            background-color: white;
            border-radius: 0.375rem;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
        }
        .nav-link {
            color: rgb(156 163 175) !important;
            transition: color 0.2s;
        }
        .nav-link:hover {
            color: rgb(209 213 219) !important;
        }
        .navbar-brand {
            color: rgb(209 213 219) !important;
        }
        @media (prefers-color-scheme: dark) {
            body {
                background-color: rgb(17 24 39);
                color: rgb(243 244 246);
            }
            .container {
                background-color: rgb(31 41 55);
            }
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Hotel Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.reserve.index') }}">Reservations</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.guests.index') }}">Guests</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.rooms.index') }}">Rooms</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.revenue.index') }}">Revenue</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <div class="container py-4 mt-4">
        @yield('content')
    </div>

    {{-- Logout Form --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    {{-- Bootstrap JS CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
