<?php

namespace App\Models\logistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gudang extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get all of the rak for the Gudang
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rak(): HasMany
    {
        return $this->hasMany(Rak::class);
    }
}
