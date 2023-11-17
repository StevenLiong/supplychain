<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\planner\So;

class Bom extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    protected $with = [
        'sos'
    ];
    
    protected $fillable = [
        'id_bom',
        'id_so',
        'qty_bom',
        'bom_status',
        'uom_bom',
        'id_fg',
        'status_bom',
    ];

    public function sos()
    {
        return $this->belongsTo(So::class, 'id_so');
    }

    // public function sos()
    // {
    //     return $this->belongsTo(So::class, 'id_so', 'id');
    // }
}