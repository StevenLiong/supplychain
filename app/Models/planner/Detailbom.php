<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\planner\Bom;

class Detailbom extends Model
{
    use HasFactory;
    
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
        'db_status',
        'keterangan',
        'usage_material',
        'submitted',
        'email_status',
        'last_kirim_email',
    ];
    public function bom()
    {
        return $this->belongsTo(Bom::class, 'id_bom');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_materialbom', 'kd_material');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'id_materialbom', 'item_code');
    }
}