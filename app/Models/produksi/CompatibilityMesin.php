<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompatibilityMesin extends Model
{
    use HasFactory;
    protected $table = 'compatibility_mesins';

    protected $fillable = [
        'nama_ms',
        'production_line',
        'kategori_produk',
        'proses',
        'tipe_proses',
        'skill',
    ];

    // public function man_power(): BelongsTo
    // {
    //     return $this->belongsTo(ManPower::class, 'id_mp', 'id');
    // }
}
