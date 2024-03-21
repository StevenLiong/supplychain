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
//comparison = qty trafo || composite = usage_material

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
        'db_status',
        'keterangan',
        'submitted',
        'email_status',
        'last_kirim_email',
        'usage_material',
    ];

    public function bom()
    {
        return $this->belongsTo(Bomv2::class, 'id_boms', 'id');
    }
    // public function warehouse()
    // {
    //     return $this->belongsTo(Warehouse::class, 'id_warehouse', 'id');
    // }
    // public function workcenter()
    // {
    //     return $this->belongsTo(Workcenter::class, 'id_workcenter', 'id');
    // }
    public function material()
    {
        return $this->belongsTo(Material::class, 'id_materialbom', 'kd_material');
    }
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'id_materialbom', 'item_code');
    }
}
