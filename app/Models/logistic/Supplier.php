<?php

namespace App\Models\logistic;

use App\Models\purchaser\po;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'kd_supplier',
        'nama_supplier',
        'email',
        'alamat',
        'valuta'
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
   public function poPurchaser(): HasOne
   {
       return $this->hasOne(po::class,'id_po','id_po');
   }
}
