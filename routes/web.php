<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KamarKosController;
use App\Http\Controllers\PencariKosController;
use App\Http\Controllers\PemilikKosController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProfileController;

// HALAMAN UMUM
Route::get('/', fn() => view('beranda'))->name('beranda');

Route::get('/cari-kos', [KosController::class, 'index'])
    ->name('kos.index');

Route::get('/cari', [KosController::class, 'index'])
    ->name('kos.cari');

Route::get('/kos/{slug}', [KosController::class, 'show'])
    ->name('kos.show');

Route::get('/peta', [MapController::class, 'index'])
    ->name('peta.index');

Route::get('/api/lokasi-kos', [MapController::class, 'locations'])
    ->name('peta.locations');

// AUTENTIKASI
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// FITUR PENGGUNA LOGIN
Route::middleware('auth')->group(function () {

    Route::get('/profil', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::put('/profil', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/profil/password', [ProfileController::class, 'changePassword'])
        ->name('profile.password');

    Route::post('/kos/{kos}/favorit', [FavoriteController::class, 'toggle'])
        ->name('favorite.toggle');

    Route::post('/kos/{kos}/review', [ReviewController::class, 'store'])
        ->name('review.store');

    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])
        ->name('review.destroy');

    Route::post('/kos/{kos}/booking', [BookingController::class, 'store'])
        ->name('booking.store');

    Route::post('/booking/{booking}/batal', [BookingController::class, 'cancel'])
        ->name('booking.cancel');

    // PENCARI
    Route::prefix('pencari')->name('pencari.')->group(function () {
        Route::get('/dashboard', [PencariKosController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/booking', [PencariKosController::class, 'bookingSaya'])
            ->name('booking');

        Route::get('/favorit', [FavoriteController::class, 'index'])
            ->name('favorit');

        Route::get('/pembayaran/{booking}', [PaymentController::class, 'create'])
            ->name('pembayaran');

        Route::post('/pembayaran/{payment}', [PaymentController::class, 'store'])
            ->name('pembayaran.store');
    });

    // PEMILIK
    Route::prefix('pemilik')->name('pemilik.')->group(function () {
        Route::get('/dashboard', [PemilikKosController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/kos', [PemilikKosController::class, 'kosSaya'])
            ->name('kos');

        Route::get('/kos/tambah', [PemilikKosController::class, 'createKos'])
            ->name('kos.create');

        Route::get('/kos/{kos}/edit', [PemilikKosController::class, 'editKos'])
            ->name('kos.edit');

        Route::post('/kos', [KosController::class, 'store'])
            ->name('kos.store');

        Route::put('/kos/{kos}', [KosController::class, 'update'])
            ->name('kos.update');

        Route::delete('/kos/{kos}', [KosController::class, 'destroy'])
            ->name('kos.destroy');

        Route::post('/kos/{kos}/kamar', [KamarKosController::class, 'store'])
            ->name('kamar.store');

        Route::put('/kamar/{kamar}', [KamarKosController::class, 'update'])
            ->name('kamar.update');

        Route::delete('/kamar/{kamar}', [KamarKosController::class, 'destroy'])
            ->name('kamar.destroy');

        Route::get('/booking', [PemilikKosController::class, 'bookingMasuk'])
            ->name('booking');

        Route::put('/booking/{booking}/status', [BookingController::class, 'updateStatus'])
            ->name('booking.status');
    });

    // ADMIN
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/kos', [AdminController::class, 'kos'])
            ->name('kos');

        Route::put('/kos/{kos}/verifikasi', [AdminController::class, 'verifikasiKos'])
            ->name('kos.verifikasi');

        Route::get('/pengguna', [AdminController::class, 'pengguna'])
            ->name('pengguna');

        Route::get('/laporan', [AdminController::class, 'laporan'])
            ->name('laporan');

        Route::put('/laporan/{report}', [AdminController::class, 'updateLaporan'])
            ->name('laporan.update');

        Route::get('/pembayaran', [AdminController::class, 'pembayaran'])
            ->name('pembayaran');

        Route::put('/pembayaran/{payment}/verifikasi', [PaymentController::class, 'verify'])
            ->name('pembayaran.verify');
    });
});
