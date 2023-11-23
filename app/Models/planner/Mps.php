<?php

namespace App\Models\planner;

use App\Models\Wo2;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mps extends Model
{
    protected $fillable = [
        'id_wo',
        'project',
        'production_line',
        'kva',
        'jenis',
        'qty_trafo',
        'lead_time',
        'deadline',
    ];
    use HasFactory;

    public function wo(): BelongsTo
    {
        return $this->belongsTo(Wo2::class, 'id_wo', 'id');
    }
}
