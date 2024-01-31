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
        'kd_manhour',
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

    public function workcenterDryType()
    {
        return $this->hasOne(WorkcenterDryType::class, 'nama_workcenter', 'nama_workcenter');
    }
}
