@extends('layouts.admin')

@section('title', 'Pengaturan QRIS - Kedai Marjuki\'S')
@section('page_title', 'Pengaturan & Upload QRIS Kedai')

@section('content')
<div class="row g-4 mb-4">
    <!-- Active QRIS Preview Card -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white">
            <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-qrcode text-danger me-2"></i> QRIS Yang Sedang Aktif</h5>

            @if ($activeQris)
                <div class="d-inline-block p-3 bg-light rounded-4 border mb-3">
                    <img src="{{ Str::startsWith($activeQris->qris_image, 'http') ? $activeQris->qris_image : asset('storage/' . $activeQris->qris_image) }}" class="img-fluid rounded-3" style="max-height: 250px;" alt="QRIS Aktif Kedai Marjuki'S">
                </div>
                <h6 class="fw-bold text-success mb-1"><i class="fa-solid fa-circle-check me-1"></i> QRIS Aktif Berfungsi</h6>
                <p class="text-muted small mb-0">{{ $activeQris->description }}</p>
                <small class="text-muted text-xs d-block mt-1">Diunggah: {{ $activeQris->created_at->translatedFormat('d M Y H:i') }}</small>
            @else
                <div class="py-5 text-muted bg-light rounded-4 border">
                    <i class="fa-solid fa-qrcode-slash display-4 mb-3 d-block"></i>
                    <p class="fw-bold text-danger mb-1">Belum ada QRIS aktif.</p>
                    <small>Silakan unggah dan aktifkan QRIS baru melalui form di samping.</small>
                </div>
            @endif
        </div>
    </div>

    <!-- Upload Form Card -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-cloud-arrow-up text-danger me-2"></i> Upload Gambar QRIS Baru</h5>

            <form action="{{ route('admin.qris.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="qris_image" class="form-label font-weight-bold text-dark small">Pilih File Gambar QRIS</label>
                    <input type="file" name="qris_image" id="qris_image" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp" required>
                    <small class="text-muted">Format: jpg, jpeg, png, webp. Ukuran maks: 2MB.</small>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label font-weight-bold text-dark small">Keterangan / Deskripsi (Opsional)</label>
                    <input type="text" name="description" id="description" class="form-control" placeholder="Contoh: QRIS Kedai Marjuki'S - Rekening BCA / GoPay" value="{{ old('description') }}">
                </div>

                <button type="submit" class="btn btn-danger rounded-pill font-weight-bold px-4">
                    <i class="fa-solid fa-upload me-1"></i> Upload QRIS Baru
                </button>
            </form>
        </div>
    </div>
</div>

<!-- History QRIS Settings Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="card-header bg-white py-3 px-4">
        <h6 class="fw-bold text-dark mb-0">Daftar Pengaturan QRIS</h6>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light text-uppercase text-xs text-muted">
                    <tr>
                        <th class="ps-4">Preview</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Tanggal Unggah</th>
                        <th class="pe-4 text-end">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($qrisSettings as $qris)
                        <tr>
                            <td class="ps-4">
                                <div class="bg-light p-1 rounded border" style="width: 50px; height: 50px;">
                                    <img src="{{ Str::startsWith($qris->qris_image, 'http') ? $qris->qris_image : asset('storage/' . $qris->qris_image) }}" class="w-100 h-100 object-fit-contain" alt="QRIS">
                                </div>
                            </td>
                            <td class="fw-bold text-dark">{{ $qris->description }}</td>
                            <td>
                                @if ($qris->is_active)
                                    <span class="badge bg-success rounded-pill px-3 py-1.5 fw-bold">AKTIF</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3 py-1.5">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $qris->created_at->translatedFormat('d M Y H:i') }}</td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    @if (!$qris->is_active)
                                        <form action="{{ route('admin.qris.activate', $qris->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success btn-sm rounded-pill font-weight-bold px-3">
                                                <i class="fa-solid fa-power-off me-1"></i> Aktifkan
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.qris.destroy', $qris->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus gambar QRIS ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill font-weight-bold px-3">
                                                <i class="fa-solid fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-success btn-sm rounded-pill font-weight-bold px-3" disabled>
                                            Sedang Digunakan
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada QRIS diunggah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
