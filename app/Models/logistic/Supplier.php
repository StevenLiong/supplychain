<?php

namespace App\Models\logistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'kd_supplier',
        'nama_supplier',
        'email',
        'alamat'
    ];

   /**
    * Get all of the incoming for the Supplier
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function incoming(): HasMany
   {
       return $this->hasMany(Incoming::class, 'kd_kedatangan', 'id');
   }
}
