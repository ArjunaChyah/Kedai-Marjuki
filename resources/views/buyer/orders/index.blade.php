@extends('layouts.app')

@section('title', 'Riwayat Pesanan Saya - Kedai Marjuki\'S')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-receipt text-danger me-2"></i> Pesanan Saya
            </h2>
            <p class="text-muted mb-0">Pantau seluruh histori transaksi pemesanan makanan Anda</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-danger rounded-pill fw-bold px-4">
            <i class="fa-solid fa-plus me-1"></i> Buat Pesanan Baru
        </a>
    </div>

    <x-alert />

    @if ($orders->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 text-center py-5 p-4">
            <div class="card-body">
                <i class="fa-solid fa-box-open fs-1 text-muted mb-3 d-block"></i>
                <h4 class="fw-bold text-dark">Belum ada pesanan.</h4>
                <p class="text-muted mb-4">Anda belum pernah membuat pesanan makanan di Kedai Marjuki'S.</p>
                <a href="{{ route('products.index') }}" class="btn btn-danger btn-lg rounded-pill px-5 font-weight-bold shadow-sm">
                    Pesan Makanan Sekarang
                </a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light text-uppercase text-xs text-muted">
                        <tr>
                            <th class="ps-4">Nomor Pesanan</th>
                            <th>Tanggal</th>
                            <th>Total Pembayaran</th>
                            <th>Metode Pembayaran</th>
                            <th>Status Pembayaran</th>
                            <th>Status Pesanan</th>
                            <th class="pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="ps-4 fw-bold font-monospace text-dark">{{ $order->order_number }}</td>
                                <td class="text-muted small">{{ $order->created_at->translatedFormat('d M Y H:i') }}</td>
                                <td class="fw-bold text-danger">{{ $order->formatted_total_price }}</td>
                                <td><span class="badge bg-light text-dark border">{{ strtoupper($order->payment_method) }}</span></td>
                                <td><x-payment-status-badge :status="$order->payment_status" /></td>
                                <td><x-order-status-badge :status="$order->order_status" /></td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        @if ($order->payment_status === 'pending' || $order->payment_status === 'waiting_confirmation')
                                            <a href="{{ route('orders.payment', $order->id) }}" class="btn btn-warning btn-sm rounded-pill font-weight-bold">
                                                Bayar / Konfirmasi
                                            </a>
                                        @endif
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-danger btn-sm rounded-pill font-weight-bold">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
