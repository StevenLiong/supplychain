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
        'kd_material_rak',
        'kd_supplier',
        'no_po',
        'no_surat_jalan',
        'qty_kedatangan',
        'tgl_kedatangan',
        'batch_datang',
    ];


    /**
     * Get the materialRak that owns the Incoming
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function materialRak(): BelongsTo
    {
        return $this->belongsTo(MaterialRak::class, 'kd_material_rak', 'id');
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
