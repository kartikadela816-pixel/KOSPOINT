<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'id_sewa',
        'id_pencari',
        'jumlah_bayar',
        'metode_pembayaran',
        'bukti_pembayaran',
        'tanggal_bayar',
        'status_pembayaran',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_bayar' => 'decimal:2',
            'tanggal_bayar' => 'datetime',
        ];
    }

    // Relasi ke tabel rentals
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class, 'id_sewa');
    }

    // Relasi ke tabel users
    public function pencari(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pencari');
    }
}
