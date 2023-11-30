<?php

namespace App\Models\purchaser;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';

    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'id_material',
        'qty_pesanan',
        'total',
    ];

    public function material(): BelongsTo 
    {
        return $this-> belongsTo(material::class, 'id_material','id_material');
    }
    public function mr(): HasMany 
    {
        return $this-> hasMany(mr::class, 'id_mr','id_mr');
    }
}
