<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoKos extends Model
{
    protected $table = 'foto_kos';

    protected $fillable = [
        'id_kos',
        'nama_file',
        'url_foto',
        'urutan',
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class, 'id_kos');
    }
}