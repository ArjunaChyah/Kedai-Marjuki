@extends('layouts.admin')

@section('title', 'QR Code Meja Pelanggan - Kedai Marjuki\'S')
@section('page_title', 'Smart Table QR Ordering')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-qrcode text-danger me-2"></i> QR Code Meja Pelanggan
        </h4>
        <p class="text-muted small mb-0">
            Cetak kartu QR ini dan letakkan di meja makan (Meja 01 s.d Meja 10). Pelanggan cukup scan dengan kamera HP untuk pesan mandiri.
        </p>
    </div>

    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-danger rounded-pill fw-bold shadow-sm px-4">
            <i class="fa-solid fa-print me-1"></i> Cetak Semua Kartu Meja
        </button>
    </div>
</div>

<div class="row g-4 print-grid">
    @foreach ($tables as $table)
        <div class="col-xl-3 col-lg-4 col-md-6 print-card-col">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden text-center table-qr-card h-100">
                <!-- Card Header -->
                <div class="bg-danger text-white py-3 px-3">
                    <div class="fw-bold small text-uppercase letter-spacing-1">Kedai Marjuki'S</div>
                    <div class="fs-4 fw-extrabold">{{ $table['name'] }}</div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-between">
                    <p class="text-muted small mb-3">
                        <i class="fa-solid fa-camera text-danger me-1"></i> Scan untuk pesan langsung
                    </p>

                    <!-- QR Code Image -->
                    <div class="p-2 border rounded-3 bg-white shadow-xs mb-3 qr-wrapper">
                        <img src="{{ $table['qr_url'] }}" alt="QR {{ $table['name'] }}" class="img-fluid rounded" style="width: 170px; height: 170px;">
                    </div>

                    <div class="small font-monospace text-muted text-break mb-3" style="font-size: 11px;">
                        {{ $table['url'] }}
                    </div>

                    <div class="w-100 no-print">
                        <a href="{{ $table['url'] }}" target="_blank" class="btn btn-outline-danger btn-sm w-100 rounded-pill fw-semibold mb-2">
                            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Coba Buka Link
                        </a>
                        <button onclick="printSingleTable('{{ $table['number'] }}')" class="btn btn-light btn-sm w-100 rounded-pill text-muted fw-semibold border">
                            <i class="fa-solid fa-print me-1"></i> Cetak Meja Ini
                        </button>
                    </div>
                </div>

                <!-- Card Footer (Print only) -->
                <div class="card-footer bg-light py-2 text-muted small border-top print-only">
                    Jl. Candisari No. 08, Semarang • Self-Ordering System
                </div>
            </div>
        </div>
    @endforeach
</div>

@push('styles')
<style>
    .letter-spacing-1 {
        letter-spacing: 1px;
    }
    .shadow-xs {
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .table-qr-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .table-qr-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .print-only {
        display: none;
    }

    /* Print Layout - Formatted for standard paper (A4) tent cards */
    @media print {
        body {
            background: #fff !important;
        }
        .navbar, .sidebar, .d-flex.flex-wrap, .no-print, footer, .alert {
            display: none !important;
        }
        main, .container-fluid, .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        .print-grid {
            display: flex !important;
            flex-wrap: wrap !important;
            margin: 0 !important;
        }
        .print-card-col {
            width: 50% !important;
            max-width: 50% !important;
            flex: 0 0 50% !important;
            padding: 12px !important;
            page-break-inside: avoid;
        }
        .table-qr-card {
            border: 2px solid #000 !important;
            box-shadow: none !important;
            border-radius: 8px !important;
        }
        .bg-danger {
            background-color: #000 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .print-only {
            display: block !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function printSingleTable(tableNumber) {
        window.open("{{ url('/admin/tables/qr') }}", '_self');
        window.print();
    }
</script>
@endpush
@endsection
