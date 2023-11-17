<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mps extends Model
{
    protected $fillable = [
        'id_wo',
        'project',
        'production_line',
        'kva',
        'jenis',
        'qty_trafo',
        'lead_time',
        'deadline',
    ];
    use HasFactory;
}