@extends('layouts.app')

@section('title', 'Kedai Marjuki\'S - Cita Rasa Halaman Rumah')

@section('content')

<!-- Hero Section -->
<section class="hero-banner shadow-lg mb-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7 text-center text-lg-start">
                <span class="badge bg-warning text-dark font-weight-bold px-3 py-2 rounded-pill mb-3 text-uppercase shadow-sm">
                    <i class="fa-solid fa-house-chimney me-1"></i> Kedai Rumahan Candi Semarang
                </span>
                <h1 class="display-4 fw-extrabold mb-3 text-white">
                    Kuliner Masakan <br>
                    <span class="text-warning">Kedai Marjuki'S</span>
                </h1>
                <p class="lead text-white-50 mb-4 pe-lg-4 fs-5">
                    Nikmati berbagai pilihan makanan dan minuman rumahan dengan harga terjangkau. Dimasak bersih, higienis, dan penuh kehangatan khas masakan rumah.
                </p>
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                    <a href="#menu" class="btn btn-warning btn-lg font-weight-bold rounded-pill px-4 shadow">
                        <i class="fa-solid fa-utensils me-2"></i> Lihat Menu
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-danger btn-lg font-weight-bold rounded-pill px-4 shadow-sm">
                        <i class="fa-solid fa-bag-shopping me-2"></i> Pesan Sekarang
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <div class="p-3 bg-white bg-opacity-10 rounded-4 backdrop-blur shadow-lg border border-white border-opacity-25">
                    <img src="{{ asset('foto_website/warung.jpg') }}" alt="Kedai Marjuki'S Real Photo" class="img-fluid rounded-3 mb-3 shadow object-fit-cover w-100" style="max-height: 250px;">
                    <h5 class="fw-bold text-white mb-1">Kedai Marjuki'S </h5>
                    <p class="text-warning fw-semibold mb-0"><i class="fa-solid fa-location-dot me-1"></i> Jl.Jomblang Perbalan No800 </p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <x-alert />

    <!-- Menu Section -->
    <section id="menu" class="menu-aesthetic-section mb-5">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
            <div>
                <h2 class="fw-bold text-white mb-1">
                    <i class="fa-solid fa-fire text-warning me-2"></i> Menu Kedai Marjuki'S
                </h2>
                <p class="text-white-50 mb-0">Pilihan hidangan siap saji dari Kedai Marjuki'S</p>
            </div>
            
            <!-- Category Filter Pills -->
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('home') }}#menu" class="btn {{ !request('category') ? 'btn-warning text-dark font-weight-bold' : 'btn-outline-light' }} rounded-pill px-3 py-2 text-sm">
                    Semua
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('home', ['category' => $cat->slug]) }}#menu" class="btn {{ request('category') == $cat->slug ? 'btn-warning text-dark font-weight-bold' : 'btn-outline-light' }} rounded-pill px-3 py-2 text-sm">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        @if ($featuredProducts->isEmpty())
            <div class="text-center py-5 bg-white bg-opacity-10 backdrop-blur rounded-4 shadow-sm border border-white border-opacity-25 p-4 text-white">
                <i class="fa-solid fa-utensils fs-1 text-warning mb-3 d-block"></i>
                <h5 class="fw-bold text-white">Belum ada produk tersedia.</h5>
                <p class="text-white-50">Silakan cek kembali nanti atau hubungi admin kedai.</p>
            </div>
        @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4 mb-4">
                @foreach ($featuredProducts as $product)
                    <div class="col">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg rounded-pill px-5 font-weight-bold shadow">
                    Lihat Seluruh Menu ({{ \App\Models\Product::count() }} Produk) <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>
        @endif
    </section>

    <!-- Payment Methods Info Section -->
    <section class="my-5 py-4 bg-white rounded-4 shadow-sm border p-4">
        <div class="row align-items-center g-4">
            <div class="col-md-4 text-center border-end-md">
                <h4 class="fw-bold text-dark mb-2">Metode Pembayaran Mudah</h4>
                <p class="text-muted small mb-0">Transaksi praktis dan aman secara online melalui website</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="p-3 bg-light rounded-3">
                    <i class="fa-solid fa-qrcode fs-2 text-danger mb-2"></i>
                    <h6 class="fw-bold mb-1">QRIS Digital</h6>
                    <p class="text-muted text-xs mb-0">Bayar instan dengan scan QRIS menggunakan GoPay, OVO, ShopeePay, Dana, &amp; Mobile Banking.</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="p-3 bg-light rounded-3">
                    <i class="fa-solid fa-money-bill-wave fs-2 text-success mb-2"></i>
                    <h6 class="fw-bold mb-1">Tunai (Cash)</h6>
                    <p class="text-muted text-xs mb-0">Bayar secara langsung kepada pihak Kedai Marjuki'S saat pesanan diambil atau diterima.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Tentang -->
    <section id="tentang" class="my-5 py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="p-2 bg-white rounded-4 shadow border">
                    <img src="{{ asset('foto_website/warung.jpg') }}" alt="Foto Kedai Marjuki'S" class="img-fluid rounded-3 w-100 object-fit-cover shadow-sm" style="max-height: 320px;">
                </div>
            </div>
            <div class="col-lg-6">
                <span class="badge bg-danger-subtle text-danger font-weight-bold px-3 py-2 rounded-pill mb-2">
                    Tentang Kami
                </span>
                <h2 class="fw-bold text-dark mb-3">Kuliner Rumahan, Harga Bersahabat</h2>
                <p class="text-muted lead fs-6 mb-3">
                    <strong>Kedai Marjuki'S</strong> adalah kedai rumahan yang berada di halaman rumah dan menyediakan makanan serta minuman dengan harga yang terjangkau.
                </p>
                <p class="text-muted mb-4">
                    Berdiri dengan semangat menyajikan masakan nikmat khas keluarga, kami selalu menggunakan bahan-bahan segar setiap harinya. Pilihan tepat untuk sarapan, makan siang, maupun makan malam santai Anda.
                </p>
                <div class="row g-3 text-center">
                    <div class="col-4">
                        <div class="p-3 bg-white rounded-3 shadow-sm border">
                            <h4 class="fw-bold text-danger mb-0">Rp3rb</h4>
                            <small class="text-muted">Mulai Harga</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-white rounded-3 shadow-sm border">
                            <h4 class="fw-bold text-danger mb-0">100%</h4>
                            <small class="text-muted">Halal &amp; Higienis</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-white rounded-3 shadow-sm border">
                            <h4 class="fw-bold text-danger mb-0">Cepat</h4>
                            <small class="text-muted">Penyajian</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Kontak -->
    <section id="kontak" class="my-5 py-4">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-dark text-white p-4 p-md-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <span class="badge bg-warning text-dark font-weight-bold px-3 py-2 rounded-pill mb-3">
                        Kontak &amp; Lokasi Usaha
                    </span>
                    <h2 class="fw-bold mb-3">Kunjungi Kedai Marjuki'S</h2>
                    <p class="text-white-50 mb-4">
                        Kedai kami berada tepat di halaman rumah. Datang dan nikmati hidangan hangat langsung di tempat atau pesan online untuk diambil.
                    </p>

                    <div class="d-flex flex-column gap-3 mb-4">
                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-danger rounded-circle p-2 text-white mt-1 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-white mb-0">Alamat Lengkap</h6>
                                <p class="text-white-50 mb-0">JL. Jomblang Perbalan No 800 Candi, Candisari, Semarang, Jawa Tengah</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-success rounded-circle p-2 text-white mt-1 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-white mb-0">WhatsApp Kedai</h6>
                                <p class="text-white-50 mb-0">0882005116301 (Hanya untuk komunikasi umum kedai)</p>
                            </div>
                        </div>
                    </div>

                    <a href="https://wa.me/62882005116301?text=Halo%20Kedai%20Marjuki'S,%20saya%20ingin%20bertanya%20informasi%20kedai..." target="_blank" class="btn btn-success btn-lg rounded-pill px-4 fw-bold shadow">
                        <i class="fa-brands fa-whatsapp me-2"></i> Hubungi Kedai
                    </a>
                </div>

                <div class="col-lg-5 text-center">
                    <div class="p-4 bg-white text-dark rounded-4 shadow">
                        <i class="fa-solid fa-store fs-1 text-danger mb-3"></i>
                        <h5 class="fw-bold mb-2">Lokasi Kedai Rumahan</h5>
                        <p class="text-muted small mb-3">Halaman Rumah Kedai Marjuki'S<br>Candisari, Semarang</p>
                        <span class="badge bg-success rounded-pill px-3 py-2">
                            <i class="fa-solid fa-door-open me-1"></i> Buka 07:00 - 21:00 WIB
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
