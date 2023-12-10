<?php

namespace App\Models\logistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class detail_cutting extends Model
{
    use HasFactory;
    protected $guarded = [];



    /**
     * Get the user that owns the detail_cutting
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cutting(): BelongsTo
    {
        return $this->belongsTo(Cutting::class);
    }
}
