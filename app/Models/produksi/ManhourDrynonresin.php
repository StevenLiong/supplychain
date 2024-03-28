<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ManhourDrynonresin extends Model
{
    use HasFactory;
    // public function work_center(): BelongsTo
    // {
    //     return $this->belongsTo(WorkCenter::class, 'id_work_center', 'id');
    // }
    public function kapasitas(): BelongsTo
    {
        return $this->belongsTo(Kapasitas::class, 'id_kapasitas', 'id');
    }
    // public function kategori_produk(): BelongsTo
    // {
    //     return $this->belongsTo(KategoriProduk::class, 'id_kategori_produk', 'id');
    // }
    // public function proses(): BelongsTo
    // {
    //     return $this->belongsTo(Proses::class, 'id_proses', 'id');
    // }
    // public function tipe_proses(): BelongsTo
    // {
    //     return $this->belongsTo(TipeProses::class, 'id_tipe_proses', 'id');
    // }
}
