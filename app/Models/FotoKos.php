<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoKos extends Model
{
    use HasFactory;

    protected $table = 'foto_kos';

    protected $fillable = [
        'kos_id',
        'nama_file',
        'keterangan',
        'is_utama',
    ];

    protected function casts(): array
    {
        return [
            'is_utama' => 'boolean',
        ];
    }

    public function kos()
    {
        return $this->belongsTo(Kos::class, 'kos_id');
    }
}
