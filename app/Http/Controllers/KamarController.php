<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\KelolaKos;
use App\Models\KamarKos;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * CRUD kamar di dalam sebuah kos. Daftar kamar tampil di halaman detail kos.
 */
class KamarController extends Controller
{
    use KelolaKos;

    public function create(string $kos)
    {
        return view('kelola.kamar.create', [
            'kos' => $this->kosQuery()->findOrFail($kos),
            'kamar' => new KamarKos([
                'jenis_kamar_mandi' => 'dalam',
                'status_kamar' => 'tersedia',
                'uang_jaminan' => 0,
            ]),
            'prefix' => $this->prefix(),
        ]);
    }

    public function store(Request $request, string $kos)
    {
        $kos = $this->kosQuery()->findOrFail($kos);
        $data = $request->validate($this->aturan($kos->id), $this->pesan(), $this->atribut());
        $data['uang_jaminan'] = $data['uang_jaminan'] ?? 0;

        $kos->kamar()->create($data);

        return redirect()->route($this->prefix().'.kos.show', $kos->id)
            ->with('sukses', 'Kamar berhasil ditambahkan.');
    }

    public function edit(string $kamar)
    {
        $kamar = $this->kamarQuery()->with('kos')->findOrFail($kamar);

        return view('kelola.kamar.edit', [
            'kos' => $kamar->kos,
            'kamar' => $kamar,
            'prefix' => $this->prefix(),
        ]);
    }

    public function update(Request $request, string $kamar)
    {
        $kamar = $this->kamarQuery()->findOrFail($kamar);
        $data = $request->validate($this->aturan($kamar->id_kos, $kamar->id), $this->pesan(), $this->atribut());
        $data['uang_jaminan'] = $data['uang_jaminan'] ?? 0;

        $kamar->update($data);

        return redirect()->route($this->prefix().'.kos.show', $kamar->id_kos)
            ->with('sukses', 'Data kamar berhasil diperbarui.');
    }

    public function destroy(string $kamar)
    {
        $kamar = $this->kamarQuery()->findOrFail($kamar);

        if (in_array($kamar->status_kamar, ['terisi', 'dipesan'], true)) {
            return back()->with('galat', 'Kamar yang sedang terisi atau dipesan tidak bisa dihapus.');
        }

        $kamar->delete();

        return redirect()->route($this->prefix().'.kos.show', $kamar->id_kos)
            ->with('sukses', 'Kamar berhasil dihapus.');
    }

    /** Kamar yang boleh diakses = kamar milik kos yang boleh diakses. */
    private function kamarQuery()
    {
        return KamarKos::whereHas('kos', function ($query) {
            if (! auth()->user()->isAdmin()) {
                $query->where('id_pemilik', auth()->id());
            }
        });
    }

    private function aturan(int $idKos, ?int $abaikanId = null): array
    {
        return [
            'nomor_kamar' => [
                'required', 'string', 'max:30',
                Rule::unique('kamar_kos', 'nomor_kamar')->where('id_kos', $idKos)->ignore($abaikanId),
            ],
            'nama_kamar' => ['nullable', 'string', 'max:255'],
            'harga_per_bulan' => ['required', 'numeric', 'min:0', 'max:9999999999'],
            'uang_jaminan' => ['nullable', 'numeric', 'min:0', 'max:9999999999'],
            'jenis_kamar_mandi' => ['required', Rule::in(['dalam', 'luar'])],
            'status_kamar' => ['required', Rule::in(['tersedia', 'dipesan', 'terisi', 'nonaktif'])],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
