<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kos;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin KosPoint',
            'email' => 'admin@kospoint.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $pemilik = User::create([
            'name' => 'Pemilik Kos',
            'email' => 'pemilik@kospoint.test',
            'password' => Hash::make('password'),
            'role' => 'pemilik',
        ]);

        User::create([
            'name' => 'Pencari Kos',
            'email' => 'pencari@kospoint.test',
            'password' => Hash::make('password'),
            'role' => 'pencari',
        ]);

        Kos::create([
            'id_pemilik' => $pemilik->id,
            'nama_kos' => 'Kos Putri Melati',
            'jenis_kos' => 'putri',
            'alamat' => 'Jalan Melati No. 10, Banyuwangi',
            'deskripsi' => 'Kos nyaman dekat kampus.',
            'nomor_whatsapp' => '08123456789',
            'latitude' => -8.219232,
            'longitude' => 114.369339,
            'status_kos' => 'aktif',
        ]);
    }
}
