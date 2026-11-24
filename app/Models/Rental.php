<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rental extends Model
{
    protected $fillable = [
        'id_booking',
        'id_pencari',
        'id_kamar',
        'tanggal_mulai',
        'tanggal_selesai',
        'harga_per_bulan',
        'uang_jaminan',
        'status_sewa',
        'status_perpanjangan',
        'tanggal_selesai_diminta',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_selesai_diminta' => 'date',
        'harga_per_bulan' => 'decimal:2',
        'uang_jaminan' => 'decimal:2',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }

    public function pencari(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pencari');
    }

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(KamarKos::class, 'id_kamar');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'id_sewa');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'id_sewa');
    }
}
