<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialPlanner extends Model
{
    use HasFactory;

    protected $fillable = [
        "item_code","item_name","unit","qty"
    ];
}
