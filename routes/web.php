<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\PaymentController;

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



// ===== Booking & Sewa =====
Route::middleware('auth')->group(function () {
    // Pencari
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/kamar/{kamar}/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::patch('/booking/{booking}/batal', [BookingController::class, 'batal'])->name('booking.batal');

    // Pemilik
    Route::get('/pemilik/booking', [BookingController::class, 'masuk'])->name('pemilik.booking.index');
    Route::patch('/pemilik/booking/{booking}/terima', [BookingController::class, 'terima'])->name('pemilik.booking.terima');
    Route::patch('/pemilik/booking/{booking}/tolak', [BookingController::class, 'tolak'])->name('pemilik.booking.tolak');

    // Sewa
    Route::get('/sewa', [RentalController::class, 'index'])->name('rental.index');
    Route::get('/sewa/{rental}', [RentalController::class, 'show'])->name('rental.show');


    // Pembayaran - Pipa
Route::get('/pembayaran', [PaymentController::class, 'index'])
    ->name('payments.index');

Route::get('/pembayaran/tambah', [PaymentController::class, 'create'])
    ->name('payments.create');

Route::post('/pembayaran', [PaymentController::class, 'store'])
    ->name('payments.store');

});

// Verifikasi Pembayaran - Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/pembayaran', [PaymentController::class, 'adminIndex'])
        ->name('admin.payments.index');

    Route::patch('/admin/pembayaran/{id}/setujui', [PaymentController::class, 'approve'])
        ->name('admin.payments.approve');

    Route::patch('/admin/pembayaran/{id}/tolak', [PaymentController::class, 'reject'])
        ->name('admin.payments.reject');
});