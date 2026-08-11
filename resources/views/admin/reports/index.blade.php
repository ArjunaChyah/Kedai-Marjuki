@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Kedai Marjuki\'S')
@section('page_title', 'Laporan Penjualan & Pendapatan')

@section('content')
<!-- Filter Period Card -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h5 class="fw-bold text-dark mb-1"><i class="fa-solid fa-chart-pie text-danger me-2"></i> Laporan: <span class="text-danger">{{ $periodLabel }}</span></h5>
            <p class="text-muted small mb-0">Statistik transaksi pembayaran yang telah LUNAS di Kedai Marjuki'S</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.reports.index', ['period' => 'today']) }}" class="btn {{ $period === 'today' ? 'btn-danger' : 'btn-outline-secondary' }} rounded-pill btn-sm fw-bold px-3">
                Hari Ini
            </a>
            <a href="{{ route('admin.reports.index', ['period' => 'this_week']) }}" class="btn {{ $period === 'this_week' ? 'btn-danger' : 'btn-outline-secondary' }} rounded-pill btn-sm fw-bold px-3">
                Minggu Ini
            </a>
            <a href="{{ route('admin.reports.index', ['period' => 'this_month']) }}" class="btn {{ $period === 'this_month' ? 'btn-danger' : 'btn-outline-secondary' }} rounded-pill btn-sm fw-bold px-3">
                Bulan Ini
            </a>
            <a href="{{ route('admin.reports.index', ['period' => 'all']) }}" class="btn {{ $period === 'all' ? 'btn-danger' : 'btn-outline-secondary' }} rounded-pill btn-sm fw-bold px-3">
                Semua Waktu
            </a>
        </div>
    </div>
</div>

<!-- Report Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-success text-white">
            <span class="text-white-50 text-xs font-weight-bold uppercase mb-1 d-block">Total Pendapatan (Lunas)</span>
            <h2 class="fw-extrabold mb-0">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <span class="text-muted text-xs font-weight-bold uppercase mb-1 d-block">Jumlah Pesanan Lunas</span>
            <h2 class="fw-extrabold text-dark mb-0">{{ $totalOrdersCount }} Transaksi</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <span class="text-muted text-xs font-weight-bold uppercase mb-1 d-block">Pesanan Selesai Dilayani</span>
            <h2 class="fw-extrabold text-dark mb-0">{{ $completedOrdersCount }} Selesai</h2>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Top Selling Products -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100">
            <div class="card-header bg-white py-3 px-4">
                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-trophy text-warning me-2"></i> Produk Terlaris Periode Ini</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse ($topProductsQuery as $top)
                        <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold text-dark mb-0">{{ $top->product_name }}</div>
                                <small class="text-muted">Total Penjualan: Rp{{ number_format($top->total_sales, 0, ',', '.') }}</small>
                            </div>
                            <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold">
                                {{ $top->total_qty }} Porsi
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item px-4 py-4 text-center text-muted">Belum ada data produk terjual pada periode ini.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Transaction History Table -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100">
            <div class="card-header bg-white py-3 px-4">
                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-receipt text-danger me-2"></i> Detail Transaksi Lunas</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 350px;">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light text-uppercase text-xs text-muted sticky-top">
                            <tr>
                                <th class="ps-4">No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Metode</th>
                                <th class="pe-4 text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $o)
                                <tr>
                                    <td class="ps-4 font-monospace fw-bold text-dark">{{ $o->order_number }}</td>
                                    <td>
                                        <div class="fw-bold text-dark text-xs">{{ $o->customer_name }}</div>
                                        <small class="text-muted text-xs">{{ $o->created_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">{{ strtoupper($o->payment_method) }}</span></td>
                                    <td class="pe-4 text-end fw-bold text-success">{{ $o->formatted_total_price }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada transaksi lunas pada periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
