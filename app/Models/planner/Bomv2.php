<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bomv2 extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'id_bom',
        'id_so',
        'qty_bom',
        'bom_status',
        'uom_bom',
        'id_fg',
        'status_bom',
    ];
}
