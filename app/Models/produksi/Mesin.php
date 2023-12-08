<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mesin extends Model
{
    use HasFactory;

    protected $table = 'mesin';
    protected $fillable = [
        'kode_aset',
        'nama_mesin',
        'merk_mesin',
        'id_production_line',
        'id_work_centers',
        'kva_min',
        'kva_max',
        'output',
        'status',
    ];

    public function production_line(): BelongsTo
    {
        return $this->belongsTo(ProductionLine::class, 'id_production_line', 'id');
    }

    public function work_centers(): BelongsTo
    {
        return $this->belongsTo(WorkCenter::class, 'id_work_centers', 'id');
    }
}
