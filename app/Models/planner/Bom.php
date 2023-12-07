<?php

namespace App\Models\planner;

use App\Models\planner\So;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    /**
     * Get the order that owns the Bom
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}