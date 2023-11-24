<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'item_code',
        'item_name',
        'tiga_item_name',
        'supplier',
        'rop',
        'max',
        'rop_safety',
        'max_safety',
        'safety_stock',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class, 'item_code', 'kd_material');
    }

}
