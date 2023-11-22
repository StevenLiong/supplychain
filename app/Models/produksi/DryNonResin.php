<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DryNonResin extends Model
{
    use HasFactory;
    protected $fillable = [
        'kd_manhour',
        'nama_product',
        'kategori',
        'nomor_so',
        'ukuran_kapasitas',
        'total_hour',
        'coil_lv',
        'coil_hv',
        'potong_leadwire',
        'potong_isolasi',
        'moulding_casting',
        'type_susun_core',
        'hv_connection',
        'lv_connection',
        'wiring',
        'instal_housing',
        'bongkar_housing',
        'pembuatan_cu_link',
        'others',
        'accesories',
        'potong_isolasi_fiber',
        'qc_testing',
    ];

    public function man_hour(): BelongsTo
    {
        return $this->belongsTo(ManHour::class,'manhour_id','id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($drynonresin) {
            StandardizeWork::create([
                'id_dry_non_resin' => $drynonresin->id,
            ]);
        });

        self::creating(function ($drynonresin) {
            $nomorSo = $drynonresin->nomor_so;
            $kategori = $drynonresin->kategori;
            $ukuranKapasitas = $drynonresin->ukuran_kapasitas;

            $nomorSo = str_replace(['/', '-'], '', $nomorSo);

            $kdManhour = $kategori . '' .  $ukuranKapasitas . '' . $nomorSo;

            $drynonresin->kd_manhour = $kdManhour;
        });
    }


}