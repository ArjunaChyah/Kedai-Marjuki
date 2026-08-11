@extends('layouts.auth')

@section('title', 'Daftar Akun Baru - Kedai Marjuki\'S')

@section('content')
<div class="card auth-card bg-white p-4 p-md-5">
    <div class="card-body">
        <h4 class="fw-bold text-dark mb-1">Daftar Akun Pembeli</h4>
        <p class="text-muted small mb-4">Buat akun baru untuk mulai memesan makanan online</p>

        <x-alert />

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label font-weight-bold text-dark small">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="name" id="name" class="form-control border-start-0 ps-0" placeholder="Nama Anda" value="{{ old('name') }}" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label font-weight-bold text-dark small">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control border-start-0 ps-0" placeholder="nama@email.com" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label font-weight-bold text-dark small">Nomor WhatsApp</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-brands fa-whatsapp"></i></span>
                    <input type="text" name="phone" id="phone" class="form-control border-start-0 ps-0" placeholder="0882005116301" value="{{ old('phone') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label font-weight-bold text-dark small">Alamat Lengkap Rumah</label>
                <textarea name="address" id="address" class="form-control" rows="2" placeholder="Jl. Jomblang Perbalan No 800..." required>{{ old('address') }}</textarea>
            </div>

            <div class="row g-2 mb-4">
                <div class="col-md-6">
                    <label for="password" class="form-label font-weight-bold text-dark small">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Min. 8 karakter" required>
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label font-weight-bold text-dark small">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-danger w-100 py-2.5 font-weight-bold rounded-pill shadow-sm mb-3">
                <i class="fa-solid fa-user-plus me-2"></i> Daftar Sekarang
            </button>
        </form>

        <div class="text-center mt-3">
            <p class="text-muted small mb-0">
                Sudah memiliki akun? <a href="{{ route('login') }}" class="text-danger fw-bold text-decoration-none">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
