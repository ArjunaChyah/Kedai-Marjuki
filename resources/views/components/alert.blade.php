@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm rounded-3 mb-4" role="alert">
        <i class="fa-solid fa-circle-check me-2 fs-5"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm rounded-3 mb-4" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i>
        <div>{{ session('error') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info alert-dismissible fade show d-flex align-items-center shadow-sm rounded-3 mb-4" role="alert">
        <i class="fa-solid fa-circle-info me-2 fs-5"></i>
        <div>{{ session('info') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 mb-4" role="alert">
        <div class="d-flex align-items-center mb-2">
            <i class="fa-solid fa-circle-exclamation me-2 fs-5"></i>
            <strong class="me-auto">Terjadi Kesalahan Validasi:</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <ul class="mb-0 ps-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
