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
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ──────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/produk/{slug}', [HomeController::class, 'productDetail'])->name('product.detail');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');

// Midtrans webhook — exempt from CSRF (already handled via signature verification)
Route::post('/midtrans/callback', [OrderController::class, 'midtransCallback'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

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

    // Refresh snap token for pending/unpaid orders (resume payment)
    Route::post('/pesanan/{order}/refresh-token', [OrderController::class, 'refreshSnapToken'])->name('orders.refresh-token');

    // Check payment status manually from Midtrans
    Route::post('/pesanan/{order}/check-status', [OrderController::class, 'checkPaymentStatus'])->name('orders.check-status');

    // Complete order (user confirms package receipt)
    Route::post('/pesanan/{order}/complete', [OrderController::class, 'completeOrder'])->name('orders.complete');

    // Live Tracking
    Route::get('/pesanan/{order}/lacak', [TrackingController::class, 'track'])->name('orders.track');
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
        Route::post('pesanan/{order}/check-status', [AdminOrderController::class, 'checkPaymentStatus'])->name('orders.check-status');
        Route::get('pesanan/{order}/lacak', [TrackingController::class, 'trackAdmin'])->name('orders.track-admin');

        // Customers
        Route::get('pelanggan', [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::get('pelanggan/{user}', [AdminCustomerController::class, 'show'])->name('customers.show');

        // Reports
        Route::get('laporan', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('laporan/cetak', [AdminReportController::class, 'print'])->name('reports.print');
    });
