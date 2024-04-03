<?php

namespace App\Models\produksi;

use App\Models\produksi\Kapasitas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManHourOilCustom extends Model
{
    use HasFactory;
    public function kapasitas(): BelongsTo
    {
        return $this->belongsTo(Kapasitas::class, 'id_kapasitas', 'id');
    }
}
