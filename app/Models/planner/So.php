<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bom;

class So extends Model
{
    use HasFactory;

    protected $table = 'sos';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'id',
        'kode_so',
    ];
}