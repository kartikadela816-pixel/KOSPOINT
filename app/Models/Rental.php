<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rental extends Model
{
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'id_sewa');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'id_sewa');
    }

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(KamarKos::class, 'id_kamar');
    }
}
