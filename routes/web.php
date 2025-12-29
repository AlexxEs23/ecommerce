<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;


Route::get('/', [HomeController::class, 'index'])->name('home');

// Detail Produk Route (accessible by all)
Route::get('/produk/{id}/{slug?}', [HomeController::class, 'detailProduk'])->name('produk.detail');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
    
    // Forgot Password Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    
    // Reset Password Routes
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    
    // Google OAuth Routes
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return view('admin.dashboard');
        } elseif ($user->role === 'penjual') {
            return view('penjual.dashboard');
        } else {
            return redirect()->route('pembeli.dashboard');
        }
    })->name('dashboard');
    
    // Profile - All Users
    Route::get('/profile', [App\Http\Controllers\ProfilController::class, 'show'])->name('profile.show');
    Route::put('/profile', [App\Http\Controllers\ProfilController::class, 'update'])->name('profile.update');
    Route::post('/profile/apply-seller', [App\Http\Controllers\ProfilController::class, 'applySeller'])->name('profile.apply-seller');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin Routes - User Management
    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/seller-approval', [App\Http\Controllers\Admin\SellerApprovalController::class, 'index'])->name('seller.approval');
        Route::post('/seller-approval/{id}/approve', [App\Http\Controllers\Admin\SellerApprovalController::class, 'approve'])->name('seller.approve');
        Route::post('/seller-approval/{id}/reject', [App\Http\Controllers\Admin\SellerApprovalController::class, 'reject'])->name('seller.reject');
    });
    
    // CRUD Produk - hanya untuk admin dan penjual yang sudah approved
    Route::middleware('approved.seller')->group(function () {
        Route::get('/produk', [App\Http\Controllers\ProdukController::class, 'index'])->name('produk.index');
        Route::get('/produk/create', [App\Http\Controllers\ProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [App\Http\Controllers\ProdukController::class, 'store'])->name('produk.store');
        Route::get('/produk/{id}', [App\Http\Controllers\ProdukController::class, 'show'])->name('produk.show');
        Route::get('/produk/{id}/edit', [App\Http\Controllers\ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{id}', [App\Http\Controllers\ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{id}', [App\Http\Controllers\ProdukController::class, 'destroy'])->name('produk.destroy');
    });
    
    // Checkout Routes - untuk pembeli
    Route::get('/checkout/{id}', [App\Http\Controllers\CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{id}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
    
    // Admin - Pesanan Management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/pesanan', [App\Http\Controllers\CheckoutController::class, 'adminIndex'])->name('pesanan.index');
        Route::post('/pesanan/{id}/proses', [App\Http\Controllers\CheckoutController::class, 'adminProses'])->name('pesanan.proses');
        Route::post('/pesanan/{id}/selesai', [App\Http\Controllers\CheckoutController::class, 'adminSelesai'])->name('pesanan.selesai');
        Route::post('/pesanan/{id}/batal', [App\Http\Controllers\CheckoutController::class, 'adminBatal'])->name('pesanan.batal');
    });
    
    // Penjual - Pesanan Management
    Route::prefix('penjual')->name('penjual.')->middleware('approved.seller')->group(function () {
        Route::get('/pesanan', [App\Http\Controllers\CheckoutController::class, 'penjualIndex'])->name('pesanan.index');
        Route::get('/pesanan/{id}/resi', [App\Http\Controllers\CheckoutController::class, 'penjualResiForm'])->name('pesanan.resi-form');
        Route::post('/pesanan/{id}/kirim', [App\Http\Controllers\CheckoutController::class, 'penjualKirim'])->name('pesanan.kirim');
    });
    
    // Pembeli Dashboard Routes
    Route::get('/pembeli/dashboard', [App\Http\Controllers\PembeliController::class, 'dashboard'])->name('pembeli.dashboard');
    Route::get('/pembeli/pesanan', [App\Http\Controllers\PembeliController::class, 'pesanan'])->name('pembeli.pesanan');
});