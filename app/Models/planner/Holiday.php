<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = ['date'];

    protected $casts = [
        'date' => 'date', // Kolom 'date' dianggap sebagai tipe data tanggal
    ];
}