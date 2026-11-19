<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\KamarKos;
use Illuminate\Http\Request;

class KamarKosController extends Controller
{
    public function store(Request $request, Kos $kos)
    {
        abort_unless($kos->pemilik_id === auth()->id(), 403);

        $data = $request->validate([
            'nomor_kamar' => 'required|string|max:50',
            'tipe_kamar' => 'nullable|string|max:100',
            'harga' => 'required|numeric|min:0',
            'ukuran' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $kos->kamar()->create($data);

        return back()->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function update(Request $request, KamarKos $kamar)
    {
        abort_unless(
            $kamar->kos()->where('pemilik_id', auth()->id())->exists(),
            403
        );

        $data = $request->validate([
            'nomor_kamar' => 'required|string|max:50',
            'tipe_kamar' => 'nullable|string|max:100',
            'harga' => 'required|numeric|min:0',
            'ukuran' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,terisi,perbaikan',
        ]);

        $kamar->update($data);

        return back()->with('success', 'Data kamar diperbarui.');
    }

    public function destroy(KamarKos $kamar)
    {
        abort_unless(
            $kamar->kos()->where('pemilik_id', auth()->id())->exists(),
            403
        );

        if ($kamar->bookings()->exists()) {
            return back()->withErrors([
                'kamar' => 'Kamar memiliki riwayat booking dan tidak dapat dihapus.'
            ]);
        }

        $kamar->delete();

        return back()->with('success', 'Kamar berhasil dihapus.');
    }
}
