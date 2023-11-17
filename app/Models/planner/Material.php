<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        "kd_barang","nama_barang","unit","no_rak","jumlah",
    ];

    // public function detailboms()
    // {
    //     return $this->hasMany(Detailbom::class, 'id_materialbom', 'kd_barang');
    // }

    public function detailboms()
    {
        return $this->hasMany(Detailbom::class, 'id_materialbom', 'kd_barang');
    }
}