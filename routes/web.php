<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\QrisController as AdminQrisController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|==========================================================================
| 1. RUTE PUBLIK & KATALOG MENU (Bisa diakses siapa saja)
|==========================================================================
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

/*
|==========================================================================
| 2. RUTE AUTENTIKASI (LOGIN & REGISTER)
|==========================================================================
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|==========================================================================
| 3. RUTE USER / PELANGGAN (Wajib Login)
|==========================================================================
*/
Route::middleware('auth')->group(function () {

    // --- [DASHBOARD PELANGGAN] ---
    Route::get('/dashboard', [OrderController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/buyer/dashboard', [OrderController::class, 'dashboard'])->name('buyer.dashboard'); // Alias kompatibel
    
    // --- [KERANJANG BELANJA] ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // --- [CHECKOUT & PEMBAYARAN] ---
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/payment/{order}', [OrderController::class, 'payment'])->name('orders.payment');
    Route::post('/payment/{order}/confirm-qris', [OrderController::class, 'confirmQrisPayment'])->name('orders.confirm-qris');

    // --- [DAFTAR PESANAN SAYA] ---
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // =========================================================================
    // [FITUR 3] LIVE STATUS TRACKER PESANAN (Real-time in-app tanpa WA)
    // =========================================================================
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // =========================================================================
    // [FITUR 1] CETAK STRUK KASIR TERMAL 58MM (Format POS Thermal Receipt)
    // =========================================================================
    Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');

    // =========================================================================
    // [FITUR 4] SISTEM ULASAN & RATING BINTANG (Verified Purchase Review)
    // =========================================================================
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // --- [PENGATURAN PROFIL USER] ---
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|==========================================================================
| 4. RUTE ADMIN & KASIR (Wajib Login + Role Admin)
|==========================================================================
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // --- [DASHBOARD & STATISTIK ADMIN] ---
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/live-stats', [AdminDashboardController::class, 'liveStats'])->name('live-stats');

    // --- [MANAJEMEN PRODUK & KATEGORI] ---
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // --- [MANAJEMEN PESANAN & DAPUR] ---
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

    // =========================================================================
    // [FITUR 2] SMART TABLE QR ORDERING (Generate Kartu Meja Akrilik 1-10)
    // =========================================================================
    Route::get('/tables/qr', [AdminOrderController::class, 'tablesQr'])->name('tables.qr');

    // --- [VERIFIKASI PEMBAYARAN KASIR] ---
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{order}/confirm', [AdminPaymentController::class, 'confirm'])->name('payments.confirm');
    Route::post('/payments/{order}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');
    Route::post('/payments/{order}/confirm-cash', [AdminPaymentController::class, 'confirmCash'])->name('payments.confirm-cash');

    // --- [PENGATURAN QRIS STATIS] ---
    Route::get('/qris', [AdminQrisController::class, 'index'])->name('qris.index');
    Route::post('/qris', [AdminQrisController::class, 'store'])->name('qris.store');
    Route::post('/qris/{qris}/activate', [AdminQrisController::class, 'activate'])->name('qris.activate');
    Route::delete('/qris/{qris}', [AdminQrisController::class, 'destroy'])->name('qris.destroy');

    // --- [MANAJEMEN PENGGUNA & LAPORAN] ---
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
});
