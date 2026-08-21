@extends('layouts.auth')

@section('title', 'Daftar Cepat Pembeli - Kedai Marjuki\'S')

@section('content')
<div class="card auth-card bg-white p-4 p-md-5">
    <div class="card-body">
        <div class="text-center mb-3">
            <span class="badge bg-danger-subtle text-danger px-3 py-1.5 rounded-pill font-weight-bold mb-2">
                <i class="fa-solid fa-bolt me-1"></i> DAFTAR CEPAT 3 DETIK
            </span>
            <h4 class="fw-bold text-dark mb-1">Daftar Akun Pesan Kedai</h4>
            <p class="text-muted small">Cukup isi nama & nomor HP untuk langsung pesan hidangan hangat!</p>
        </div>

        <x-alert />

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label font-weight-bold text-dark small">Nama Pemesan</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="name" id="name" class="form-control border-start-0 ps-0" placeholder="Contoh: Budi / Siti" value="{{ old('name') }}" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label font-weight-bold text-dark small">Nomor WhatsApp / HP</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-brands fa-whatsapp"></i></span>
                    <input type="text" name="phone" id="phone" class="form-control border-start-0 ps-0" placeholder="081234567890" value="{{ old('phone') }}" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label font-weight-bold text-dark small">Password Bebas</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control border-start-0 ps-0" placeholder="Isi angka/kata bebas (misal: 1234)" value="1234" required>
                </div>
                <small class="text-muted text-xs mt-1 d-block"><i class="fa-solid fa-circle-info text-info me-1"></i> Bebas berapa karakter saja tanpa batasan.</small>
            </div>

            <button type="submit" class="btn btn-danger w-100 py-3 font-weight-bold rounded-pill shadow-sm mb-3 fs-6">
                <i class="fa-solid fa-utensils me-2"></i> Daftar & Langsung Pesan Menu
            </button>
        </form>

        <div class="text-center mt-3">
            <p class="text-muted small mb-0">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-danger fw-bold text-decoration-none">Masuk Langsung</a>
            </p>
        </div>
    </div>
</div>
@endsection
