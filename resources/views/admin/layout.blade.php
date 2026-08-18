<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Kedai Marjuki\'S')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
        }
        .admin-sidebar {
            width: 260px;
            background-color: #0f172a;
            color: #94a3b8;
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        .admin-sidebar .nav-link {
            color: #94a3b8;
            padding: 0.8rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.25rem;
        }
        .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active {
            color: #ffffff;
            background-color: #dc2626;
        }
        .admin-content {
            flex: 1;
            min-width: 0;
        }
        .badge-stat {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="d-flex min-vh-100">
    <!-- Sidebar -->
    <aside class="admin-sidebar d-none d-lg-block p-3 flex-shrink-0 shadow">
        <div class="d-flex align-items-center gap-2 px-2 py-3 mb-4 border-bottom border-secondary border-opacity-25">
            <div class="bg-danger text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                <i class="fa-solid fa-utensils"></i>
            </div>
            <div>
                <h6 class="fw-bold text-white mb-0">Kedai Marjuki'S</h6>
                <small class="text-xs text-danger fw-semibold">PANEL ADMINISTRATOR</small>
            </div>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <i class="fa-solid fa-bowl-food"></i> Kelola Produk
            </a>
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <i class="fa-solid fa-layer-group"></i> Kelola Kategori
            </a>
            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                <i class="fa-solid fa-receipt"></i> Kelola Pesanan
            </a>
            <a class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                <i class="fa-solid fa-money-check-dollar"></i> Verifikasi Pembayaran
            </a>
            <a class="nav-link {{ request()->routeIs('admin.qris.*') ? 'active' : '' }}" href="{{ route('admin.qris.index') }}">
                <i class="fa-solid fa-qrcode"></i> Pengaturan QRIS
            </a>
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="fa-solid fa-users"></i> Daftar Pelanggan
            </a>
            <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                <i class="fa-solid fa-chart-line"></i> Laporan Penjualan
            </a>

            <hr class="border-secondary border-opacity-25 my-3">

            <a class="nav-link text-warning" href="{{ route('home') }}" target="_blank">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Web Publik
            </a>

            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="nav-link text-danger w-100 text-start border-0 bg-transparent">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout Admin
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-content d-flex flex-column">
        <!-- Top Navbar -->
        <header class="bg-white border-bottom py-3 px-4 shadow-sm sticky-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminMobileSidebar">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h5 class="fw-bold mb-0 text-dark">@yield('page_title', 'Dashboard Administrator')</h5>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill font-weight-bold">
                        <i class="fa-solid fa-user-shield me-1"></i> Admin: {{ auth()->user()->name }}
                    </span>
                </div>
            </div>
        </header>

        <!-- Body -->
        <main class="p-4 flex-grow-1">
            <x-alert />
            @yield('content')
        </main>

        <!-- Footer Admin -->
        <footer class="bg-white border-top py-3 px-4 text-center text-muted small mt-auto">
            &copy; {{ date('Y') }} <strong>Kedai Marjuki'S Administrator</strong> &bull; <span class="fw-bold text-danger">Dibuat oleh Arjunaa</span>
        </footer>
    </div>
</div>

<!-- Mobile Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="adminMobileSidebar" aria-labelledby="adminMobileSidebarLabel">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title text-white fw-bold" id="adminMobileSidebarLabel">Kedai Marjuki'S Admin</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-3">
        <nav class="nav flex-column">
            <a class="nav-link text-white py-2" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>
            <a class="nav-link text-white py-2" href="{{ route('admin.products.index') }}"><i class="fa-solid fa-bowl-food me-2"></i> Kelola Produk</a>
            <a class="nav-link text-white py-2" href="{{ route('admin.categories.index') }}"><i class="fa-solid fa-layer-group me-2"></i> Kelola Kategori</a>
            <a class="nav-link text-white py-2" href="{{ route('admin.orders.index') }}"><i class="fa-solid fa-receipt me-2"></i> Kelola Pesanan</a>
            <a class="nav-link text-white py-2" href="{{ route('admin.payments.index') }}"><i class="fa-solid fa-money-check-dollar me-2"></i> Verifikasi Pembayaran</a>
            <a class="nav-link text-white py-2" href="{{ route('admin.qris.index') }}"><i class="fa-solid fa-qrcode me-2"></i> Pengaturan QRIS</a>
            <a class="nav-link text-white py-2" href="{{ route('admin.users.index') }}"><i class="fa-solid fa-users me-2"></i> Daftar Pelanggan</a>
            <a class="nav-link text-white py-2" href="{{ route('admin.reports.index') }}"><i class="fa-solid fa-chart-line me-2"></i> Laporan Penjualan</a>
        </nav>
    </div>
</div>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
