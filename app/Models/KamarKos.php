<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KamarKos extends Model
{
    protected $table = 'kamar_kos';

    protected $fillable = [
        'id_kos',
        'nomor_kamar',
        'nama_kamar',
        'harga_per_bulan',
        'uang_jaminan',
        'jenis_kamar_mandi',
        'status_kamar',
        'deskripsi',
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class, 'id_kos');
    }
}
