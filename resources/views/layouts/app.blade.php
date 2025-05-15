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