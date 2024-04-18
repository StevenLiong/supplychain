<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManHourCtVt extends Model
{
    use HasFactory;

    public function kapasitas(): BelongsTo
    {
        return $this->belongsTo(Kapasitas::class, 'id_kapasitas', 'id');
    }
}
