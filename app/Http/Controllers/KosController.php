<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Facility;
use Illuminate\Http\Request;

class KosController extends Controller
{
    public function index(Request $request)
    {
        $query = Kos::query();

        // Pencarian nama dan alamat
        $search = trim($request->input('q', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kos', 'LIKE', "%{$search}%")
                    ->orWhere('alamat', 'LIKE', "%{$search}%");
            });
        }

        // Filter jenis kos
        $jenis = $request->input('jenis');

        if (in_array($jenis, ['putra', 'putri', 'campur'], true)) {
            $query->where('jenis_kos', $jenis);
        }

        // Filter harga kamar
        $hargaMin = $request->input('harga_min');
        $hargaMax = $request->input('harga_max');

        if (
            ($hargaMin !== null && $hargaMin !== '') ||
            ($hargaMax !== null && $hargaMax !== '')
        ) {
            $query->whereHas('kamar', function ($q) use ($hargaMin, $hargaMax) {
                if ($hargaMin !== null && $hargaMin !== '') {
                    $q->where('harga_per_bulan', '>=', $hargaMin);
                }

                if ($hargaMax !== null && $hargaMax !== '') {
                    $q->where('harga_per_bulan', '<=', $hargaMax);
                }
            });
        }

        // Filter fasilitas berdasarkan kamar
        $fasilitas = $request->input('fasilitas');

        if ($fasilitas !== null && $fasilitas !== '') {
            $query->whereHas('kamar.fasilitas', function ($q) use ($fasilitas) {
                $q->where('nama_fasilitas', $fasilitas);
            });
        }

        // Ambil harga kamar terendah
        $query->withMin('kamar', 'harga_per_bulan');

        // Pengurutan
        $sort = $request->input('sort');

        if ($sort === 'harga_termurah') {
            $query->orderBy('kamar_min_harga_per_bulan', 'asc');
        } elseif ($sort === 'harga_termahal') {
            $query->withMax('kamar', 'harga_per_bulan')
                ->orderByDesc('kamar_max_harga_per_bulan');
        } else {
            $query->latest();
        }

        // Ambil relasi untuk kartu kos
        $query->with(['foto', 'kamar.fasilitas']);

        // Kos yang ditampilkan hanya berstatus aktif
        $query->where('status_kos', 'aktif');

        // Pagination
        $kos = $query->paginate(9)->withQueryString();

        // Daftar fasilitas untuk filter
        $daftarFasilitas = Facility::query()
            ->select('nama_fasilitas')
            ->distinct()
            ->orderBy('nama_fasilitas')
            ->get();

        return view('kos.index', compact('kos', 'daftarFasilitas'));
    }

    public function show($id)
    {
        $kos = Kos::with(['foto', 'kamar.fasilitas'])
            ->findOrFail($id);

        return view('kos.show', compact('kos'));
    }
}
