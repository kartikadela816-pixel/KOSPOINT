<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function pemilik(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pemilik');
    }

    public function kamar(): HasMany
    {
        return $this->hasMany(KamarKos::class, 'id_kos');
    }

    public function kamarKos(): HasMany
    {
        return $this->hasMany(KamarKos::class, 'id_kos');
    }

    public function fotoKos(): HasMany
    {
        return $this->hasMany(FotoKos::class, 'id_kos');
    }
}
