<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Wo extends Model
{
    protected $fillable = [
        'id_boms',
        'id_wo',
        'id_manhour',
        'qty_trafo',
        'id_so',
        'start_date',
        'finish_date',
    ];

    use HasFactory;
}