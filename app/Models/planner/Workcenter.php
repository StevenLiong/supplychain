<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workcenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_workcenter',
    ];
}
