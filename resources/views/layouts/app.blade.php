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
                        <ul class="navbar-nav ms-auto d-flex align-items-center">
                            <li class="nav-item me-2">
                                <a class="btn btn-outline-secondary" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
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

    @auth
    @else
        @include('components.login-modal')
    @endauth

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

        // Show login modal if redirected with show_login_modal flag
        @if(session('show_login_modal'))
        document.addEventListener('DOMContentLoaded', function() {
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        });
        @endif

        // Handle Book Now buttons for guest users
        document.addEventListener('DOMContentLoaded', function() {
            // Find all Book Now buttons at page load
            const bookButtons = document.querySelectorAll('.book-now-btn');
            
            // Add click event listeners to each button
            bookButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    @auth
                        // If user is logged in, go to the book URL
                        const bookUrl = this.getAttribute('data-book-url');
                        if (bookUrl) {
                            window.location.href = bookUrl;
                        }
                    @else
                        // If user is not logged in, prevent default and show login modal
                        e.preventDefault();
                        
                        // Store the room ID for after login
                        const roomId = this.getAttribute('data-room-id');
                        if (roomId) {
                            sessionStorage.setItem('intended_room_booking', roomId);
                        }
                        
                        // Show login modal
                        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                        loginModal.show();
                    @endauth
                });
            });
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
        
        /* Custom navbar styles */
        .navbar .btn-primary {
            background-color: #A7C5BD;
            border-color: #A7C5BD;
            color: #2E3B4E;
        }
        
        .navbar .btn-primary:hover {
            background-color: #96b5ad;
            border-color: #96b5ad;
            color: #2E3B4E;
        }
        
        .navbar .btn-outline-secondary {
            color: #2E3B4E;
            border-color: #d1d1d1;
        }
        
        .navbar .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            color: #2E3B4E;
        }
    </style>
</body>
</html>