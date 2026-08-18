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

                    <h1 class="fw-bold text-dark mb-2">{{ $product->name }}</h1>

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
