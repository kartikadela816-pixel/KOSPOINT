<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman Beranda Utama
Route::get('/', function () {
    return view('beranda');
})->name('beranda');

// Autentikasi (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

// Logout (Must be Authenticated)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Pemilik (Gunakan Middleware untuk Keamanan)
Route::get('/pemilik/dashboard', function () {
    return view('pemilik.dashboard');
})->middleware(['auth'])->name('pemilik.dashboard');

// Dashboard Admin (Gunakan Middleware untuk Keamanan)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('admin.dashboard');
