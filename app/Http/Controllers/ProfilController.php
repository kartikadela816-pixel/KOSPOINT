<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\KelolaKos;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Profil pengguna: dipakai semua role untuk mengubah data diri dan password.
 */
class ProfilController extends Controller
{
    use KelolaKos;

    public function edit()
    {
        return view('profil.edit', ['pengguna' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $pengguna = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($pengguna->id)],
            'nomor_hp' => ['nullable', 'string', 'max:20'],
        ], $this->pesan(), $this->atribut());

        $pengguna->update($data);

        return redirect()->route('profil.edit')->with('sukses', 'Profil berhasil diperbarui.');
    }

    public function password(Request $request)
    {
        $request->validateWithBag('password', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], $this->pesan(), $this->atribut() + ['current_password' => 'Password saat ini']);

        $request->user()->update(['password' => $request->password]);

        return redirect()->route('profil.edit')->with('sukses', 'Password berhasil diganti.');
    }
}
