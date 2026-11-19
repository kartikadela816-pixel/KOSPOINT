<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BookingSewaSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ===== Akun =====
        $akun = [
            ['name' => 'Pemilik Contoh',  'email' => 'pemilik.contoh@kospoint.test',  'role' => 'pemilik'],
            ['name' => 'Pencari Contoh',  'email' => 'pencari.contoh@kospoint.test',  'role' => 'pencari'],
            ['name' => 'Pencari Contoh 2', 'email' => 'pencari2.contoh@kospoint.test', 'role' => 'pencari'],
        ];

        foreach ($akun as $a) {
            DB::table('users')->updateOrInsert(
                ['email' => $a['email']],
                [
                    'name' => $a['name'],
                    'password' => Hash::make('password123'),
                    'nomor_hp' => '081234567890',
                    'role' => $a['role'],
                    'status_akun' => 'aktif',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $idPemilik  = DB::table('users')->where('email', 'pemilik.contoh@kospoint.test')->value('id');
        $idPencari  = DB::table('users')->where('email', 'pencari.contoh@kospoint.test')->value('id');
        $idPencari2 = DB::table('users')->where('email', 'pencari2.contoh@kospoint.test')->value('id');

        // ===== Kos =====
        DB::table('kos')->updateOrInsert(
            ['id_pemilik' => $idPemilik, 'nama_kos' => 'Kos Contoh Booking'],
            [
                'jenis_kos' => 'campur',
                'alamat' => 'Jl. Contoh No. 1, Jember',
                'deskripsi' => 'Data contoh untuk tes modul booking dan sewa.',
                'status_kos' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
        $idKos = DB::table('kos')
            ->where('id_pemilik', $idPemilik)
            ->where('nama_kos', 'Kos Contoh Booking')
            ->value('id');

        // ===== Kamar =====
        $kamar = [
            ['K-101', 'tersedia'],  // untuk booking menunggu (nanti jadi dipesan)
            ['K-102', 'tersedia'],  // untuk tes ajukan booking
            ['K-103', 'tersedia'],  // untuk tes ajukan booking
            ['K-104', 'terisi'],    // sudah disewa
        ];

        foreach ($kamar as [$nomor, $status]) {
            DB::table('kamar_kos')->updateOrInsert(
                ['id_kos' => $idKos, 'nomor_kamar' => $nomor],
                [
                    'nama_kamar' => 'Kamar ' . $nomor,
                    'harga_per_bulan' => 800000,
                    'uang_jaminan' => 200000,
                    'jenis_kamar_mandi' => 'dalam',
                    'status_kamar' => $status,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $k101 = DB::table('kamar_kos')->where('id_kos', $idKos)->where('nomor_kamar', 'K-101')->value('id');
        $k104 = DB::table('kamar_kos')->where('id_kos', $idKos)->where('nomor_kamar', 'K-104')->value('id');

        // ===== Booking menunggu (K-101) =====
        if (! DB::table('bookings')->where('id_kamar', $k101)->exists()) {
            DB::table('bookings')->insert([
                'id_pencari' => $idPencari,
                'id_kamar' => $k101,
                'tanggal_booking' => $now,
                'tanggal_masuk_rencana' => $now->copy()->addDays(7)->toDateString(),
                'lama_sewa_bulan' => 6,
                'status_booking' => 'menunggu',
                'catatan_pencari' => 'Mohon konfirmasi secepatnya.',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('kamar_kos')->where('id', $k101)->update(['status_kamar' => 'dipesan']);
        }

        // ===== Booking diterima + sewa aktif (K-104) =====
        if (! DB::table('bookings')->where('id_kamar', $k104)->exists()) {
            $mulai = $now->copy()->subMonth();

            $idBooking = DB::table('bookings')->insertGetId([
                'id_pencari' => $idPencari2,
                'id_kamar' => $k104,
                'tanggal_booking' => $mulai->copy()->subDays(3),
                'tanggal_masuk_rencana' => $mulai->toDateString(),
                'lama_sewa_bulan' => 12,
                'status_booking' => 'diterima',
                'catatan_pemilik' => 'Silakan masuk sesuai tanggal.',
                'tanggal_ditanggapi' => $mulai->copy()->subDays(2),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('rentals')->insert([
                'id_booking' => $idBooking,
                'id_pencari' => $idPencari2,
                'id_kamar' => $k104,
                'tanggal_mulai' => $mulai->toDateString(),
                'tanggal_selesai' => $mulai->copy()->addMonths(12)->toDateString(),
                'harga_per_bulan' => 800000,
                'uang_jaminan' => 200000,
                'status_sewa' => 'aktif',
                'status_perpanjangan' => 'tidak_ada',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}