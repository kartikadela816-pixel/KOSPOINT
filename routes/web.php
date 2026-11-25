
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\Kos;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\KamarController;

// BERANDA DAN PENCARIAN

// Query data kos untuk beranda dan pencarian
$buatQueryKos = function (Request $request) {
    return Kos::query()
        ->where('status_kos', 'aktif')
        ->with('pemilik:id,name')
        ->withCount([
            'kamar',
            'kamar as kamar_tersedia_count' => fn ($q) =>
                $q->where('status_kamar', 'tersedia')
        ])
        ->withMin('kamar as harga_mulai', 'harga_per_bulan')
        ->when($request->filled('q'), function ($query) use ($request) {
            $kata = $request->query('q');

            $query->where(function ($w) use ($kata) {
                $w->where('nama_kos', 'like', "%{$kata}%")
                    ->orWhere('alamat', 'like', "%{$kata}%");
            });
        })
        ->when(
            $request->filled('min_price') || $request->filled('max_price'),
            function ($query) use ($request) {
                $query->whereHas('kamar', function ($kamar) use ($request) {
                    if ($request->filled('min_price')) {
                        $kamar->where(
                            'harga_per_bulan',
                            '>=',
                            (int) $request->min_price
                        );
                    }

                    if ($request->filled('max_price')) {
                        $kamar->where(
                            'harga_per_bulan',
                            '<=',
                            (int) $request->max_price
                        );
                    }
                });
            }
        );
};

// Beranda
Route::get('/', function (Request $request) use ($buatQueryKos) {
    $kos = $buatQueryKos($request)
        ->latest()
        ->take(6)
        ->get();

    return view('beranda', [
        'kos' => $kos,
        'halamanCari' => false,
    ]);
})->name('beranda');

// Halaman pencarian terpisah
Route::get('/cari-kos', function (Request $request) use ($buatQueryKos) {
    $kos = $buatQueryKos($request)
        ->latest()
        ->take(30)
        ->get();

    return view('cari-kos', compact('kos'));
})->name('cari-kos');

// Tentang
Route::get('/tentang', function () {
    return redirect('/#tentang');
})->name('tentang');


// AUTENTIKASI
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});



 // AREA PENGGUNA LOGIN
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Profil
    Route::get('/profil', [ProfilController::class, 'edit'])
        ->name('profil.edit');

    Route::put('/profil', [ProfilController::class, 'update'])
        ->name('profil.update');

    Route::put('/profil/password', [ProfilController::class, 'password'])
        ->name('profil.password');

    // Dashboard Pemilik
    Route::get('/pemilik/dashboard', function () {
        abort_unless(auth()->user()->isPemilik(), 403);
        return app(DashboardController::class)->pemilik();
    })->name('pemilik.dashboard');

    // Dashboard Admin
    Route::get('/admin/dashboard', function () {
        abort_unless(auth()->user()->isAdmin(), 403);
        return app(DashboardController::class)->admin();
    })->name('admin.dashboard');

    // Kelola Pengguna - Admin
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::resource('pengguna', PenggunaController::class)
                ->except(['show']);
        });

    // Kelola Kos dan Kamar - Admin
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::resource('kos', KosController::class);

            Route::get('kos/{kos}/kamar/create', [KamarController::class, 'create'])
                ->name('kos.kamar.create');

            Route::post('kos/{kos}/kamar', [KamarController::class, 'store'])
                ->name('kos.kamar.store');

            Route::get('kamar/{kamar}/edit', [KamarController::class, 'edit'])
                ->name('kamar.edit');

            Route::put('kamar/{kamar}', [KamarController::class, 'update'])
                ->name('kamar.update');

            Route::delete('kamar/{kamar}', [KamarController::class, 'destroy'])
                ->name('kamar.destroy');
        });

    // Kelola Kos dan Kamar - Pemilik
    Route::middleware('role:pemilik')
        ->prefix('pemilik')
        ->name('pemilik.')
        ->group(function () {
            Route::resource('kos', KosController::class);

            Route::get('kos/{kos}/kamar/create', [KamarController::class, 'create'])
                ->name('kos.kamar.create');

            Route::post('kos/{kos}/kamar', [KamarController::class, 'store'])
                ->name('kos.kamar.store');

            Route::get('kamar/{kamar}/edit', [KamarController::class, 'edit'])
                ->name('kamar.edit');

            Route::put('kamar/{kamar}', [KamarController::class, 'update'])
                ->name('kamar.update');

            Route::delete('kamar/{kamar}', [KamarController::class, 'destroy'])
                ->name('kamar.destroy');
        });

    // ===== Booking =====

    // Pencari
    Route::get('/booking', [BookingController::class, 'index'])
        ->name('booking.index');

    Route::post('/kamar/{kamar}/booking', [BookingController::class, 'store'])
        ->name('booking.store');

    Route::patch('/booking/{booking}/batal', [BookingController::class, 'batal'])
        ->name('booking.batal');

    // Booking masuk - Pemilik
    Route::get('/pemilik/booking', [BookingController::class, 'masuk'])
        ->name('pemilik.booking.index');

    Route::patch('/pemilik/booking/{booking}/terima', [BookingController::class, 'terima'])
        ->name('pemilik.booking.terima');

    Route::patch('/pemilik/booking/{booking}/tolak', [BookingController::class, 'tolak'])
        ->name('pemilik.booking.tolak');

    // ===== Sewa =====
    Route::get('/sewa', [RentalController::class, 'index'])
        ->name('rental.index');

    Route::get('/sewa/{rental}', [RentalController::class, 'show'])
        ->name('rental.show');

});
