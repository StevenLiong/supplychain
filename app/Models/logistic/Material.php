<?php

namespace App\Models\logistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{
    use HasFactory;
    protected $fillable = [
        'kd_material',
        'nama_material',
        'satuan',
        'jumlah',
    ];

    /**
     * Get all of the materialRak for the Material
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materialRak(): HasMany
    {
        return $this->hasMany(MaterialRak::class);
    }
  
}
