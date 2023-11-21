<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StandardizeWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dry_cast_resin',
    ];

    public function dry_cast_resin(): BelongsTo
    {
        return $this->belongsTo(DryCastResin::class, 'id_dry_cast_resin', 'id');
    }
}
