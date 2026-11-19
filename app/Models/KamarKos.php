<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarKos extends Model
{
    use HasFactory;

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

    protected function casts(): array
    {
        return [
            'harga_per_bulan' => 'decimal:2',
            'uang_jaminan' => 'decimal:2',
        ];
    }

    public function kos()
    {
        return $this->belongsTo(Kos::class, 'id_kos', 'id');
    }

    public function fasilitas()
    {
        return $this->hasMany(Facility::class, 'id_kamar', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'kamar_id');
    }
}
