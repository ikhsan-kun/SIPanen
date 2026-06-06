<?php

use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ──────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/produk/{slug}', [HomeController::class, 'productDetail'])->name('product.detail');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');

// ── Auth Routes ────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Customer Routes ────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart');
    Route::post('/keranjang/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/keranjang/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/pesanan', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/pesanan/{id}', [OrderController::class, 'detail'])->name('orders.detail');
    Route::get('/pesanan/{id}/konfirmasi-bayar', [OrderController::class, 'showConfirmPayment'])->name('orders.confirm-payment');
    Route::post('/pesanan/{id}/konfirmasi-bayar', [OrderController::class, 'submitConfirmPayment'])->name('orders.submit-confirm-payment');
});

// ── Admin Routes ───────────────────────────────────────────────────────────────
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::resource('produk', AdminProductController::class)
            ->names('products')
            ->parameters(['produk' => 'product']);
        Route::patch('produk/{product}/stok', [AdminProductController::class, 'updateStock'])->name('products.update-stock');

        // Orders
        Route::get('pesanan', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('pesanan/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('pesanan/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('konfirmasi-bayar/{id}', [AdminOrderController::class, 'confirmPayment'])->name('orders.confirm-payment');

        // Customers
        Route::get('pelanggan', [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::get('pelanggan/{user}', [AdminCustomerController::class, 'show'])->name('customers.show');

        // Reports
        Route::get('laporan', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('laporan/cetak', [AdminReportController::class, 'print'])->name('reports.print');
    });
