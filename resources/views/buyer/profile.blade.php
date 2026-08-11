@extends('layouts.app')

@section('title', 'Profil Saya - Kedai Marjuki\'S')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-user-gear text-danger me-2"></i> Pengaturan Profil Saya
            </h2>
            <p class="text-muted mb-4">Perbarui informasi diri dan alamat pengiriman Anda</p>

            <x-alert />

            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="fw-bold text-dark mb-3">Informasi Diri</h5>

                    <div class="mb-3">
                        <label for="name" class="form-label font-weight-bold text-dark small">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label font-weight-bold text-dark small">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label font-weight-bold text-dark small">Nomor WhatsApp</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required placeholder="0882005116301">
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label font-weight-bold text-dark small">Alamat Rumah Lengkap</label>
                        <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address', $user->address) }}</textarea>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold text-dark mb-2">Ubah Password (Opsional)</h5>
                    <p class="text-muted small mb-3">Kosongkan jika Anda tidak ingin mengubah password akun Anda.</p>

                    <div class="mb-3">
                        <label for="old_password" class="form-label font-weight-bold text-dark small">Password Saat Ini</label>
                        <input type="password" name="old_password" id="old_password" class="form-control" placeholder="••••••••">
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="password" class="form-label font-weight-bold text-dark small">Password Baru</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Min. 8 karakter">
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label font-weight-bold text-dark small">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-danger btn-lg rounded-pill px-5 font-weight-bold shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan Profil
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
