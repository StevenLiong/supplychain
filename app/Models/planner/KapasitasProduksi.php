<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KapasitasProduksi extends Model
{
    protected $fillable = [
        'tanggal',
        'cap_pl2',
        'cap_pl3',
        'cap_dry',
    ];
    use HasFactory;
}