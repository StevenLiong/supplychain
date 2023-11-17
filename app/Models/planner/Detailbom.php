<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\planner\Bom;

class Detailbom extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $with = [
        'bom'
    ];

    protected $fillable = [
        'id_boms',
        'nama_workcenter',
        'id_materialbom',
        'nama_materialbom',
        'uom_material',
        'qty_trafo',
        'qty_material',
        'tolerance',
        'status',
        'keterangan',
        'usage_material',
        'submitted',
    ];

    public function bom()
    {
        return $this->hasMany(Bom::class, 'id_bom');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_materialbom', 'kd_barang');
    }
}