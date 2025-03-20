<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon & Spa Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Link Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Salon & Spa</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @if(Auth::check())
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                            Logout
                        </a>
                    </li>
                    @if (Auth::check() && Auth::user()->role === 'admin')
                    <a href="" class="btn btn-secondary">Admin Dashboard</a>
                    @endif

                    @if (Auth::check() && Auth::user()->role === 'client')
                    <a href="{{ route('client.dashboard') }}" class="">Client Dashboard</a>
                    @endif
                    @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>

<body>
    @if (session('status'))
    <div id="notification" class="notification">
        {{ session('status') }}
    </div>
    @endif
    <div class="w-100 mt-0">
        @yield('content')
    </div>
</body>

</html>