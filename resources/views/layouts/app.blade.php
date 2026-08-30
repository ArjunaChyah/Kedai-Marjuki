<!DOCTYPE html>
<html lang="id" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kuliner Rumahan Kedai Marjuki\'S')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS (Offline & Online) -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .bg-danger {
            background-color: #dc2626 !important;
        }
        .btn-danger {
            background-color: #dc2626;
            border-color: #dc2626;
        }
        .btn-danger:hover {
            background-color: #b91c1c;
            border-color: #b91c1c;
        }
        .text-danger {
            color: #dc2626 !important;
        }
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -10px rgba(0,0,0,0.15) !important;
        }
        .text-line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .fs-7 {
            font-size: 0.875rem;
        }
        .text-xs {
            font-size: 0.75rem;
        }
        .hero-banner {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.78) 0%, rgba(15, 23, 42, 0.92) 100%), url('{{ asset('foto_website/warung.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
            padding: 5.5rem 0;
            border-radius: 0 0 2.5rem 2.5rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        }
        .backdrop-blur {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .menu-aesthetic-section {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.92) 0%, rgba(30, 41, 59, 0.88) 60%, rgba(51, 65, 85, 0.92) 100%), url('{{ asset('foto_website/etalase.jpg') }}');
            background-size: cover;
            background-position: center;
            border-radius: 2rem;
            padding: 3.5rem 2.5rem;
            box-shadow: 0 20px 45px -15px rgba(15, 23, 42, 0.5);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .menu-aesthetic-section::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(220, 38, 38, 0.35) 0%, rgba(245, 158, 11, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* ==========================================================================
           RESPONSIVE BREAKPOINTS (SMARTPHONE, TABLET, DESKTOP)
           Format ramah pemula untuk kemudahan belajar siswa SMK
           ========================================================================== */
        
        /* Smartphone (< 576px) */
        @media (max-width: 575.98px) {
            .hero-banner {
                padding: 3rem 1rem;
                border-radius: 0 0 1.5rem 1.5rem;
                text-align: center;
            }
            .menu-aesthetic-section {
                padding: 2rem 1rem;
                border-radius: 1.25rem;
            }
            .navbar-brand {
                font-size: 1.25rem !important;
            }
            .card-body {
                padding: 1.25rem;
            }
        }

        /* Tablet (576px - 991.98px) */
        @media (min-width: 576px) and (max-width: 991.98px) {
            .hero-banner {
                padding: 4rem 2rem;
                border-radius: 0 0 2rem 2rem;
            }
            .menu-aesthetic-section {
                padding: 2.5rem 1.75rem;
                border-radius: 1.5rem;
            }
        }

        /* Desktop (>= 992px) */
        @media (min-width: 992px) {
            .hero-banner {
                padding: 5.5rem 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column h-100">

    <x-navbar />

    <main class="flex-shrink-0 mb-5">
        @yield('content')
    </main>

    <x-footer />

    <!-- Bootstrap 5.3 JS Bundle (Offline & Online) -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
