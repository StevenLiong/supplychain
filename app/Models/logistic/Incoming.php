<?php

namespace App\Models\logistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incoming extends Model
{
    use HasFactory;
    protected $fillable = [
        'kd_material',
        'kd_supplier',
        'no_po',
        'no_surat_jalan',
        'qty_kedatangan',
        'batch_datang',
    ];
    /**
     * Get the material that owns the Incoming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'kd_material', 'id');
    }

   /**
    * Get the supplier that owns the Incoming
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function supplier(): BelongsTo
   {
       return $this->belongsTo(Supplier::class, 'kd_supplier', 'id');
   }
}
