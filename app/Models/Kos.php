<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    //
    public function fotoKos()
{
    return $this->hasMany(FotoKos::class, 'id_kos');
}
}
