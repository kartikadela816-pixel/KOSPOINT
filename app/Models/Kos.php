<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kos extends Model
{
    use SoftDeletes;

    protected $table = 'kos';

    protected $fillable = [
        'id_pemilik',
        'nama_kos',
        'jenis_kos',
        'alamat',
        'deskripsi',
        'aturan_kos',
        'nomor_whatsapp',
        'nomor_telepon',
        'latitude',
        'longitude',
        'status_kos',
    ];

    public function pemilik()
    {
        return $this->belongsTo(User::class, 'id_pemilik');
    }

    public function kamar()
    {
        return $this->hasMany(KamarKos::class, 'id_kos');
    }

    public function fotoKos()
    {
        return $this->hasMany(FotoKos::class, 'id_kos');
    }
}
