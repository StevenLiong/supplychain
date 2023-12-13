<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mps2 extends Model
{
    use HasFactory;
    protected $table = 'mps2s';

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
