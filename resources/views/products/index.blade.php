@extends('layouts.app')

@section('title', 'Daftar Menu Makanan & Minuman - Kedai Marjuki\'S')

@section('content')
<div class="container py-4">
    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-bowl-food text-danger me-2"></i> Daftar Menu Kedai
            </h2>
            <p class="text-muted mb-0">Temukan hidangan favoritmu dan langsung pesan secara online</p>
        </div>

        <div class="col-md-6">
            <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white">
                    <span class="input-group-text bg-white border-0 ps-3 text-muted">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 shadow-none" placeholder="Cari Soto, Indomie, Es Teh..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-danger px-4 font-weight-bold">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-alert />

    <!-- Aesthetic Product Menu Container -->
    <div class="menu-aesthetic-section p-4 p-md-5 mb-4">
        <!-- Category Pills Filter -->
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
            <span class="fw-bold text-white me-2 small"><i class="fa-solid fa-filter text-warning me-1"></i> Filter Kategori:</span>
            <a href="{{ route('products.index', request()->only('search')) }}" class="btn {{ !request('category') ? 'btn-warning text-dark font-weight-bold' : 'btn-outline-light' }} btn-sm rounded-pill px-3">
                Semua Menu
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('products.index', array_merge(request()->only('search'), ['category' => $cat->slug])) }}" class="btn {{ request('category') == $cat->slug ? 'btn-warning text-dark font-weight-bold' : 'btn-outline-light' }} btn-sm rounded-pill px-3">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        @if ($products->isEmpty())
            <div class="text-center py-5 bg-white bg-opacity-10 backdrop-blur rounded-4 shadow-sm border border-white border-opacity-25 p-4 text-white">
                <i class="fa-solid fa-folder-open fs-1 text-warning mb-3 d-block"></i>
                <h5 class="fw-bold text-white">Belum ada produk yang cocok.</h5>
                <p class="text-white-50 mb-3">Coba gunakan kata kunci pencarian lain atau pilih kategori berbeda.</p>
                <a href="{{ route('products.index') }}" class="btn btn-warning rounded-pill px-4 font-weight-bold text-dark">
                    Tampilkan Semua Produk
                </a>
            </div>
        @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-4">
                @foreach ($products as $product)
                    <div class="col">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
