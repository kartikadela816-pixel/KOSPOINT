<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Akun contoh untuk ketiga role. Password semua akun: "password".
     */
    public function run(): void
    {
        $akun = [
            ['Admin KosPoint', 'admin@kospoint.test', '081200000001', 'admin', 'aktif'],
            ['Pemilik Kos', 'pemilik@kospoint.test', '081200000002', 'pemilik', 'aktif'],
            ['Budi Hendra', 'pemilik2@kospoint.test', '081200000003', 'pemilik', 'aktif'],
            ['Pencari Kos', 'pencari@kospoint.test', '081200000004', 'pencari', 'aktif'],
            ['Nadia Safira', 'pencari2@kospoint.test', '081200000005', 'pencari', 'aktif'],
            ['Akun Nonaktif', 'nonaktif@kospoint.test', '081200000006', 'pencari', 'nonaktif'],
        ];

        foreach ($akun as [$nama, $email, $hp, $role, $status]) {
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $nama,
                    'password' => 'password', // di-hash otomatis oleh cast pada model User
                    'nomor_hp' => $hp,
                    'role' => $role,
                    'status_akun' => $status,
                ]
            );
        }
    }
}
