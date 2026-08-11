@extends('layouts.admin')

@section('title', 'Kelola Kategori - Kedai Marjuki\'S')
@section('page_title', 'Manajemen Kategori Menu')

@section('content')
<div class="row g-4">
    <!-- Category Form -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-plus-circle text-danger me-2"></i> Tambah Kategori</h5>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label font-weight-bold text-dark small">Nama Kategori</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Makanan" required>
                </div>
                <button type="submit" class="btn btn-danger w-100 rounded-pill font-weight-bold">
                    <i class="fa-solid fa-save me-1"></i> Simpan Kategori
                </button>
            </form>
        </div>
    </div>

    <!-- Category List Table -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="card-header bg-white py-3 px-4">
                <h6 class="fw-bold text-dark mb-0">Daftar Kategori Menu</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light text-uppercase text-xs text-muted">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Nama Kategori</th>
                                <th>Slug</th>
                                <th>Jumlah Produk</th>
                                <th class="pe-4 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $index => $category)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                                    <td class="fw-bold text-dark">{{ $category->name }}</td>
                                    <td class="font-monospace text-muted small">{{ $category->slug }}</td>
                                    <td>
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1">
                                            {{ $category->products_count }} Produk
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill font-weight-bold px-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}">
                                                <i class="fa-solid fa-pen me-1"></i> Edit
                                            </button>
                                            
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill font-weight-bold px-3" {{ $category->products_count > 0 ? 'disabled title="Masih ada produk"' : '' }}>
                                                    <i class="fa-solid fa-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade text-start" id="editModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content rounded-4 border-0">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h5 class="modal-title fw-bold">Edit Kategori</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body py-3">
                                                            <label for="edit_name_{{ $category->id }}" class="form-label font-weight-bold small text-dark">Nama Kategori</label>
                                                            <input type="text" name="name" id="edit_name_{{ $category->id }}" class="form-control" value="{{ $category->name }}" required>
                                                        </div>
                                                        <div class="modal-footer border-0 pt-0">
                                                            <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger rounded-pill fw-bold">Perbarui</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada data kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
