<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class material extends Model
{
    use HasFactory;
    protected $table = 'material';
    public $timestamps = false;

    protected $fillable = [
        'id_material',
        'name_material',
        'spesifikasi',
        'qty',
    ];

    public function pesanan(): HasMany 
    {
        return $this-> hasMany(pesanan::class, 'id_pesanan','id_pesanan');
    }
}
