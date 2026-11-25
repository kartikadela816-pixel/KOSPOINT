<?php

namespace Database\Seeders;

use App\Models\Kos;
use App\Models\User;
use Illuminate\Database\Seeder;

class KosSeeder extends Seeder
{
    public function run(): void
    {
        $pemilik1 = User::where('email', 'pemilik@kospoint.test')->firstOrFail();
        $pemilik2 = User::where('email', 'pemilik2@kospoint.test')->firstOrFail();

        // [pemilik, nama, jenis, alamat, deskripsi, aturan, wa, lat, lng, status, kamar]
        // kamar: [nomor, nama, harga, jaminan, kamar mandi, status]
        $daftar = [
            [
                $pemilik1, 'Kos Putri Melati', 'putri',
                'Jalan Melati No. 10, Banyuwangi',
                'Kos nyaman dekat kampus.',
                "Jam malam pukul 22.00.\nTamu tidak boleh menginap.\nDilarang merokok di dalam kamar.",
                '08123456789', -8.219232, 114.369339, 'aktif',
                [
                    ['101', 'Deluxe', 1650000, 500000, 'dalam', 'terisi'],
                    ['102', 'Deluxe', 1650000, 500000, 'dalam', 'tersedia'],
                    ['103', 'Standard', 1400000, 400000, 'dalam', 'terisi'],
                    ['104', 'Standard', 1400000, 400000, 'luar', 'dipesan'],
                    ['201', 'Superior', 2100000, 500000, 'dalam', 'terisi'],
                    ['202', 'Deluxe', 1700000, 500000, 'dalam', 'tersedia'],
                ],
            ],
            [
                $pemilik1, 'Kos Putra Sejahtera', 'putra',
                'Jalan Gajah Mada No. 25, Banyuwangi',
                'Kos putra dengan parkir luas dan WiFi.',
                "Jam malam pukul 23.00.\nParkir motor tersedia.",
                '08123456780', -8.2205, 114.3711, 'aktif',
                [
                    ['A1', null, 1200000, 300000, 'luar', 'terisi'],
                    ['A2', null, 1200000, 300000, 'luar', 'terisi'],
                    ['A3', null, 1300000, 300000, 'dalam', 'tersedia'],
                    ['A4', null, 1300000, 300000, 'dalam', 'nonaktif'],
                ],
            ],
            [
                $pemilik1, 'Kos Campur Asri', 'campur',
                'Jalan Ahmad Yani No. 3, Banyuwangi',
                'Kos baru, masih dalam persiapan.',
                null, '08123456781', null, null, 'draft',
                [],
            ],
            [
                $pemilik2, 'Kos Putra Gandrung', 'putra',
                'Jalan Susuit No. 7, Banyuwangi',
                'Dekat pusat kota dan stasiun.',
                "Tamu wajib lapor penjaga kos.\nDilarang membawa hewan peliharaan.",
                '08129876543', -8.2102, 114.3650, 'aktif',
                [
                    ['01', 'Reguler', 1100000, 250000, 'luar', 'terisi'],
                    ['02', 'Reguler', 1100000, 250000, 'luar', 'tersedia'],
                    ['03', 'Plus', 1500000, 300000, 'dalam', 'tersedia'],
                ],
            ],
            [
                $pemilik2, 'Kos Campur Blambangan', 'campur',
                'Jalan Blambangan No. 12, Banyuwangi',
                'Sedang tidak menerima penghuni baru.',
                null, '08129876544', null, null, 'nonaktif',
                [
                    ['B1', null, 1000000, 200000, 'luar', 'nonaktif'],
                ],
            ],
        ];

        foreach ($daftar as [$pemilik, $nama, $jenis, $alamat, $deskripsi, $aturan, $wa, $lat, $lng, $status, $kamar]) {
            $kos = Kos::updateOrCreate(
                ['id_pemilik' => $pemilik->id, 'nama_kos' => $nama],
                [
                    'jenis_kos' => $jenis,
                    'alamat' => $alamat,
                    'deskripsi' => $deskripsi,
                    'aturan_kos' => $aturan,
                    'nomor_whatsapp' => $wa,
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'status_kos' => $status,
                ]
            );

            foreach ($kamar as [$nomor, $namaKamar, $harga, $jaminan, $mandi, $statusKamar]) {
                $kos->kamar()->updateOrCreate(
                    ['nomor_kamar' => $nomor],
                    [
                        'nama_kamar' => $namaKamar,
                        'harga_per_bulan' => $harga,
                        'uang_jaminan' => $jaminan,
                        'jenis_kamar_mandi' => $mandi,
                        'status_kamar' => $statusKamar,
                    ]
                );
            }
        }
    }
}
