@extends('layouts.auth')

@section('title', 'Masuk Akun - Kedai Marjuki\'S')

@section('content')
<div class="card auth-card bg-white p-4 p-md-5">
    <div class="card-body">
        <h4 class="fw-bold text-dark mb-1">Masuk Akun</h4>
        <p class="text-muted small mb-4">Silakan masuk untuk melanjutkan pemesanan makanan</p>

        <x-alert />

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label font-weight-bold text-dark small">Email / Username / No. HP</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                    <input type="text" name="email" id="email" class="form-control border-start-0 ps-0" placeholder="nama@email.com atau 0812..." value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label font-weight-bold text-dark small">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control border-start-0 ps-0" placeholder="...." required>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-muted small" for="remember">
                        Ingat Saya
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-danger w-100 py-2.5 font-weight-bold rounded-pill shadow-sm mb-3">
                <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk Sekarang
            </button>
        </form>

        <div class="text-center mt-3">
            <p class="text-muted small mb-0">
                Belum memiliki akun? <a href="{{ route('register') }}" class="text-danger fw-bold text-decoration-none">Daftar Akun Baru</a>
            </p>
        </div>
    </div>
</div>
@endsection
