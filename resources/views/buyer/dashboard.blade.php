@extends('layouts.app')

@section('title', 'Dashboard Pembeli - Kedai Marjuki\'S')

@section('content')
<div class="container py-4">
    <!-- Welcome Header -->
    <div class="bg-danger text-white rounded-4 p-4 p-md-5 mb-4 shadow-sm position-relative overflow-hidden">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="badge bg-warning text-dark font-weight-bold px-3 py-2 rounded-pill mb-2">
                    <i class="fa-solid fa-user-check me-1"></i> Dashboard Pembeli
                </span>
                <h2 class="fw-bold mb-2">Selamat Datang, {{ $user->name }}!</h2>
                <p class="text-white-50 mb-0">Kelola pesanan makanan dan pantau status transaksi Anda dengan mudah di sini.</p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="fa-solid fa-utensils text-white opacity-25" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    <x-alert />

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-danger-subtle text-danger rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-receipt fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted text-xs d-block">Total Pesanan</span>
                        <h4 class="fw-bold text-dark mb-0">{{ $totalOrders }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning-subtle text-warning-emphasis rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-clock-rotate-left fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted text-xs d-block">Pesanan Pending</span>
                        <h4 class="fw-bold text-dark mb-0">{{ $pendingOrders }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success-subtle text-success rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-circle-check fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted text-xs d-block">Pesanan Selesai</span>
                        <h4 class="fw-bold text-dark mb-0">{{ $completedOrders }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-info-subtle text-info-emphasis rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-wallet fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted text-xs d-block">Total Transaksi</span>
                        <h5 class="fw-bold text-dark mb-0">Rp{{ number_format($totalSpent, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Grid -->
    <div class="row g-3 mb-5">
        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('buyer.dashboard') }}" class="card border-0 shadow-sm rounded-4 p-3 text-center text-decoration-none bg-danger text-white hover-lift">
                <i class="fa-solid fa-border-all fs-2 mb-2"></i>
                <small class="fw-bold d-block">Dashboard</small>
            </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('products.index') }}" class="card border-0 shadow-sm rounded-4 p-3 text-center text-decoration-none text-dark bg-white hover-lift">
                <i class="fa-solid fa-bowl-food fs-2 text-danger mb-2"></i>
                <small class="fw-bold d-block">Menu Produk</small>
            </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('cart.index') }}" class="card border-0 shadow-sm rounded-4 p-3 text-center text-decoration-none text-dark bg-white hover-lift">
                <i class="fa-solid fa-cart-shopping fs-2 text-warning mb-2"></i>
                <small class="fw-bold d-block">Keranjang</small>
            </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('orders.index') }}" class="card border-0 shadow-sm rounded-4 p-3 text-center text-decoration-none text-dark bg-white hover-lift">
                <i class="fa-solid fa-receipt fs-2 text-primary mb-2"></i>
                <small class="fw-bold d-block">Pesanan Saya</small>
            </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('profile.index') }}" class="card border-0 shadow-sm rounded-4 p-3 text-center text-decoration-none text-dark bg-white hover-lift">
                <i class="fa-solid fa-user-gear fs-2 text-info mb-2"></i>
                <small class="fw-bold d-block">Profil Saya</small>
            </a>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="card border-0 shadow-sm rounded-4 p-3 text-center text-decoration-none text-danger bg-white hover-lift w-100">
                    <i class="fa-solid fa-right-from-bracket fs-2 mb-2"></i>
                    <small class="fw-bold d-block">Logout</small>
                </button>
            </form>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0">Pesanan Terbaru Saya</h5>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-danger btn-sm rounded-pill font-weight-bold">
                Lihat Semua Pesanan <i class="fa-solid fa-chevron-right ms-1"></i>
            </a>
        </div>

        <div class="card-body p-0">
            @if ($recentOrders->isEmpty())
                <div class="text-center py-5 text-muted p-4">
                    <i class="fa-solid fa-box-open fs-1 mb-3 d-block"></i>
                    <p class="mb-2 fw-semibold">Belum ada pesanan.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-danger btn-sm rounded-pill fw-bold">Pesan Makanan Sekarang</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light text-uppercase text-xs text-muted">
                            <tr>
                                <th class="ps-4">No. Pesanan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Pembayaran</th>
                                <th>Status Pesanan</th>
                                <th>Status Bayar</th>
                                <th class="pe-4 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentOrders as $order)
                                <tr>
                                    <td class="ps-4 fw-bold font-monospace text-dark">{{ $order->order_number }}</td>
                                    <td class="text-muted small">{{ $order->created_at->translatedFormat('d M Y H:i') }}</td>
                                    <td class="fw-bold text-danger">{{ $order->formatted_total_price }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ strtoupper($order->payment_method) }}</span></td>
                                    <td><x-order-status-badge :status="$order->order_status" /></td>
                                    <td><x-payment-status-badge :status="$order->payment_status" /></td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-danger btn-sm rounded-pill font-weight-bold">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
