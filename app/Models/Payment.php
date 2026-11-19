<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'kode_pembayaran',
        'jumlah',
        'metode_pembayaran',
        'tanggal_pembayaran',
        'bukti_pembayaran',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'decimal:2',
            'tanggal_pembayaran' => 'datetime',
        ];
    }

    public function booking()
    {
         return $this->belongsTo(Booking::class, 'booking_id');
    }
}
