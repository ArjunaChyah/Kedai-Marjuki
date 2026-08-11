<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm py-3 border-bottom border-secondary border-opacity-25">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center fw-bold fs-4 text-white" href="{{ route('home') }}">
            <i class="fa-solid fa-utensils me-2"></i>
            Kedai Marjuki'S
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold text-uppercase fs-7">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">
                        <i class="fa-solid fa-house me-1"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active fw-bold' : '' }}" href="{{ route('products.index') }}">
                        <i class="fa-solid fa-bowl-food me-1"></i> Menu Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#tentang">
                        <i class="fa-solid fa-store me-1"></i> Tentang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#kontak">
                        <i class="fa-solid fa-phone me-1"></i> Kontak
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                @auth
                    @php
                        $cartCount = auth()->user()->cart?->items->sum('quantity') ?? 0;
                    @endphp
                    <a href="{{ route('cart.index') }}" class="btn btn-warning position-relative font-weight-bold rounded-pill px-3 shadow-sm">
                        <i class="fa-solid fa-cart-shopping me-1"></i> Keranjang
                        @if ($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle font-weight-bold rounded-pill px-3 shadow-sm d-flex align-items-center gap-2" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user-circle text-danger fs-5"></i>
                            <span>{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2" aria-labelledby="userMenu">
                            @if (auth()->user()->isAdmin())
                                <li>
                                    <a class="dropdown-menu-item text-danger fw-bold dropdown-item py-2" href="{{ route('admin.dashboard') }}">
                                        <i class="fa-solid fa-gauge me-2"></i> Panel Admin
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('buyer.dashboard') }}">
                                    <i class="fa-solid fa-border-all me-2"></i> Dashboard Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('orders.index') }}">
                                    <i class="fa-solid fa-receipt me-2"></i> Pesanan Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.index') }}">
                                    <i class="fa-solid fa-user-gear me-2"></i> Pengaturan Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger fw-bold">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar / Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4 fw-semibold">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-warning text-dark font-weight-bold rounded-pill px-4 shadow-sm">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
