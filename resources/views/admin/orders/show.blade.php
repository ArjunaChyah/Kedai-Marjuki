@extends('layouts.admin')

@section('title', 'Kelola Pesanan #' . $order->order_number . ' - Kedai Marjuki\'S')
@section('page_title', 'Detail & Update Status Pesanan')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none text-danger fw-bold small">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Pesanan
    </a>
</div>

<div class="row g-4">
    <!-- Left Column: Items & Customer Details -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0">Pesanan: <span class="font-monospace text-danger">{{ $order->order_number }}</span></h5>
                <span class="text-muted small">{{ $order->created_at->translatedFormat('l, d F Y H:i') }} WIB</span>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light text-uppercase text-xs text-muted">
                            <tr>
                                <th class="ps-4">Item Produk</th>
                                <th>Harga Satuan</th>
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
                                    <td class="text-muted">{{ $item->formatted_price }}</td>
                                    <td class="fw-bold">{{ $item->quantity }} Porsi</td>
                                    <td class="pe-4 text-end fw-bold text-danger">{{ $item->formatted_subtotal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="3" class="ps-4 text-end fw-bold fs-5 py-3">Total Pesanan:</td>
                                <td class="pe-4 text-end fw-extrabold text-danger fs-4 py-3">{{ $order->formatted_total_price }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-user text-danger me-2"></i> Data Pembeli &amp; Alamat Pengiriman</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <span class="text-muted text-xs d-block">Nama Lengkap</span>
                    <p class="fw-bold text-dark mb-0">{{ $order->customer_name }}</p>
                </div>
                <div class="col-md-6">
                    <span class="text-muted text-xs d-block">Nomor WhatsApp</span>
                    <p class="fw-bold text-dark mb-0">{{ $order->customer_phone }}</p>
                </div>
                <div class="col-12">
                    <span class="text-muted text-xs d-block">Alamat Lengkap</span>
                    <p class="fw-semibold text-dark mb-0">{{ $order->customer_address }}</p>
                </div>
                @if ($order->notes)
                    <div class="col-12">
                        <span class="text-muted text-xs d-block">Catatan Tambahan Pembeli</span>
                        <p class="text-dark bg-light p-2.5 rounded border mb-0 small">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column: Status & Admin Controls -->
    <div class="col-lg-4">
        <!-- Update Order Status Form -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
            <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-sliders text-danger me-2"></i> Update Status Pesanan</h5>

            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="order_status" class="form-label font-weight-bold text-dark small">Status Alur Pesanan</label>
                    <select name="order_status" id="order_status" class="form-select fw-semibold" required>
                        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                        <option value="confirmed" {{ $order->order_status === 'confirmed' ? 'selected' : '' }}>Confirmed (Dikonfirmasi Admin)</option>
                        <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing (Sedang Dimasak)</option>
                        <option value="ready" {{ $order->order_status === 'ready' ? 'selected' : '' }}>Ready (Siap Diambil/Dikirim)</option>
                        <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>Completed (Pesanan Selesai)</option>
                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-danger w-100 rounded-pill font-weight-bold">
                    <i class="fa-solid fa-arrows-rotate me-1"></i> Update Status Pesanan
                </button>
            </form>
        </div>

        <!-- Payment Status Summary & Action Buttons -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-credit-card text-danger me-2"></i> Status Pembayaran</h5>

            <div class="mb-3">
                <span class="text-muted text-xs d-block mb-1">Metode Pembayaran</span>
                <span class="badge bg-dark text-white rounded-pill px-3 py-1.5 fw-bold">
                    {{ strtoupper($order->payment_method) }}
                </span>
            </div>

            <div class="mb-4">
                <span class="text-muted text-xs d-block mb-1">Status Pembayaran Saat Ini</span>
                <x-payment-status-badge :status="$order->payment_status" />
            </div>

            @if ($order->payment_method === 'qris')
                @if ($order->payment_status === 'waiting_confirmation' || $order->payment_status === 'pending')
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.payments.confirm', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 rounded-pill font-weight-bold">
                                <i class="fa-solid fa-check me-1"></i> Konfirmasi Pembayaran LUNAS
                            </button>
                        </form>
                        <form action="{{ route('admin.payments.reject', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 rounded-pill font-weight-bold">
                                <i class="fa-solid fa-times me-1"></i> Tolak Pembayaran
                            </button>
                        </form>
                    </div>
                @endif
            @elseif ($order->payment_method === 'cash')
                @if ($order->payment_status !== 'paid')
                    <form action="{{ route('admin.payments.confirm-cash', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 rounded-pill font-weight-bold">
                            <i class="fa-solid fa-money-bill-check me-1"></i> Konfirmasi Pembayaran Tunai
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
