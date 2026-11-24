<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\KelolaKos;
use App\Models\Kos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * CRUD kos. Dipakai pemilik (hanya kos miliknya) dan admin (semua kos).
 */
class KosController extends Controller
{
    use KelolaKos;

    public function index(Request $request)
    {
        $kos = $this->kosQuery()
            ->with('pemilik:id,name')
            ->withCount('kamar')
            ->when($request->query('q'), function ($query, $kata) {
                $query->where(function ($w) use ($kata) {
                    $w->where('nama_kos', 'like', "%{$kata}%")
                      ->orWhere('alamat', 'like', "%{$kata}%");
                });
            })
            ->when($request->query('status'), fn ($query, $status) => $query->where('status_kos', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('kelola.kos.index', ['kos' => $kos, 'prefix' => $this->prefix()]);
    }

    public function create()
    {
        return view('kelola.kos.create', [
            'kos' => new Kos(['jenis_kos' => 'campur', 'status_kos' => 'draft']),
            'prefix' => $this->prefix(),
            'daftarPemilik' => $this->daftarPemilik(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->aturan(), $this->pesan(), $this->atribut());

        // Pemilik selalu menjadi pemilik kos yang ia buat sendiri.
        if (! auth()->user()->isAdmin()) {
            $data['id_pemilik'] = auth()->id();
        }

        $kos = Kos::create($data);

        return redirect()->route($this->prefix().'.kos.show', $kos->id)
            ->with('sukses', 'Kos berhasil ditambahkan. Sekarang tambahkan kamarnya.');
    }

    public function show(string $kos)
    {
        $kos = $this->kosQuery()
            ->with([
                'pemilik:id,name,email,nomor_hp',
                'kamar' => fn ($q) => $q->orderBy('nomor_kamar'),
            ])
            ->findOrFail($kos);

        return view('kelola.kos.show', ['kos' => $kos, 'prefix' => $this->prefix()]);
    }

    public function edit(string $kos)
    {
        return view('kelola.kos.edit', [
            'kos' => $this->kosQuery()->findOrFail($kos),
            'prefix' => $this->prefix(),
            'daftarPemilik' => $this->daftarPemilik(),
        ]);
    }

    public function update(Request $request, string $kos)
    {
        $kos = $this->kosQuery()->findOrFail($kos);
        $kos->update($request->validate($this->aturan(), $this->pesan(), $this->atribut()));

        return redirect()->route($this->prefix().'.kos.show', $kos->id)
            ->with('sukses', 'Data kos berhasil diperbarui.');
    }

    public function destroy(string $kos)
    {
        $kos = $this->kosQuery()->findOrFail($kos);

        if ($kos->kamar()->whereIn('status_kamar', ['terisi', 'dipesan'])->exists()) {
            return back()->with('galat', 'Kos tidak bisa dihapus karena masih ada kamar yang terisi atau dipesan.');
        }

        $kos->delete();

        return redirect()->route($this->prefix().'.kos.index')
            ->with('sukses', 'Kos berhasil dihapus.');
    }

    private function aturan(): array
    {
        $aturan = [
            'nama_kos' => ['required', 'string', 'max:255'],
            'jenis_kos' => ['required', Rule::in(['putra', 'putri', 'campur'])],
            'alamat' => ['required', 'string', 'max:1000'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'aturan_kos' => ['nullable', 'string', 'max:5000'],
            'nomor_whatsapp' => ['nullable', 'string', 'max:20'],
            'nomor_telepon' => ['nullable', 'string', 'max:20'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'status_kos' => ['required', Rule::in(['draft', 'aktif', 'nonaktif'])],
        ];

        // Hanya admin yang boleh menentukan pemilik kos.
        if (auth()->user()->isAdmin()) {
            $aturan['id_pemilik'] = ['required', Rule::exists('users', 'id')->where('role', 'pemilik')];
        }

        return $aturan;
    }

    private function daftarPemilik()
    {
        if (! auth()->user()->isAdmin()) {
            return collect();
        }

        return User::where('role', 'pemilik')->orderBy('name')->get(['id', 'name']);
    }
}
