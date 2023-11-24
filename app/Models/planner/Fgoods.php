<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fgoods extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_finishedgood',
        'nama_barang',
        'wo',
        'nsk',
        'nsp',
        'kva',
        'qty',
    ];

    public function kanbanfg()
    {
        return $this->belongsTo(Kanbanfg::class, 'kd_finishedgood', 'kode_fg');
    }
}
