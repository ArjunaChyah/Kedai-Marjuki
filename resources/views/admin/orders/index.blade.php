@extends('layouts.admin')

@section('title', 'Kelola Pesanan - Kedai Marjuki\'S')
@section('page_title', 'Manajemen Pesanan Kedai')

@section('content')
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Status Pesanan</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Siap Diambil/Dikirim</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>

        <div class="col-md-3">
            <select name="payment_status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Status Pembayaran</option>
                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Belum Dibayar</option>
                <option value="waiting_confirmation" {{ request('payment_status') == 'waiting_confirmation' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Sudah Dibayar (Paid)</option>
                <option value="rejected" {{ request('payment_status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari No. Pesanan / Nama Pelanggan..." value="{{ request('search') }}">
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-danger btn-sm w-100 font-weight-bold">
                <i class="fa-solid fa-filter me-1"></i> Filter
            </button>
        </div>
    </form>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-light text-uppercase text-xs text-muted">
                <tr>
                    <th class="ps-4">No. Pesanan</th>
                    <th>Nama Pembeli</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Metode Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Status Pesanan</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td class="ps-4 fw-bold font-monospace text-dark">{{ $order->order_number }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $order->customer_name }}</div>
                            <small class="text-muted">{{ $order->customer_phone }}</small>
                        </td>
                        <td class="text-muted small">{{ $order->created_at->translatedFormat('d M Y H:i') }}</td>
                        <td class="fw-bold text-danger">{{ $order->formatted_total_price }}</td>
                        <td><span class="badge bg-light text-dark border">{{ strtoupper($order->payment_method) }}</span></td>
                        <td><x-payment-status-badge :status="$order->payment_status" /></td>
                        <td><x-order-status-badge :status="$order->order_status" /></td>
                        <td class="pe-4 text-end">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-danger btn-sm rounded-pill font-weight-bold px-3">
                                Kelola Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-receipt fs-1 mb-2 d-block"></i>
                            Tidak ada data pesanan yang sesuai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $orders->links() }}
</div>
@endsection
