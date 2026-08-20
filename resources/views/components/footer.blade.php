<footer class="bg-dark text-white pt-5 pb-4 mt-auto border-top border-secondary">
    <div class="container">
        <div class="row g-4">
            <!-- Kedai Info -->
            <div class="col-lg-5 col-md-6">
                <h5 class="fw-bold text-warning mb-3 d-flex align-items-center">
                    <i class="fa-solid fa-utensils me-2"></i> KEDAI MARJUKI'S
                </h5>
                <p class="text-light-50 small mb-3">
                    Kedai yang menyediakan makanan dan minuman lezat, berkualitas, dan ramah di kantong. Kami menyajikan berbagai macam makanan dan minuman segar untuk menemani aktivitas harian Anda.
                </p>
                <div class="d-flex align-items-center gap-2">
                    <a href="https://wa.me/62882005116301?text=Halo%20Kedai%20Marjuki'S,%20saya%20ingin%20bertanya..." target="_blank" class="btn btn-success btn-sm rounded-pill px-3 fw-bold">
                        <i class="fa-brands fa-whatsapp me-1"></i> Hubungi Kedai (WhatsApp)
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-uppercase mb-3 text-white-50">Navigasi Singkat</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none hover-white"><i class="fa-solid fa-angle-right me-1 text-warning"></i> Beranda</a></li>
                    <li class="mb-2"><a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none hover-white"><i class="fa-solid fa-angle-right me-1 text-warning"></i> Lihat Semua Menu</a></li>
                    <li class="mb-2"><a href="{{ route('home') }}#tentang" class="text-white-50 text-decoration-none hover-white"><i class="fa-solid fa-angle-right me-1 text-warning"></i> Tentang Kami</a></li>
                    <li class="mb-2"><a href="{{ route('home') }}#kontak" class="text-white-50 text-decoration-none hover-white"><i class="fa-solid fa-angle-right me-1 text-warning"></i> Alamat &amp; Kontak</a></li>
                </ul>
            </div>

            <!-- Address & Contact -->
            <div class="col-lg-4 col-md-12">
                <h6 class="fw-bold text-uppercase mb-3 text-white-50">Lokasi &amp; Kontak</h6>
                <p class="text-white-50 small mb-2 d-flex align-items-start">
                    <i class="fa-solid fa-location-dot me-2 text-danger mt-1"></i>
                    <span>{{ $storeAddress }}</span>
                </p>
                <p class="text-white-50 small mb-2 d-flex align-items-center">
                    <i class="fa-solid fa-phone me-2 text-success"></i>
                    <span>{{ $storePhone }}</span>
                </p>
                <p class="text-white-50 small mb-0 d-flex align-items-center">
                    <i class="fa-solid fa-clock me-2 text-warning"></i>
                    <span>Buka Setiap Hari: 07:00 - 21:00 WIB</span>
                </p>
            </div>
        </div>

        <hr class="my-4 border-secondary">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-white-50 small">
            <div class="mb-2 mb-md-0">
                &copy; {{ date('Y') }} <strong>Kedai Marjuki'S</strong>. Hak Cipta Akan Selalu Dilindungi.
            </div>
            <div class="fw-semibold text-warning">
                Dibuat oleh {{ $creatorName }}
            </div>
        </div>
    </div>
</footer>
