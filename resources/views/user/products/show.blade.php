@extends('layouts.app')

@section('title', $product->name . ' - Kedai Marjuki\'S')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-danger fw-semibold">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none text-danger fw-semibold">Menu</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <x-alert />

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-body p-4 p-lg-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-5 text-center">
                        <img src="{{ $product->image_url }}" class="img-fluid rounded-3 object-fit-cover w-100 h-100" style="max-height: 300px;" alt="{{ $product->name }}">
                </div>

                <div class="col-lg-7">
                    <span class="badge bg-danger text-white rounded-pill px-3 py-2 mb-2 font-weight-bold">
                        {{ $product->category->name ?? 'Menu' }}
                    </span>

                    <h1 class="fw-bold text-dark mb-1">{{ $product->name }}</h1>

                    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                        <div class="d-flex text-warning">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= round($product->average_rating))
                                    <i class="fa-solid fa-star"></i>
                                @else
                                    <i class="fa-regular fa-star text-muted opacity-50"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="fw-bold text-dark">{{ number_format($product->average_rating, 1) }}</span>
                        <span class="text-muted opacity-50">•</span>
                        <span class="text-muted small">
                            <i class="fa-solid fa-comment-dots me-1"></i> {{ $product->reviews_count }} Ulasan
                        </span>
                        @if ($product->reviews_count > 0)
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-0.5 text-xs">
                                <i class="fa-solid fa-circle-check me-1"></i> Pembeli Terverifikasi
                            </span>
                        @endif
                    </div>

                    <h3 class="fw-extrabold text-danger mb-3">{{ $product->formatted_price }}</h3>

                    <p class="text-muted mb-4 lead fs-6">
                        {{ $product->description ?? 'Hidangan lezat khas Kedai Marjuki\'S yang disajikan hangat dan berkualitas.' }}
                    </p>

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="fw-semibold text-dark">Status Stok:</span>
                        <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                            {{ $product->stock > 0 ? "Tersedia ({$product->stock} Porsi)" : 'Stok Habis' }}
                        </span>
                    </div>

                    @if ($product->isAvailable())
                        <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center gap-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="input-group style-qty" style="width: 130px;">
                                <span class="input-group-text bg-light border fw-bold text-muted">Qty</span>
                                <input type="number" name="quantity" class="form-control text-center font-weight-bold" value="1" min="1" max="{{ $product->stock }}">
                            </div>

                            <button type="submit" class="btn btn-danger btn-lg rounded-pill px-4 font-weight-bold shadow-sm">
                                <i class="fa-solid fa-cart-plus me-2"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-lg rounded-pill px-4 font-weight-bold" disabled>
                            <i class="fa-solid fa-ban me-2"></i> Stok Produk Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Reviews Section -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between">
            <h5 class="fw-bold text-dark mb-0">
                <i class="fa-solid fa-star text-warning me-2"></i> Ulasan &amp; Penilaian Pelanggan
            </h5>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1.5 fw-bold">
                {{ $product->reviews_count }} Ulasan
            </span>
        </div>

        <div class="card-body p-4 p-lg-5">
            <div class="row g-4 mb-4 pb-4 border-bottom align-items-center">
                <div class="col-md-4 text-center border-end-md">
                    <div class="display-3 fw-extrabold text-dark mb-0">{{ number_format($product->average_rating, 1) }}</div>
                    <div class="d-flex justify-content-center text-warning fs-5 my-2">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($product->average_rating))
                                <i class="fa-solid fa-star"></i>
                            @else
                                <i class="fa-regular fa-star text-muted opacity-50"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="text-muted small">Berdasarkan {{ $product->reviews_count }} ulasan pembeli</div>
                </div>

                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                        <div class="text-success fs-3">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark mb-0">Ulasan 100% Pembeli Terverifikasi (*Verified Purchase*)</div>
                            <small class="text-muted">Setiap ulasan dan rating bintang di Kedai Marjuki'S hanya dapat diberikan oleh pelanggan nyata setelah pesanan makanan/minuman selesai disajikan.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- List of Reviews -->
            @if ($product->reviews && $product->reviews->count() > 0)
                <div class="d-flex flex-column gap-3">
                    @foreach ($product->reviews as $rev)
                        <div class="p-3.5 bg-light rounded-3 border">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 38px; height: 38px; font-size: 14px;">
                                        {{ strtoupper(substr($rev->user->name ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $rev->user->name ?? 'Pelanggan Kedai' }}</div>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill text-xs px-2 py-0.5">
                                            <i class="fa-solid fa-check me-1"></i> Pembeli Terverifikasi
                                        </span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="text-warning small mb-1">
                                        @for ($s = 1; $s <= 5; $s++)
                                            @if ($s <= $rev->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star text-muted opacity-50"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-muted text-xs">{{ $rev->created_at->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                            </div>
                            @if ($rev->comment)
                                <p class="text-dark mb-0 ps-lg-5 small fst-italic">
                                    "{{ $rev->comment }}"
                                </p>
                            @else
                                <p class="text-muted mb-0 ps-lg-5 small fst-italic">
                                    (Pengguna memberikan rating {{ $rev->rating }} bintang tanpa komentar)
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="fa-regular fa-comment-dots fs-1 text-muted opacity-50 mb-3 d-block"></i>
                    <h6 class="fw-bold text-dark">Belum ada ulasan untuk hidangan ini</h6>
                    <p class="small mb-0">Jadilah pembeli pertama yang memberikan penilaian lezat setelah pesanan Anda selesai disajikan!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if ($relatedProducts->isNotEmpty())
        <div class="mt-5">
            <h4 class="fw-bold text-dark mb-4">Menu Lainnya dari Kategori Ini</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                @foreach ($relatedProducts as $relProduct)
                    <div class="col">
                        <x-product-card :product="$relProduct" />
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
