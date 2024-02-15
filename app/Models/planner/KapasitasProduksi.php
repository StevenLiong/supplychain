<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KapasitasProduksi extends Model
{
    protected $fillable = [
        'tanggal',
        'PL2',
        'PL3',
        'Drytype',
        'oee_drytype',
        'oee_pl2',
        'oee_pl3',
        'output_drytype',
        'output_pl2',
        'output_pl3',
        'shift_kerja_drytype',
        'shift_kerja_pl2',
        'shift_kerja_pl3',
        'jam_kerja_drytype',
        'jam_kerja_pl2',
        'jam_kerja_pl3',
        'aktual_oee_drytype',
        'aktual_oee_pl2',
        'aktual_oee_pl3',
    ];
    use HasFactory;
}