<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hotel Management') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @stack('styles')

    <!-- Scripts -->
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</head>
<body>
    <div class="min-vh-100 bg-light">
        @auth
            @if(auth()->user()->role === 'receptionist')
                @include('layouts.receptionist-navigation')
            @elseif(auth()->user()->role === 'admin')
                @include('layouts.admin-navigation')
            @else
                @include('layouts.customer-navigation')
            @endif
        @else
            <!-- Guest Navigation Bar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Hotel Management') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#guestNavbarNav" 
                            aria-controls="guestNavbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="guestNavbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#rooms">Rooms</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#services">Services</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-sm" style="background-color: #A7C5BD; color: #2E3B4E;" href="{{ route('register') }}">Register</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        @endauth

        <!-- Main Content -->
        <main id="content" class="py-4">
            @yield('content')
        </main>
    </div>

    @stack('scripts')

    <script>
        // Setup HTMX CSRF token
        document.body.addEventListener('htmx:configRequest', function(event) {
            event.detail.headers['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
        });

        // Show loading indicator
        htmx.on('htmx:beforeRequest', function(event) {
            const target = event.detail.target;
            if (target.id === 'content') {
                target.classList.add('htmx-loading');
            }
        });

        // Hide loading indicator
        htmx.on('htmx:afterRequest', function(event) {
            const target = event.detail.target;
            if (target.id === 'content') {
                target.classList.remove('htmx-loading');
            }
        });
    </script>

    <style>
        .htmx-loading {
            opacity: 0.5;
            transition: opacity 200ms ease-in;
        }
        
        .htmx-settling {
            opacity: 0;
        }
        
        .htmx-request {
            animation: fade-in 200ms ease-in;
        }
        
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</body>
</html>