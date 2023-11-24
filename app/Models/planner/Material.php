<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        "kd_material","nama_barang","unit","no_rak","jumlah",
    ];

    public function detailboms()
    {
        return $this->hasMany(Detailbom::class, 'id_materialbom', 'kd_material');
    }

    public function stock()
    {
        return $this->hasMany(Stock::class, 'item_code', 'kd_material');
    }
}