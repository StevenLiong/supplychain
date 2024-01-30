<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatriksSkill extends Model
{
    use HasFactory;

    protected $table = 'matriks_skill';

    protected $fillable = [
        'nama_mp',
        'production_line',
        'kategori_produk',
        'proses',
        'tipe_proses',
        'skill',
    ];

    public function man_power(): BelongsTo
    {
        return $this->belongsTo(Kapasitas::class, 'id_mp', 'id');
    }
    public function production_line(): BelongsTo
    {
        return $this->belongsTo(Kapasitas::class, 'id_production_line', 'id');
    }
    public function kategori_produk(): BelongsTo
    {
        return $this->belongsTo(KategoriProduk::class, 'id_kategori_produk', 'id');
    }
    public function proses(): BelongsTo
    {
        return $this->belongsTo(Proses::class, 'id_proses', 'id');
    }
    public function tipe_proses(): BelongsTo
    {
        return $this->belongsTo(TipeProses::class, 'id_tipe_proses', 'id');
    }
}
