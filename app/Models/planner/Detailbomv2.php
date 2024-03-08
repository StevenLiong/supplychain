<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailbomv2 extends Model
{
    use HasFactory;

    protected $with = [
        'bom'
    ];

    protected $fillable = [
        'id_boms',
        'id_warehouse',
        'nama_workcenter',
        'id_materialbom',
        'nama_materialbom',
        '2nd_nama_materialbom',
        'uom_material',
        'comparison',
        'composite',
        'tolerance',
    ];

    public function bom()
    {
        return $this->belongsTo(Bomv2::class, 'id_boms', 'id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'id_warehouse', 'id');
    }
    public function workcenter()
    {
        return $this->belongsTo(Workcenter::class, 'id_workcenter', 'id');
    }
}
