<?php

namespace App\Models\logistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialRak extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the material that owns the MaterialRak
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }

    /**
     * Get the rak that owns the MaterialRak
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rak(): BelongsTo
    {
        return $this->belongsTo(Rak::class, 'rak_id', 'id');
    }

    /**
     * Get all of the comments for the MaterialRak
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incomings(): HasMany
    {
        return $this->hasMany(Incoming::class, 'kd_material_rak', 'id');
    }
}
