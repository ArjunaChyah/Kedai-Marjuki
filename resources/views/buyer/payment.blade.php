@extends('layouts.app')

@section('title', 'Pembayaran Pesanan - Kedai Marjuki\'S')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            <x-alert />

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-danger text-white py-3 text-center">
                    <h5 class="fw-bold mb-0">
                        @if ($order->payment_method === 'qris')
                            <i class="fa-solid fa-qrcode me-2"></i> PEMBAYARAN QRIS
                        @else
                            <i class="fa-solid fa-money-bill-wave me-2"></i> PEMBAYARAN TUNAI
                        @endif
                    </h5>
                </div>

                <div class="card-body p-4 p-md-5 text-center">
                    <div class="mb-4">
                        <span class="text-muted small d-block">Nomor Pesanan</span>
                        <h4 class="fw-bold text-dark font-monospace mb-2">{{ $order->order_number }}</h4>
                        
                        <span class="text-muted small d-block mt-2">Total Pembayaran</span>
                        <h2 class="fw-extrabold text-danger mb-3">{{ $order->formatted_total_price }}</h2>

                        <div class="d-inline-block">
                            <x-payment-status-badge :status="$order->payment_status" />
                        </div>
                    </div>

                    <hr class="my-4">

                    @if ($order->payment_method === 'qris')
                        <div class="bg-light p-4 rounded-4 mb-4 border">
                            <h6 class="fw-bold text-dark mb-3">Scan QR Code QRIS Kedai Marjuki'S</h6>
                            
                            <div class="d-inline-block p-3 bg-white rounded-3 shadow-sm mb-3">
                                @if ($qrisSetting && $qrisSetting->qris_image)
                                    <img src="{{ Str::startsWith($qrisSetting->qris_image, 'http') ? $qrisSetting->qris_image : (file_exists(public_path($qrisSetting->qris_image)) ? asset($qrisSetting->qris_image) : asset('storage/' . $qrisSetting->qris_image)) }}" class="img-fluid rounded border" style="max-width: 250px; max-height: 250px;" alt="QRIS Kedai Marjuki'S">
                                @else
                                    <div class="py-4 px-5 text-muted">
                                        <i class="fa-solid fa-qrcode display-1 text-danger"></i>
                                        <p class="small text-danger fw-bold mt-2">Gambar QRIS belum dikonfigurasi admin.</p>
                                    </div>
                                @endif
                            </div>

                            <p class="text-muted small mb-0 px-md-4">
                                Silakan scan QR Code di atas menggunakan aplikasi pembayaran yang mendukung QRIS (GoPay, OVO, ShopeePay, Dana, LinkAja, atau Mobile Banking).
                            </p>
                        </div>

                        @if ($order->payment_status === 'pending' || $order->payment_status === 'rejected')
                            <form action="{{ route('orders.confirm-qris', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-lg w-100 rounded-pill font-weight-bold shadow-sm py-3 mb-3">
                                    <i class="fa-solid fa-circle-check me-2"></i> Saya Sudah Membayar
                                </button>
                            </form>
                        @elseif ($order->payment_status === 'waiting_confirmation')
                            <div class="alert alert-info rounded-3 text-start small mb-4">
                                <i class="fa-solid fa-clock me-2 fs-5"></i>
                                Konfirmasi pembayaran berhasil dikirim. Menunggu verifikasi admin Kedai Marjuki'S. Status akan otomatis berubah menjadi LUNAS setelah diverifikasi admin.
                            </div>
                        @elseif ($order->payment_status === 'paid')
                            <div class="alert alert-success rounded-3 text-start small mb-4">
                                <i class="fa-solid fa-circle-check me-2 fs-5"></i>
                                Pembayaran Anda telah Diverifikasi dan Dikonfirmasi LUNAS oleh Admin! Pesanan sedang diproses.
                            </div>
                        @endif

                    @else
                        <!-- Tunai (Cash) Payment Info -->
                        <div class="bg-light p-4 rounded-4 mb-4 border text-center">
                            <i class="fa-solid fa-hand-holding-dollar display-4 text-success mb-3"></i>
                            <h6 class="fw-bold text-dark mb-2">Petunjuk Pembayaran Tunai</h6>
                            <p class="text-muted small mb-0 px-md-3">
                                Pembayaran dilakukan secara langsung kepada pihak Kedai Marjuki'S saat pesanan diambil atau diterima di lokasi kedai.
                            </p>
                        </div>

                        @if ($order->payment_status === 'paid')
                            <div class="alert alert-success rounded-3 text-start small mb-4">
                                <i class="fa-solid fa-circle-check me-2 fs-5"></i>
                                Pembayaran Tunai telah diterima dan dikonfirmasi LUNAS oleh Admin Kedai!
                            </div>
                        @else
                            <div class="alert alert-warning rounded-3 text-start small mb-4">
                                <i class="fa-solid fa-info-circle me-2 fs-5"></i>
                                Silakan siapkan uang pas sebesar <strong>{{ $order->formatted_total_price }}</strong> saat pengambilan pesanan.
                            </div>
                        @endif
                    @endif

                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-danger rounded-pill fw-bold px-4">
                            <i class="fa-solid fa-eye me-1"></i> Lihat Detail Pesanan
                        </a>
                        <a href="{{ route('buyer.dashboard') }}" class="btn btn-secondary rounded-pill fw-bold px-4">
                            Ke Dashboard Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
