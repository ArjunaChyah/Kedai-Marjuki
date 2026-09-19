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
            <a href="{{ route('orders.receipt', $order->id) }}" target="_blank" class="btn btn-outline-dark rounded-pill fw-bold">
                <i class="fa-solid fa-print me-1"></i> Cetak Struk
            </a>

            @if ($order->payment_method === 'qris' && ($order->payment_status === 'pending' || $order->payment_status === 'rejected'))
                <a href="{{ route('orders.payment', $order->id) }}" class="btn btn-warning rounded-pill fw-bold">
                    <i class="fa-solid fa-qrcode me-1"></i> Pembayaran QRIS
                </a>
            @endif
        </div>
    </div>

    <x-alert />

    @php
        $statusMap = [
            'pending' => 1,
            'confirmed' => 1,
            'processing' => 2,
            'ready' => 3,
            'completed' => 4,
            'cancelled' => 0,
        ];
        $currentStep = $statusMap[$order->order_status] ?? 1;
        $progressPercent = match($currentStep) {
            1 => 15,
            2 => 48,
            3 => 80,
            4 => 100,
            default => 0,
        };
    @endphp

    <!-- Live Interactive Status Tracker -->
    <div id="liveTrackerBox" class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
        @if ($order->order_status === 'cancelled')
            <div class="alert alert-danger border-0 rounded-3 mb-0 d-flex align-items-center gap-3">
                <i class="fa-solid fa-circle-xmark fs-2 text-danger"></i>
                <div>
                    <h6 class="fw-bold mb-1 text-danger">Pesanan Dibatalkan</h6>
                    <p class="small mb-0 text-danger-emphasis">Pesanan nomor {{ $order->order_number }} telah dibatalkan.</p>
                </div>
            </div>
        @else
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-danger text-white px-3 py-1.5 rounded-pill fw-bold text-xs d-inline-flex align-items-center gap-1">
                        <span class="spinner-grow spinner-grow-sm" style="width: 8px; height: 8px;" role="status"></span>
                        LIVE STATUS TRACKER
                    </span>
                    <span class="text-muted text-xs">&bull; Real-time auto-sync aktif</span>
                </div>
                <div>
                    @if ($currentStep === 1)
                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1.5 rounded-pill fw-bold">
                            <i class="fa-solid fa-receipt me-1"></i> 1. Menunggu Konfirmasi Dapur
                        </span>
                    @elseif ($currentStep === 2)
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1.5 rounded-pill fw-bold">
                            <i class="fa-solid fa-fire-burner me-1"></i> 2. Sedang Dimasak di Dapur
                        </span>
                    @elseif ($currentStep === 3)
                        <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-3 py-1.5 rounded-pill fw-bold">
                            <i class="fa-solid fa-bell-concierge me-1"></i> 3. Siap Disajikan ke Meja
                        </span>
                    @elseif ($currentStep === 4)
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill fw-bold">
                            <i class="fa-solid fa-circle-check me-1"></i> 4. Pesanan Selesai Disajikan
                        </span>
                    @endif
                </div>
            </div>

            <!-- Progress Tracker Bar Container -->
            <div class="position-relative mx-3 my-4 py-2">
                <div class="progress" style="height: 6px; background-color: #e2e8f0; border-radius: 10px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $progressPercent }}%; transition: width 0.7s ease;" aria-valuenow="{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <!-- Step Bubbles -->
                <div class="d-flex justify-content-between position-absolute top-50 start-0 w-100 translate-middle-y">
                    <!-- Step 1: Diterima -->
                    <div class="text-center" style="width: 90px; margin-left: -45px;">
                        <div class="btn btn-sm {{ $currentStep >= 1 ? 'btn-danger' : 'btn-light border text-muted' }} rounded-circle p-0 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div class="fw-bold mt-2 text-xs {{ $currentStep >= 1 ? 'text-dark' : 'text-muted' }}">1. Diterima</div>
                        <small class="text-muted d-block" style="font-size: 10px;">Kasir Kedai</small>
                    </div>

                    <!-- Step 2: Dimasak -->
                    <div class="text-center" style="width: 90px; margin-left: -45px;">
                        <div class="btn btn-sm {{ $currentStep >= 2 ? 'btn-danger' : 'btn-light border text-muted' }} rounded-circle p-0 d-inline-flex align-items-center justify-content-center shadow-sm {{ $currentStep === 2 ? 'pulse-step' : '' }}" style="width: 38px; height: 38px;">
                            <i class="fa-solid fa-fire-burner"></i>
                        </div>
                        <div class="fw-bold mt-2 text-xs {{ $currentStep >= 2 ? 'text-dark' : 'text-muted' }}">2. Dimasak</div>
                        <small class="text-muted d-block" style="font-size: 10px;">Dapur Kedai</small>
                    </div>

                    <!-- Step 3: Siap Disajikan -->
                    <div class="text-center" style="width: 90px; margin-left: -45px;">
                        <div class="btn btn-sm {{ $currentStep >= 3 ? 'btn-danger' : 'btn-light border text-muted' }} rounded-circle p-0 d-inline-flex align-items-center justify-content-center shadow-sm {{ $currentStep === 3 ? 'pulse-step' : '' }}" style="width: 38px; height: 38px;">
                            <i class="fa-solid fa-bell-concierge"></i>
                        </div>
                        <div class="fw-bold mt-2 text-xs {{ $currentStep >= 3 ? 'text-dark' : 'text-muted' }}">3. Siap</div>
                        <small class="text-muted d-block" style="font-size: 10px;">Meja/Bungkus</small>
                    </div>

                    <!-- Step 4: Selesai -->
                    <div class="text-center" style="width: 90px; margin-left: -45px;">
                        <div class="btn btn-sm {{ $currentStep >= 4 ? 'btn-success' : 'btn-light border text-muted' }} rounded-circle p-0 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="fw-bold mt-2 text-xs {{ $currentStep >= 4 ? 'text-success' : 'text-muted' }}">4. Selesai</div>
                        <small class="text-muted d-block" style="font-size: 10px;">Selamat Makan</small>
                    </div>
                </div>
            </div>

            <!-- Dynamic Descriptive Status Notice -->
            <div class="mt-4 pt-3 border-top text-center small text-muted">
                @if ($currentStep === 1)
                    <i class="fa-solid fa-clock text-warning me-1"></i> Pesanan telah masuk ke antrean kedai. Tim dapur segera mempersiapkan pesanan Anda.
                @elseif ($currentStep === 2)
                    <i class="fa-solid fa-fire text-danger me-1"></i> <strong>Juru masak sedang memasak hidangan hangat Anda di dapur!</strong> Mohon tunggu sejenak.
                @elseif ($currentStep === 3)
                    <i class="fa-solid fa-utensils text-info me-1"></i> <strong>Hidangan Anda sudah matang dan siap disajikan!</strong> Pelayan segera mengantar ke meja Anda.
                @elseif ($currentStep === 4)
                    <i class="fa-solid fa-heart text-success me-1"></i> <strong>Pesanan telah selesai disajikan.</strong> Matur nuwun sampun rawuh di Kedai Marjuki'S!
                @endif
            </div>
        @endif
    </div>

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

@push('styles')
<style>
    .pulse-step {
        animation: pulse-step-glow 1.6s infinite ease-in-out;
    }
    @keyframes pulse-step-glow {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); }
        70% { transform: scale(1.12); box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
    }
</style>
@endpush

@push('scripts')
<script>
    // Live poll order status every 3.5 seconds
    const isCompleted = "{{ $order->order_status }}" === 'completed' && "{{ $order->payment_status }}" === 'paid';
    if (!isCompleted) {
        setInterval(function() {
            fetch(window.location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // 1. Sync Live Tracker Card
                    const newTracker = doc.querySelector('#liveTrackerBox');
                    const currTracker = document.querySelector('#liveTrackerBox');
                    if (newTracker && currTracker && newTracker.innerHTML.trim() !== currTracker.innerHTML.trim()) {
                        currTracker.innerHTML = newTracker.innerHTML;
                    }

                    // 2. Sync Sidebar Status
                    const newStatus = doc.querySelector('.col-lg-4');
                    const currStatus = document.querySelector('.col-lg-4');
                    if (newStatus && currStatus && newStatus.innerHTML.trim() !== currStatus.innerHTML.trim()) {
                        currStatus.innerHTML = newStatus.innerHTML;
                    }
                })
                .catch(err => console.debug('Syncing live tracker...', err));
        }, 3500);
    }
</script>
@endpush
@endsection
