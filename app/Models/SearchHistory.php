<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kata_kunci',
        'lokasi',
        'harga_min',
        'harga_max',
        'tipe_kos',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
