<?php

use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminHeroController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminPesananController;
use App\Http\Controllers\Admin\AdminProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Guest-only routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated route for logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Customer routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [CustomerController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
    Route::get('/produk/{id}', [OrderController::class, 'showProductDetail'])->name('produk.detail');
    Route::post('/produk/{id}/order', [OrderController::class, 'placeOrder'])->name('order.store');
    Route::get('/pesanan/{id}/pembayaran', [CustomerController::class, 'uploadPaymentForm'])->name('pembayaran');
    Route::post('/pesanan/{id}/pembayaran', [CustomerController::class, 'storePayment'])->name('pembayaran.store');
    Route::put('/pesanan/{id}/edit', [CustomerController::class, 'updateOrder'])->name('pesanan.update');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // CMS Kategori
    Route::get('/kategori', [AdminKategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [AdminKategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{id}', [AdminKategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [AdminKategoriController::class, 'destroy'])->name('kategori.destroy');
    
    // CMS Produk
    Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk.index');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('produk.store');
    Route::post('/produk/{id}', [AdminProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');
    
    // CMS Hero Banner
    Route::get('/hero', [AdminHeroController::class, 'index'])->name('hero.index');
    Route::post('/hero', [AdminHeroController::class, 'store'])->name('hero.store');
    Route::post('/hero/{id}', [AdminHeroController::class, 'update'])->name('hero.update');
    Route::delete('/hero/{id}', [AdminHeroController::class, 'destroy'])->name('hero.destroy');
    
    // Kelola Customer
    Route::get('/customer', [AdminCustomerController::class, 'index'])->name('customer.index');
    
    // Kelola Pesanan & Pembayaran
    Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [AdminPesananController::class, 'show'])->name('pesanan.show');
    Route::put('/pesanan/{id}', [AdminPesananController::class, 'update'])->name('pesanan.update');
    Route::delete('/pesanan/{id}', [AdminPesananController::class, 'destroy'])->name('pesanan.destroy');
    Route::post('/pesanan/{id}/verify', [AdminPesananController::class, 'verifyPayment'])->name('pesanan.verify');
    Route::post('/pesanan/{id}/status', [AdminPesananController::class, 'updateStatus'])->name('pesanan.status');
    Route::get('/pesanan/{id}/export-pdf', [AdminPesananController::class, 'exportPdf'])->name('pesanan.export-pdf');
});
