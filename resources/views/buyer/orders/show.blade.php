@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - Kedai Marjuki\'S')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('orders.index') }}" class="text-decoration-none text-danger fw-semibold small mb-1 d-inline-block">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Pesanan Saya
            </a>
            <h2 class="fw-bold text-dark mb-0">Detail Pesanan: <span class="font-monospace text-danger">{{ $order->order_number }}</span></h2>
        </div>

        <div class="d-flex gap-2">
            @if ($order->payment_method === 'qris' && ($order->payment_status === 'pending' || $order->payment_status === 'rejected'))
                <a href="{{ route('orders.payment', $order->id) }}" class="btn btn-warning rounded-pill fw-bold">
                    <i class="fa-solid fa-qrcode me-1"></i> Pembayaran QRIS
                </a>
            @endif
        </div>
    </div>

    <x-alert />

    <div class="row g-4">
        <!-- Main Order Detail -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white py-3 px-4">
                    <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-basket-shopping text-danger me-2"></i> Rincian Menu Pesanan</h5>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light text-uppercase text-xs text-muted">
                                <tr>
                                    <th class="ps-4">Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th class="pe-4 text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="fw-bold text-dark">{{ $item->product_name }}</div>
                                        </td>
                                        <td class="fw-semibold text-muted">{{ $item->formatted_price }}</td>
                                        <td class="fw-bold">{{ $item->quantity }} Porsi</td>
                                        <td class="pe-4 text-end fw-bold text-danger">{{ $item->formatted_subtotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="3" class="ps-4 fw-bold text-end fs-5 py-3">Total Bayar:</td>
                                    <td class="pe-4 text-end fw-extrabold text-danger fs-4 py-3">{{ $order->formatted_total_price }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Customer & Delivery Notes -->
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-location-dot text-danger me-2"></i> Informai Pengiriman &amp; Penerima</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <span class="text-muted text-xs d-block">Nama Lengkap Pemesan</span>
                        <p class="fw-bold text-dark mb-0">{{ $order->customer_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted text-xs d-block">Nomor WhatsApp</span>
                        <p class="fw-bold text-dark mb-0">{{ $order->customer_phone }}</p>
                    </div>
                    <div class="col-12">
                        <span class="text-muted text-xs d-block">Alamat Pengiriman / Pengambilan</span>
                        <p class="fw-semibold text-dark mb-0">{{ $order->customer_address }}</p>
                    </div>
                    @if ($order->notes)
                        <div class="col-12">
                            <span class="text-muted text-xs d-block">Catatan Pesanan</span>
                            <p class="text-dark bg-light p-2 rounded border mb-0 small">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3">Status Transaksi</h5>

                <div class="mb-3">
                    <span class="text-muted text-xs d-block mb-1">Status Pesanan Kedai</span>
                    <x-order-status-badge :status="$order->order_status" />
                </div>

                <div class="mb-3">
                    <span class="text-muted text-xs d-block mb-1">Status Pembayaran</span>
                    <x-payment-status-badge :status="$order->payment_status" />
                </div>

                <div class="mb-3">
                    <span class="text-muted text-xs d-block mb-1">Metode Pembayaran</span>
                    <span class="badge bg-dark text-white rounded-pill px-3 py-2">
                        <i class="fa-solid {{ $order->payment_method === 'qris' ? 'fa-qrcode' : 'fa-money-bill-wave' }} me-1"></i>
                        {{ strtoupper($order->payment_method) }}
                    </span>
                </div>

                <div class="mb-0">
                    <span class="text-muted text-xs d-block mb-1">Waktu Pemesanan</span>
                    <p class="fw-semibold text-dark mb-0 small">{{ $order->created_at->translatedFormat('l, d F Y - H:i') }} WIB</p>
                </div>
            </div>

            <!-- WhatsApp Kedai Contact Button -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-success-subtle text-success border-success-subtle">
                <h6 class="fw-bold mb-2"><i class="fa-brands fa-whatsapp fs-5 me-1"></i> Perlu Bantuan?</h6>
                <p class="small mb-3 text-success-emphasis">Hubungi kedai kami melalui WhatsApp jika ingin menanyakan pesanan ini.</p>
                <a href="https://wa.me/62882005116301?text=Halo%20Kedai%20Marjuki'S,%20saya%20ingin%20bertanya%20mengenai%20pesanan%20nomor%20{{ $order->order_number }}" target="_blank" class="btn btn-success rounded-pill font-weight-bold shadow-sm">
                    <i class="fa-brands fa-whatsapp me-1"></i> Chat Kedai Marjuki'S
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
