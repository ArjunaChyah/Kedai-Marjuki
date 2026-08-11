@props(['status'])

@php
    $class = match ($status) {
        'pending' => 'bg-warning text-dark',
        'confirmed' => 'bg-info text-white',
        'processing' => 'bg-primary text-white',
        'ready' => 'bg-purple text-white style-purple',
        'completed' => 'bg-success text-white',
        'cancelled' => 'bg-danger text-white',
        default => 'bg-secondary text-white',
    };

    $label = match ($status) {
        'pending' => 'Menunggu',
        'confirmed' => 'Dikonfirmasi',
        'processing' => 'Diproses',
        'ready' => 'Siap Diambil/Dikirim',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
        default => $status,
    };
@endphp

<span class="badge {{ $class }} px-2.5 py-1.5 rounded-pill font-weight-bold">
    {{ $label }}
</span>
