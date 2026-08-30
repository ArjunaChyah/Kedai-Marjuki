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
    
    <!-- Bootstrap 5.3 CSS (Offline & Online) -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.94) 100%), url('{{ asset('foto_website/warung.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #1e293b;
        }
        .admin-sidebar {
            width: 260px;
            background-color: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
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
            background: rgba(241, 245, 249, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
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
        .toast-container-custom {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .pulse-live {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #22c55e;
            border-radius: 50%;
            animation: pulse-ring 1.5s infinite;
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Toast Notification Container -->
<div class="toast-container-custom" id="toastContainer"></div>

<div class="d-flex min-vh-100">
    <!-- Sidebar -->
    <aside class="admin-sidebar d-none d-lg-block p-3 flex-shrink-0 shadow">
        <div class="d-flex align-items-center gap-2 px-2 py-3 mb-4 border-bottom border-secondary border-opacity-25">
            <div class="bg-danger text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                <i class="fa-solid fa-utensils"></i>
            </div>
            <div>
                <h6 class="fw-bold text-white mb-0">Kedai Marjuki'S</h6>
                <small class="text-xs text-danger fw-semibold d-flex align-items-center gap-1">
                    <span class="pulse-live"></span> PANEL LIVE ADMIN
                </small>
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
            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }} justify-content-between" href="{{ route('admin.orders.index') }}">
                <span><i class="fa-solid fa-receipt me-2"></i> Kelola Pesanan</span>
                <span id="badge-orders" class="badge bg-danger rounded-pill px-2" style="font-size: 0.75rem;">-</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }} justify-content-between" href="{{ route('admin.payments.index') }}">
                <span><i class="fa-solid fa-money-check-dollar me-2"></i> Verifikasi Pembayaran</span>
                <span id="badge-payments" class="badge bg-warning text-dark rounded-pill px-2" style="font-size: 0.75rem;">-</span>
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
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill font-weight-bold d-none d-md-inline-flex align-items-center gap-1">
                        <span class="pulse-live"></span> Real-Time Sync Aktif
                    </span>
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
            &copy; {{ date('Y') }} <strong>Kedai Marjuki'S Administrator</strong> &bull; <span class="fw-bold text-danger">Dibuat oleh {{ $creatorName }}</span>
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

<!-- Real-time Live Polling Script -->
<script>
    let lastLatestOrderId = 0;
    let isFirstLoad = true;

    // Pleasant chime sound using Web Audio API
    function playChime() {
        try {
            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(587.33, audioCtx.currentTime); // D5
            osc.frequency.exponentialRampToValueAtTime(880.00, audioCtx.currentTime + 0.15); // A5
            gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.5);
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.5);
        } catch (e) {
            console.log('Audio notification initialized on user gesture.');
        }
    }

    function showOrderToast(orderNumber, customerName) {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-bg-danger border-0 show shadow-lg mb-2 rounded-4';
        toast.setAttribute('role', 'alert');
        toast.style.minWidth = '300px';
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body p-3">
                    <div class="fw-bold fs-6"><i class="fa-solid fa-bell me-2"></i> Pesanan Baru Masuk!</div>
                    <div class="small mt-1">${orderNumber} &bull; ${customerName}</div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        container.appendChild(toast);
        setTimeout(() => {
            toast.remove();
        }, 8000);
    }

    function fetchLiveStats() {
        fetch('{{ route("admin.live-stats") }}')
            .then(res => res.json())
            .then(data => {
                // Update badges
                const badgeOrders = document.getElementById('badge-orders');
                if (badgeOrders) {
                    badgeOrders.textContent = data.pending_orders;
                    badgeOrders.className = data.pending_orders > 0 ? 'badge bg-danger rounded-pill px-2' : 'badge bg-secondary rounded-pill px-2';
                }

                const badgePayments = document.getElementById('badge-payments');
                if (badgePayments) {
                    badgePayments.textContent = data.pending_payments;
                    badgePayments.className = data.pending_payments > 0 ? 'badge bg-warning text-dark rounded-pill px-2' : 'badge bg-secondary rounded-pill px-2';
                }

                // Check for new order
                if (!isFirstLoad && data.latest_order_id > lastLatestOrderId && lastLatestOrderId !== 0) {
                    playChime();
                    showOrderToast(data.latest_order_number, data.latest_customer_name);
                }

                lastLatestOrderId = data.latest_order_id;
                isFirstLoad = false;
            })
            .catch(err => console.log('Live sync polling: ok'));
    }

    // Initial fetch and poll every 6 seconds
    fetchLiveStats();
    setInterval(fetchLiveStats, 6000);
</script>

@stack('scripts')
</body>
</html>
