@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran - Kedai Marjuki\'S')
@section('page_title', 'Verifikasi Pembayaran QRIS & Tunai')

@section('content')
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form action="{{ route('admin.payments.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-4">
            <select name="payment_status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Status Pembayaran</option>
                <option value="waiting_confirmation" {{ request('payment_status') == 'waiting_confirmation' ? 'selected' : '' }}>Menunggu Verifikasi (waiting_confirmation)</option>
                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending (Belum Dibayar)</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Lunas (paid)</option>
                <option value="rejected" {{ request('payment_status') == 'rejected' ? 'selected' : '' }}>Ditolak (rejected)</option>
            </select>
        </div>

        <div class="col-md-4">
            <select name="method" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Metode Pembayaran</option>
                <option value="qris" {{ request('method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Tunai (Cash)</option>
            </select>
        </div>
    </form>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-light text-uppercase text-xs text-muted">
                <tr>
                    <th class="ps-4">No. Pesanan</th>
                    <th>Pembeli</th>
                    <th>Total Pembayaran</th>
                    <th>Metode</th>
                    <th>Status Pembayaran</th>
                    <th>Tanggal</th>
                    <th class="pe-4 text-end">Aksi Verifikasi Admin</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $order)
                    <tr>
                        <td class="ps-4 fw-bold font-monospace text-dark">{{ $order->order_number }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $order->customer_name }}</div>
                            <small class="text-muted">{{ $order->customer_phone }}</small>
                        </td>
                        <td class="fw-bold text-danger">{{ $order->formatted_total_price }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                <i class="fa-solid {{ $order->payment_method === 'qris' ? 'fa-qrcode text-danger' : 'fa-money-bill-wave text-success' }} me-1"></i>
                                {{ strtoupper($order->payment_method) }}
                            </span>
                        </td>
                        <td><x-payment-status-badge :status="$order->payment_status" /></td>
                        <td class="text-muted small">{{ $order->created_at->translatedFormat('d M Y H:i') }}</td>
                        <td class="pe-4 text-end">
                            <div class="d-flex justify-content-end gap-1">
                                @if ($order->payment_method === 'qris' && $order->payment_status === 'waiting_confirmation')
                                    <form action="{{ route('admin.payments.confirm', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm rounded-pill font-weight-bold px-3">
                                            <i class="fa-solid fa-check me-1"></i> Konfirmasi
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.payments.reject', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill font-weight-bold px-3">
                                            <i class="fa-solid fa-times me-1"></i> Tolak
                                        </button>
                                    </form>
                                @elseif ($order->payment_method === 'cash' && $order->payment_status !== 'paid')
                                    <form action="{{ route('admin.payments.confirm-cash', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm rounded-pill font-weight-bold px-3">
                                            <i class="fa-solid fa-money-bill-check me-1"></i> Konfirmasi Pembayaran Tunai
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold">
                                        Detail
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-money-check-dollar fs-1 mb-2 d-block"></i>
                            Tidak ada data pembayaran.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $payments->links() }}
</div>
@endsection
