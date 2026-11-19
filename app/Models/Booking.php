<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $fillable = [
        'id_pencari', 'id_kamar', 'tanggal_booking', 'tanggal_masuk_rencana',
        'lama_sewa_bulan', 'status_booking', 'catatan_pencari',
        'catatan_pemilik', 'tanggal_ditanggapi',
    ];

    protected $casts = [
        'tanggal_booking' => 'datetime',
        'tanggal_masuk_rencana' => 'date',
        'tanggal_ditanggapi' => 'datetime',
    ];

    public function pencari(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pencari');
    }

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(KamarKos::class, 'id_kamar');
    }

    public function rental(): HasOne
    {
        return $this->hasOne(Rental::class, 'id_booking');
    }
}