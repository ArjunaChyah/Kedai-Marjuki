@extends('admin.layout')

@section('title', 'Edit Produk - Kedai Marjuki\'S')
@section('page_title', 'Edit Data Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label font-weight-bold text-dark small">Nama Produk</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label font-weight-bold text-dark small">Kategori Produk</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label font-weight-bold text-dark small">Deskripsi Produk</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="price" class="form-label font-weight-bold text-dark small">Harga (Rupiah / Integer)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required min="0">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="stock" class="form-label font-weight-bold text-dark small">Jumlah Stok (Porsi)</label>
                        <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required min="0">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="status" class="form-label font-weight-bold text-dark small">Status Produk</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="available" {{ old('status', $product->status) == 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                            <option value="unavailable" {{ old('status', $product->status) == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia (Unavailable)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label font-weight-bold text-dark small">Ganti Foto Produk (Opsional)</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <div class="mt-2 text-muted small d-flex align-items-center gap-2">
                            <span>Gambar saat ini:</span>
                            <img src="{{ $product->image_url }}" class="rounded border object-fit-cover" style="width: 40px; height: 40px;" alt="Preview">
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger rounded-pill px-4 font-weight-bold">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Perbarui Produk
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
