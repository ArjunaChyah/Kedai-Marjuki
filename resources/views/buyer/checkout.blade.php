@extends('layouts.app')

@section('title', 'Checkout Pesanan - Kedai Marjuki\'S')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-dark mb-1">
        <i class="fa-solid fa-utensils text-danger me-2"></i> Checkout Pesanan (Makan di Tempat)
    </h2>
    <p class="text-muted mb-4">Konfirmasi nama, nomor meja / tempat duduk, dan metode pembayaran Anda</p>

    <x-alert />

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        
        <div class="row g-4">
            <!-- Customer Data Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-user text-danger me-2"></i> Data Pelanggan Kedai</h5>

                    <div class="mb-3">
                        <label for="name" class="form-label font-weight-bold text-dark small">Nama Pemesan</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required placeholder="Nama Anda">
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label font-weight-bold text-dark small">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required placeholder="081234567890">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label font-weight-bold text-dark small">Nomor Meja / Lokasi Tempat Duduk</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', 'Makan di Tempat - Meja 1') }}" required placeholder="Contoh: Meja 1, Meja 2, atau Bungkus (Bawa Pulang)">
                        <small class="text-muted"><i class="fa-solid fa-shop text-success me-1"></i> Pesanan disajikan langsung di meja tempat duduk Anda di Kedai Marjuki'S.</small>
                    </div>

                    <div class="mb-0">
                        <label for="notes" class="form-label font-weight-bold text-dark small">Catatan Pesanan (Opsional)</label>
                        <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="Contoh: Sambal dipisah, Indomie setengah matang, es teh manis banget, dll.">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <!-- Payment Method Selection -->
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-wallet text-danger me-2"></i> Pilih Metode Pembayaran</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="card h-100 border p-3 cursor-pointer rounded-3 payment-option hover-lift">
                                <div class="d-flex align-items-center gap-3">
                                    <input type="radio" name="payment_method" value="qris" class="form-check-input flex-shrink-0" {{ old('payment_method', 'qris') == 'qris' ? 'checked' : '' }} required>
                                    <div>
                                        <div class="fw-bold text-dark mb-0"><i class="fa-solid fa-qrcode text-danger me-1"></i> QRIS (NONTUNAI)</div>
                                        <small class="text-muted d-block">Scan QR via GoPay, OVO, Dana, ShopeePay, m-Banking</small>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="col-md-6">
                            <label class="card h-100 border p-3 cursor-pointer rounded-3 payment-option hover-lift">
                                <div class="d-flex align-items-center gap-3">
                                    <input type="radio" name="payment_method" value="cash" class="form-check-input flex-shrink-0" {{ old('payment_method') == 'cash' ? 'checked' : '' }}>
                                    <div>
                                        <div class="fw-bold text-dark mb-0"><i class="fa-solid fa-money-bill-wave text-success me-1"></i> TUNAI (CASH)</div>
                                        <small class="text-muted d-block">Bayar langsung di kasir / saat hidangan disajikan</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 90px;">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-receipt text-danger me-2"></i> Ringkasan Pesanan</h5>

                    <div class="list-group list-group-flush mb-3">
                        @foreach ($cart->items as $item)
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center bg-transparent py-2">
                                <div>
                                    <div class="fw-bold text-dark mb-0">{{ $item->product->name }}</div>
                                    <small class="text-muted">{{ $item->quantity }} x {{ $item->product->formatted_price }}</small>
                                </div>
                                <span class="fw-bold text-dark">{{ $item->formatted_subtotal }}</span>
                            </div>
                        @endforeach
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
                        <span class="fw-bold text-dark fs-5">Total Pembayaran</span>
                        <span class="fw-extrabold text-danger fs-4">{{ $cart->formatted_total_price }}</span>
                    </div>

                    <button type="submit" class="btn btn-danger btn-lg w-100 rounded-pill font-weight-bold shadow-sm py-3">
                        <i class="fa-solid fa-paper-plane me-2"></i> Pesan Makanan Sekarang
                    </button>

                    <small class="text-muted text-center d-block mt-3 fs-7">
                        <i class="fa-solid fa-store text-success me-1"></i> Pesanan Anda disajikan segar dan hangat oleh Kedai Marjuki'S.
                    </small>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
