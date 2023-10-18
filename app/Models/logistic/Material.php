<?php

namespace App\Models\logistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    * Get all of the incoming for the Material
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function incoming(): HasMany
   {
       return $this->hasMany(Incoming::class, 'kd_kedatangan', 'id');
   }

}
