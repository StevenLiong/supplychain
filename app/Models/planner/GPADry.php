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
        'deadline',
        // 'nama_workcenter',
        'keterangan',
        'id_mps',
        'deadline_wc1',
        'deadline_wc2',
        'deadline_wc3',
        'deadline_wc4',
        'deadline_wc5',
        'deadline_wc6',
        'deadline_wc7',
        'deadline_wc8',
        'deadline_wc9',
        'deadline_wc10',
        'deadline_wc11',
        'deadline_wc12',
        'deadline_wc13',
        'deadline_wc14',
        'deadline_wc15',
    ];
    use HasFactory;

    // public function wo(): BelongsTo
    // {
    //     return $this->belongsTo(Wo::class, 'id_wo', 'id');
    // }

    public function mps2(): BelongsTo
    {
        return $this->belongsTo(Mps2::class, 'id_mps', 'id');
    }
}