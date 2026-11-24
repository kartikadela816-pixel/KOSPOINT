<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\KelolaKos;
use App\Models\Kos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * CRUD pengguna. Hanya untuk admin (dibatasi di routes).
 */
class PenggunaController extends Controller
{
    use KelolaKos;

    public function index(Request $request)
    {
        $pengguna = User::query()
            ->withCount('kos')
            ->when($request->query('q'), function ($query, $kata) {
                $query->where(function ($w) use ($kata) {
                    $w->where('name', 'like', "%{$kata}%")
                      ->orWhere('email', 'like', "%{$kata}%");
                });
            })
            ->when($request->query('role'), fn ($query, $role) => $query->where('role', $role))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengguna.index', ['pengguna' => $pengguna]);
    }

    public function create()
    {
        return view('admin.pengguna.create', [
            'pengguna' => new User(['role' => 'pencari', 'status_akun' => 'aktif']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nomor_hp' => ['nullable', 'string', 'max:20'],
            'role' => ['required', Rule::in(['admin', 'pemilik', 'pencari'])],
            'status_akun' => ['required', Rule::in(['aktif', 'nonaktif'])],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], $this->pesan(), $this->atribut());

        User::create($data);

        return redirect()->route('admin.pengguna.index')
            ->with('sukses', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(string $pengguna)
    {
        return view('admin.pengguna.edit', ['pengguna' => User::findOrFail($pengguna)]);
    }

    public function update(Request $request, string $pengguna)
    {
        $pengguna = User::findOrFail($pengguna);

        // Admin tidak boleh menurunkan atau menonaktifkan akunnya sendiri.
        // (Kolom itu dinonaktifkan di form, jadi nilainya diisi di sini.)
        if ($pengguna->id === auth()->id()) {
            $request->merge(['role' => 'admin', 'status_akun' => 'aktif']);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($pengguna->id)],
            'nomor_hp' => ['nullable', 'string', 'max:20'],
            'role' => ['required', Rule::in(['admin', 'pemilik', 'pencari'])],
            'status_akun' => ['required', Rule::in(['aktif', 'nonaktif'])],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], $this->pesan(), $this->atribut());

        // Password hanya diganti jika diisi.
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $pengguna->update($data);

        return redirect()->route('admin.pengguna.index')
            ->with('sukses', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(string $pengguna)
    {
        $pengguna = User::findOrFail($pengguna);

        if ($pengguna->id === auth()->id()) {
            return back()->with('galat', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        // Relasi kos ke pemilik bersifat restrict, jadi pemilik yang masih punya kos tidak bisa dihapus.
        if (Kos::withTrashed()->where('id_pemilik', $pengguna->id)->exists()) {
            return back()->with('galat', 'Pengguna ini masih memiliki kos. Hapus atau pindahkan kosnya terlebih dahulu, atau nonaktifkan akunnya.');
        }

        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')
            ->with('sukses', 'Pengguna berhasil dihapus.');
    }
}
