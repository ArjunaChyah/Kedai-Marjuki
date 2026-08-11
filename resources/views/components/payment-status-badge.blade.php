@props(['status'])

@php
    $class = match ($status) {
        'pending' => 'bg-warning text-dark',
        'waiting_confirmation' => 'bg-info text-white',
        'paid' => 'bg-success text-white',
        'rejected' => 'bg-danger text-white',
        'cancelled' => 'bg-secondary text-white',
        default => 'bg-secondary text-white',
    };

    $label = match ($status) {
        'pending' => 'Belum Dibayar',
        'waiting_confirmation' => 'Menunggu Verifikasi',
        'paid' => 'Sudah Dibayar',
        'rejected' => 'Pembayaran Ditolak',
        'cancelled' => 'Dibatalkan',
        default => $status,
    };
@endphp

<span class="badge {{ $class }} px-2.5 py-1.5 rounded-pill font-weight-bold">
    {{ $label }}
</span>
