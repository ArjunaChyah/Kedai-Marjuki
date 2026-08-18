@props(['product'])

<div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden product-card hover-lift transition-all">
    <div class="position-relative overflow-hidden bg-light" style="height: 200px;">
        <img src="{{ $product->image_url }}" class="card-img-top w-100 h-100 object-fit-cover" alt="{{ $product->name }}">

        <span class="position-absolute top-0 start-0 m-3 badge bg-danger text-white rounded-pill shadow-sm px-2.5 py-1.5 font-weight-bold">
            {{ $product->category->name ?? 'Menu' }}
        </span>

        @if (!$product->isAvailable())
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center text-white fw-bold fs-5">
                <span class="badge bg-danger rounded-pill px-3 py-2">STOK HABIS</span>
            </div>
        @endif
    </div>

    <div class="card-body d-flex flex-column p-3">
        <h5 class="card-title fw-bold text-dark mb-1 text-truncate">
            <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark hover-danger">
                {{ $product->name }}
            </a>
        </h5>
        
        <p class="card-text text-muted small mb-3 text-line-clamp-2" style="min-height: 38px;">
            {{ Str::limit($product->description ?? 'Makanan lezat dan higienis buatan Kedai Marjuki\'S.', 70) }}
        </p>

        <div class="mt-auto d-flex align-items-center justify-content-between pt-2 border-top">
            <div>
                <span class="text-xs text-muted d-block">Harga</span>
                <span class="fw-bold text-danger fs-5">{{ $product->formatted_price }}</span>
            </div>

            <div class="text-end">
                <span class="badge {{ $product->stock > 0 ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger' }} rounded-pill mb-1 d-block text-xs">
                    Stok: {{ $product->stock }}
                </span>
                
                @if ($product->isAvailable())
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold shadow-sm">
                            <i class="fa-solid fa-plus me-1"></i> Keranjang
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary btn-sm rounded-pill px-3 fw-bold" disabled>
                        Habis
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
