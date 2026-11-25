<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Kos;

/**
 * Dipakai bersama oleh controller kos dan kamar.
 * Admin melihat semua kos, pemilik hanya kos miliknya sendiri.
 */
trait KelolaKos
{
    /** Awalan nama route: "admin" atau "pemilik". */
    protected function prefix(): string
    {
        return auth()->user()->isAdmin() ? 'admin' : 'pemilik';
    }

    /** Query kos yang boleh diakses pengguna yang sedang login. */
    protected function kosQuery()
    {
        $query = Kos::query();

        if (! auth()->user()->isAdmin()) {
            $query->where('id_pemilik', auth()->id());
        }

        return $query;
    }

    protected function pesan(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'email' => 'Format :attribute tidak valid.',
            'unique' => ':attribute sudah dipakai.',
            'min' => [
                'string' => ':attribute minimal :min karakter.',
                'numeric' => ':attribute minimal :min.',
            ],
            'max' => [
                'string' => ':attribute maksimal :max karakter.',
                'numeric' => ':attribute maksimal :max.',
            ],
            'in' => ':attribute tidak valid.',
            'exists' => ':attribute tidak valid.',
            'numeric' => ':attribute harus berupa angka.',
            'between' => ':attribute harus di antara :min dan :max.',
            'confirmed' => 'Konfirmasi :attribute tidak cocok.',
            'current_password' => 'Password saat ini salah.',
        ];
    }

    protected function atribut(): array
    {
        return [
            'id_pemilik' => 'Pemilik',
            'nama_kos' => 'Nama kos',
            'jenis_kos' => 'Jenis kos',
            'alamat' => 'Alamat',
            'deskripsi' => 'Deskripsi',
            'aturan_kos' => 'Aturan kos',
            'nomor_whatsapp' => 'Nomor WhatsApp',
            'nomor_telepon' => 'Nomor telepon',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'status_kos' => 'Status kos',
            'nomor_kamar' => 'Nomor kamar',
            'nama_kamar' => 'Nama kamar',
            'harga_per_bulan' => 'Harga per bulan',
            'uang_jaminan' => 'Uang jaminan',
            'jenis_kamar_mandi' => 'Jenis kamar mandi',
            'status_kamar' => 'Status kamar',
            'name' => 'Nama',
            'email' => 'Email',
            'nomor_hp' => 'Nomor HP',
            'role' => 'Role',
            'status_akun' => 'Status akun',
            'password' => 'Password',
        ];
    }
}
