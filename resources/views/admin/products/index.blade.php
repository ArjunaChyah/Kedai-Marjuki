@extends('layouts.admin')

@section('title', 'Kelola Produk - Kedai Marjuki\'S')
@section('page_title', 'Manajemen Produk Makanan & Minuman')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex flex-wrap gap-2 flex-grow-1" style="max-width: 600px;">
        <select name="category_id" class="form-select w-auto" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>

        <div class="input-group flex-grow-1">
            <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-search"></i></button>
        </div>
    </form>

    <a href="{{ route('admin.products.create') }}" class="btn btn-danger rounded-pill fw-bold px-4 flex-shrink-0">
        <i class="fa-solid fa-plus me-1"></i> Tambah Produk Baru
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-light text-uppercase text-xs text-muted">
                <tr>
                    <th class="ps-4">Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td class="ps-4">
                            <div class="bg-light rounded p-1 border" style="width: 50px; height: 50px;">
                                @if ($product->image)
                                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" class="w-100 h-100 object-fit-cover rounded" alt="{{ $product->name }}">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="fa-solid fa-image"></i></div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark mb-0">{{ $product->name }}</div>
                            <small class="text-muted font-monospace">{{ $product->slug }}</small>
                        </td>
                        <td>
                            <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1.5 fw-bold">
                                {{ $product->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="fw-bold text-danger">{{ $product->formatted_price }}</td>
                        <td>
                            <span class="fw-bold {{ $product->stock > 0 ? 'text-dark' : 'text-danger' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $product->status === 'available' ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                                {{ $product->status === 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-primary btn-sm rounded-pill font-weight-bold px-3">
                                    <i class="fa-solid fa-pen me-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill font-weight-bold px-3">
                                        <i class="fa-solid fa-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-bowl-food fs-1 mb-2 d-block"></i>
                            Belum ada data produk. Silakan tambah produk baru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $products->links() }}
</div>
@endsection
