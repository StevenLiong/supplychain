<?php

namespace App\Models\purchaser;

use App\Models\logistic\Material;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';

    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'kd_material',
        'qty_pesanan',
        'total',
    ];


    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'kd_material', 'kd_material');
    }

    public function mr(): HasMany 
    {
        return $this-> hasMany(mr::class, 'id_mr','id_mr');
    }
}
