@extends('layouts.app')

@section('title', 'Keranjang Belanja - Kedai Marjuki\'S')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-dark mb-1">
        <i class="fa-solid fa-cart-shopping text-danger me-2"></i> Keranjang Belanja Saya
    </h2>
    <p class="text-muted mb-4">Periksa kembali daftar hidangan sebelum melanjutkan ke pembayaran</p>

    <x-alert />

    @if (!$cart || $cart->items->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 text-center py-5 p-4">
            <div class="card-body">
                <i class="fa-solid fa-cart-flatbed fs-1 text-muted mb-3 d-block"></i>
                <h4 class="fw-bold text-dark">Keranjang kamu masih kosong.</h4>
                <p class="text-muted mb-4">Yuk, cari makanan atau minuman lezat favoritmu di Kedai Marjuki'S!</p>
                <a href="{{ route('products.index') }}" class="btn btn-danger btn-lg rounded-pill px-5 font-weight-bold shadow-sm">
                    <i class="fa-solid fa-utensils me-2"></i> Lihat Menu Sekarang
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            <!-- Cart Items List -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-dark mb-0">Item Produk ({{ $cart->items->sum('quantity') }})</h6>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan keranjang belanja Anda?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill fw-bold">
                                <i class="fa-solid fa-trash-can me-1"></i> Kosongkan Keranjang
                            </button>
                        </form>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="bg-light text-uppercase text-xs text-muted">
                                    <tr>
                                        <th class="ps-4">Produk</th>
                                        <th>Harga</th>
                                        <th style="width: 140px;">Jumlah</th>
                                        <th>Subtotal</th>
                                        <th class="pe-4 text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart->items as $item)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3 py-2">
                                                    <div class="bg-light rounded p-1 border flex-shrink-0" style="width: 60px; height: 60px;">
                                                        @if ($item->product->image)
                                                            <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('storage/' . $item->product->image) }}" class="w-100 h-100 object-fit-cover rounded" alt="{{ $item->product->name }}">
                                                        @else
                                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="fa-solid fa-bowl-food"></i></div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold text-dark mb-0">{{ $item->product->name }}</h6>
                                                        <small class="text-muted">{{ $item->product->category->name ?? '' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-semibold">{{ $item->product->formatted_price }}</td>
                                            <td>
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center gap-1">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" name="quantity" class="form-control form-control-sm text-center fw-bold" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" style="width: 60px;" onchange="this.form.submit()">
                                                </form>
                                            </td>
                                            <td class="fw-bold text-danger">{{ $item->formatted_subtotal }}</td>
                                            <td class="pe-4 text-end">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0" title="Hapus item">
                                                        <i class="fa-solid fa-trash-can fs-5"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Summary Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 90px;">
                    <h5 class="fw-bold text-dark mb-3">Ringkasan Pesanan</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Subtotal</span>
                        <span class="fw-semibold">{{ $cart->formatted_total_price }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Ongkos Kirim / Ambil</span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">GRATIS</span>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold text-dark fs-5">Total Bayar</span>
                        <span class="fw-extrabold text-danger fs-4">{{ $cart->formatted_total_price }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-danger btn-lg w-100 rounded-pill font-weight-bold shadow-sm py-2.5 mb-2">
                        Lanjut ke Checkout <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>

                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 rounded-pill font-weight-bold">
                        Tambah Menu Lainnya
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
