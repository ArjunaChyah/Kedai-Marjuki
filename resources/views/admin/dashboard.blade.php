@extends('admin.layout')

@section('title', 'Dashboard Administrator - Kedai Marjuki\'S')
@section('page_title', 'Dashboard Ringkasan Kedai')

@section('content')

<!-- Stat Cards Grid -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="badge-stat bg-danger-subtle text-danger">
                    <i class="fa-solid fa-bowl-food"></i>
                </div>
                <div>
                    <span class="text-muted text-xs d-block font-weight-bold uppercase">Total Produk</span>
                    <h3 class="fw-extrabold text-dark mb-0">{{ $totalProducts }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="badge-stat bg-primary-subtle text-primary">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <span class="text-muted text-xs d-block font-weight-bold uppercase">Total Pelanggan</span>
                    <h3 class="fw-extrabold text-dark mb-0">{{ $totalCustomers }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="badge-stat bg-info-subtle text-info-emphasis">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div>
                    <span class="text-muted text-xs d-block font-weight-bold uppercase">Total Pesanan</span>
                    <h3 class="fw-extrabold text-dark mb-0">{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="badge-stat bg-warning-subtle text-warning-emphasis">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <span class="text-muted text-xs d-block font-weight-bold uppercase">Pesanan Pending</span>
                    <h3 class="fw-extrabold text-dark mb-0">{{ $pendingOrders }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="badge-stat bg-success-subtle text-success">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <span class="text-muted text-xs d-block font-weight-bold uppercase">Pesanan Selesai</span>
                    <h3 class="fw-extrabold text-dark mb-0">{{ $completedOrders }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="badge-stat bg-success text-white">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>
                <div>
                    <span class="text-muted text-xs d-block font-weight-bold uppercase">Total Pendapatan</span>
                    <h4 class="fw-extrabold text-success mb-0">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-receipt text-danger me-2"></i> Pesanan Terbaru Kedai</h6>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-danger btn-sm rounded-pill font-weight-bold">
            Lihat Semua Pesanan <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="card-body p-0">
        @if ($recentOrders->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="fa-solid fa-inbox fs-1 mb-2 d-block"></i>
                Belum ada transaksi pesanan masuk.
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light text-uppercase text-xs text-muted">
                        <tr>
                            <th class="ps-4">No. Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Metode Bayar</th>
                            <th>Status Bayar</th>
                            <th>Status Pesanan</th>
                            <th class="pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentOrders as $order)
                            <tr>
                                <td class="ps-4 fw-bold font-monospace text-dark">{{ $order->order_number }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $order->customer_name }}</div>
                                    <small class="text-muted">{{ $order->customer_phone }}</small>
                                </td>
                                <td class="fw-bold text-danger">{{ $order->formatted_total_price }}</td>
                                <td><span class="badge bg-light text-dark border">{{ strtoupper($order->payment_method) }}</span></td>
                                <td><x-payment-status-badge :status="$order->payment_status" /></td>
                                <td><x-order-status-badge :status="$order->order_status" /></td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-danger btn-sm rounded-pill font-weight-bold">
                                        Detail
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
@endsection
