<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GPADry extends Model
{
    protected $table = 'gpadrys';
    protected $fillable = [
        'id_wo',
        'project',
        'production_line',
        'kva',
        'jenis',
        'qty_trafo',
        'lead_time',
        'deadline',
        'nama_workcenter',
    ];
    use HasFactory;

    public function wo(): BelongsTo
    {
        return $this->belongsTo(Wo::class, 'id_wo', 'id');
    }
}