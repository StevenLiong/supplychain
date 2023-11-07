<?php

namespace App\Models\logistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rak extends Model
{
    use HasFactory;
    protected $guarded = [];


   /**
    * Get the gudang that owns the Rak
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function gudang(): BelongsTo
   {
       return $this->belongsTo(Gudang::class, 'kd_gudang', 'id');
   }


   /**
    * Get all of the materialRak for the Rak
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */

    
}
