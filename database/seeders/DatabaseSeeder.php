<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kos;
use App\Models\KamarKos;
use App\Models\Facility;
use App\Models\FotoKos;
use App\Models\Favorite;
use App\Models\SearchHistory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(['email'=>'admin@kospoint.test'], ['name'=>'Admin KosPoint','password'=>'password','role'=>'admin','status_akun'=>'aktif']);
        $pemilik = User::firstOrCreate(['email'=>'pemilik@kospoint.test'], ['name'=>'Pemilik Kos','password'=>'password','nomor_hp'=>'08123456789','role'=>'pemilik','status_akun'=>'aktif']);
        $pencari = User::firstOrCreate(['email'=>'pencari@kospoint.test'], ['name'=>'Pencari Kos','password'=>'password','nomor_hp'=>'08123456780','role'=>'pencari','status_akun'=>'aktif']);

        $dataKos = [
            ['Kos Putri Melati','putri','Jalan Melati No. 10, Banyuwangi',-8.219232,114.369339,'Kos nyaman dekat kampus dengan lingkungan yang tenang.','08123456789'],
            ['Kos Putra Gajah Mada','putra','Jalan Gajah Mada, Banyuwangi',-8.216800,114.371200,'Kos putra dengan akses mudah ke pusat kota.','08123456781'],
            ['Kos Campur Taman Sari','campur','Jalan Taman Sari, Banyuwangi',-8.220500,114.366900,'Hunian bersih dengan fasilitas dasar yang lengkap.','08123456782'],
            ['Kos Putri Kenanga','putri','Jalan Kenanga, Banyuwangi',-8.223100,114.373100,'Kos putri dengan kamar nyaman dan area bersama.','08123456783'],
            ['Kos Putra Ijen','putra','Jalan Ijen, Banyuwangi',-8.214900,114.364800,'Pilihan kos putra dengan akses transportasi mudah.','08123456784'],
            ['Kos Mahasiswa Rogojampi','campur','Rogojampi, Banyuwangi',-8.309000,114.290000,'Kos mahasiswa dengan beberapa pilihan kamar.','08123456785'],
        ];
        foreach ($dataKos as $i=>$d) {
            if ($i===5) $d[4]=114.290000;
            $kos = Kos::updateOrCreate(['nama_kos'=>$d[0]], ['id_pemilik'=>$pemilik->id,'jenis_kos'=>$d[1],'alamat'=>$d[2],'latitude'=>$d[3],'longitude'=>$d[4],'deskripsi'=>$d[5],'aturan_kos'=>'Menjaga kebersihan dan ketenangan lingkungan kos.','nomor_whatsapp'=>$d[6],'status_kos'=>'aktif']);
            foreach ([['A1',850000,100000],['A2',950000,100000]] as $room) {
                $kamar = KamarKos::updateOrCreate(['id_kos'=>$kos->id,'nomor_kamar'=>$room[0]], ['nama_kamar'=>'Kamar '.$room[0],'harga_per_bulan'=>$room[1]+($i*50000),'uang_jaminan'=>$room[2],'jenis_kamar_mandi'=>'dalam','status_kamar'=>'tersedia','deskripsi'=>'Kamar bersih dengan ventilasi dan pencahayaan yang baik.']);
                foreach (['Kasur','Lemari','Wi-Fi','Kamar mandi dalam'] as $facility) Facility::firstOrCreate(['id_kamar'=>$kamar->id,'nama_fasilitas'=>$facility], ['keterangan'=>'Tersedia untuk penghuni kamar.']);
            }
            FotoKos::firstOrCreate(['id_kos'=>$kos->id,'urutan'=>1], ['nama_file'=>'foto-kos-'.($i+1).'.jpg','url_foto'=>'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1000&q=85']);
            FotoKos::firstOrCreate(['id_kos'=>$kos->id,'urutan'=>2], ['nama_file'=>'interior-kos-'.($i+1).'.jpg','url_foto'=>'https://images.unsplash.com/photo-1615874694520-474822394e73?auto=format&fit=crop&w=1000&q=85']);
        }
        $firstKos = Kos::where('status_kos','aktif')->orderBy('id')->first();
        if ($firstKos) Favorite::firstOrCreate(['id_user'=>$pencari->id,'id_kos'=>$firstKos->id]);

        if (\Illuminate\Support\Facades\Schema::hasTable('search_histories') && SearchHistory::count()===0) {
            foreach (['kos dekat kampus','kos putri banyuwangi','kos murah','kos dengan wifi','kos dekat pusat kota','kos putra'] as $term) {
                SearchHistory::create(['user_id'=>$pencari->id,'kata_kunci'=>$term,'jumlah_hasil'=>rand(1,6)]);
            }
        }
    }
}
