@extends('layouts.admin')

@section('title', 'Daftar Pelanggan - Kedai Marjuki\'S')
@section('page_title', 'Daftar Pengguna / Pelanggan')

@section('content')
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-3">
            <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Role</option>
                <option value="buyer" {{ request('role') == 'buyer' ? 'selected' : '' }}>Pembeli (buyer)</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator (admin)</option>
            </select>
        </div>

        <div class="col-md-6">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama, email, atau WhatsApp..." value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-danger btn-sm w-100 font-weight-bold">
                <i class="fa-solid fa-search me-1"></i> Cari Pengguna
            </button>
        </div>
    </form>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-light text-uppercase text-xs text-muted">
                <tr>
                    <th class="ps-4">No</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>No. WhatsApp</th>
                    <th>Role</th>
                    <th class="pe-4">Tanggal Terdaftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $u)
                    <tr>
                        <td class="ps-4 text-muted fw-bold">{{ $users->firstItem() + $index }}</td>
                        <td>
                            <div class="fw-bold text-dark mb-0">{{ $u->name }}</div>
                            <small class="text-muted text-xs">{{ Str::limit($u->address, 50) }}</small>
                        </td>
                        <td class="fw-semibold text-dark">{{ $u->email }}</td>
                        <td>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $u->phone) }}" target="_blank" class="text-success fw-bold text-decoration-none">
                                <i class="fa-brands fa-whatsapp me-1"></i> {{ $u->phone }}
                            </a>
                        </td>
                        <td>
                            <span class="badge {{ $u->role === 'admin' ? 'bg-danger' : 'bg-primary' }} rounded-pill px-3 py-1.5 fw-bold">
                                {{ strtoupper($u->role) }}
                            </span>
                        </td>
                        <td class="pe-4 text-muted small">{{ $u->created_at->translatedFormat('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada data pengguna yang sesuai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $users->links() }}
</div>
@endsection
