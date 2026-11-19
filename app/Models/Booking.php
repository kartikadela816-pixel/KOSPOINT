<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kos_id',
        'kamar_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_harga',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'total_harga' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }

    public function kamar()
    {
        return $this->belongsTo(KamarKos::class, 'kamar_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function rental()
    {
    return $this->hasOne(Rental::class, 'booking_id');
    }
}
