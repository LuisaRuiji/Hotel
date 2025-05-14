<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Hotel Room Reservation') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #2E3B4E;
            --secondary-color: #8E9A92;
            --accent-color: #A7C5BD;
            --light-bg: #F5F7F6;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,.08);
        }

        .navbar-brand {
            color: var(--primary-color);
            font-weight: 700;
        }

        .nav-link {
            color: var(--primary-color);
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--accent-color);
        }

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: white;
        }

        .btn-outline-primary {
            border-color: var(--accent-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: var(--primary-color);
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: var(--fs-lg);
            }
            
            .nav-link {
                font-size: var(--fs-base);
            }

            .btn {
                font-size: var(--fs-sm);
                padding: var(--spacing-xs) var(--spacing-sm);
            }
        }
    </style>

    <!-- Additional Styles -->
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">Hotel Name</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#rooms">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-responsive">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-responsive">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-responsive">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-responsive">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-light py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-sm-6 col-md-3">
                    <h5 class="fw-bold mb-3 responsive-heading" style="color: var(--primary-color);">About Us</h5>
                    <p class="text-muted responsive-text">Experience luxury and comfort in our carefully curated rooms and suites.</p>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h5 class="fw-bold mb-3 responsive-heading" style="color: var(--primary-color);">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#rooms" class="text-decoration-none text-muted responsive-text">Rooms</a></li>
                        <li class="mb-2"><a href="#amenities" class="text-decoration-none text-muted responsive-text">Amenities</a></li>
                        <li class="mb-2"><a href="#contact" class="text-decoration-none text-muted responsive-text">Contact</a></li>
                        <li class="mb-2"><a href="#booking" class="text-decoration-none text-muted responsive-text">Book Now</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h5 class="fw-bold mb-3 responsive-heading" style="color: var(--primary-color);">Contact</h5>
                    <ul class="list-unstyled text-muted responsive-text">
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +1 234 567 890</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@hotel.com</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Hotel Street</li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h5 class="fw-bold mb-3 responsive-heading" style="color: var(--primary-color);">Follow Us</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-muted fs-5"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-muted fs-5"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-muted fs-5"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-top mt-4 pt-4 text-center text-muted responsive-text">
                <p>&copy; {{ date('Y') }} Hotel Name. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>