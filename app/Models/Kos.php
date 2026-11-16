<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    protected $table = 'kos';
    public function fotoKos()
    {
        return $this->hasMany(FotoKos::class, 'id_kos');
    }

    public function kamarKos()
    {
        return $this->hasMany(KamarKos::class, 'id_kos');
    }
}
