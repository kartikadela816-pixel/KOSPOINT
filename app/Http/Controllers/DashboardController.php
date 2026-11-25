<?php

namespace App\Http\Controllers;

use App\Models\KamarKos;
use App\Models\Kos;
use App\Models\User;

class DashboardController extends Controller
{
    public function pemilik()
    {
        $idPemilik = auth()->id();

        $kamarQuery = fn () => KamarKos::whereHas('kos', fn ($q) => $q->where('id_pemilik', $idPemilik));

        $perStatus = $kamarQuery()
            ->selectRaw('status_kamar, count(*) as total')
            ->groupBy('status_kamar')
            ->pluck('total', 'status_kamar');

        $totalKamar = $perStatus->sum();
        $terisi = (int) ($perStatus['terisi'] ?? 0);

        // Estimasi omzet = total harga kamar terisi; potensi = total harga kamar yang masih tersedia.
        $omzet = (float) $kamarQuery()->where('status_kamar', 'terisi')->sum('harga_per_bulan');
        $potensi = (float) $kamarQuery()->where('status_kamar', 'tersedia')->sum('harga_per_bulan');

        return view('pemilik.dashboard', [
            'omzet' => $omzet,
            'potensi' => $potensi,
            'totalKos' => Kos::where('id_pemilik', $idPemilik)->count(),
            'kosAktif' => Kos::where('id_pemilik', $idPemilik)->where('status_kos', 'aktif')->count(),
            'totalKamar' => $totalKamar,
            'perStatus' => $perStatus,
            'okupansi' => $totalKamar > 0 ? round($terisi / $totalKamar * 100) : 0,
            'kosTerbaru' => Kos::where('id_pemilik', $idPemilik)->withCount('kamar')->latest()->take(5)->get(),
            'denah' => $kamarQuery()->with('kos:id,nama_kos')->orderBy('id_kos')->orderBy('nomor_kamar')->take(24)->get(),
        ]);
    }

    public function admin()
    {
        return view('admin.dashboard', [
            'penggunaPerRole' => User::selectRaw('role, count(*) as total')->groupBy('role')->pluck('total', 'role'),
            'totalKos' => Kos::count(),
            'kosPerStatus' => Kos::selectRaw('status_kos, count(*) as total')->groupBy('status_kos')->pluck('total', 'status_kos'),
            'totalKamar' => KamarKos::whereHas('kos')->count(),
            'penggunaTerbaru' => User::latest()->take(5)->get(),
            'kosTerbaru' => Kos::with('pemilik:id,name')->withCount('kamar')->latest()->take(5)->get(),
        ]);
    }
}
