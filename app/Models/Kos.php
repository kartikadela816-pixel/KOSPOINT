<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    use HasFactory;

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
        return $this->belongsTo(User::class, 'id_pemilik', 'id');
    }

    public function kamar()
    {
        return $this->hasMany(KamarKos::class, 'id_kos', 'id');
    }

    public function foto()
    {
        return $this->hasMany(FotoKos::class, 'id_kos', 'id');
    }

    public function fasilitas()
    {
        return $this->hasManyThrough(
            Facility::class,
            KamarKos::class,
            'id_kos',
            'id_kamar',
            'id',
            'id'
        );
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'kos_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'kos_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'kos_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'kos_id');
    }
}
