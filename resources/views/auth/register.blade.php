@extends('layouts.auth')

@section('title', 'Daftar Akun Pembeli - Kedai Marjuki\'S')

@section('content')
<div class="card auth-card bg-white p-4 p-md-5">
    <div class="card-body">
        <h4 class="fw-bold text-dark mb-1">Daftar Akun Pembeli</h4>
        <p class="text-muted small mb-4">Lengkapi data singkat berikut untuk memesan hidangan di Kedai Marjuki'S</p>

        <x-alert />

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label font-weight-bold text-dark small">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="name" id="name" class="form-control border-start-0 ps-0" placeholder="Masukkan nama Anda" value="{{ old('name') }}" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label font-weight-bold text-dark small">Nomor WhatsApp / HP</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-phone"></i></span>
                    <input type="text" name="phone" id="phone" class="form-control border-start-0 ps-0" placeholder="081234567890" value="{{ old('phone') }}" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label font-weight-bold text-dark small">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control border-start-0 ps-0" placeholder="Masukkan password Anda" required>
                </div>
            </div>

            <button type="submit" class="btn btn-danger w-100 py-2.5 font-weight-bold rounded-pill shadow-sm mb-3">
                <i class="fa-solid fa-user-plus me-2"></i> Daftar Akun
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
