<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hitung_kapasitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pl',
        'oee',
        'output',
        'shift_kerja',
        'jam_kerja',
        'aktual_oee',
    ];
}
