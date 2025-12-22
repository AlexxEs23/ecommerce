<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;


Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return view('admin.dashboard');
        } elseif ($user->role === 'penjual') {
            return view('penjual.dashboard');
        } else {
            return redirect('/')->with('error', 'Akses ditolak');
        }
    })->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin Routes - User Management
    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
        Route::resource('users', UserController::class);
    });
    
    // CRUD Produk - hanya untuk admin dan penjual
    Route::get('/produk', [App\Http\Controllers\ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [App\Http\Controllers\ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [App\Http\Controllers\ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}', [App\Http\Controllers\ProdukController::class, 'show'])->name('produk.show');
    Route::get('/produk/{id}/edit', [App\Http\Controllers\ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [App\Http\Controllers\ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [App\Http\Controllers\ProdukController::class, 'destroy'])->name('produk.destroy');
});