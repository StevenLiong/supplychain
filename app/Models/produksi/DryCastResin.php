<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DryCastResin extends Model
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
        'hv_moulding',
        'hv_casting',
        'hv_demoulding',
        'lv_bobbin',
        'lv_moulding',
        'touch_up',
        'type_susun_core',
        'wiring',
        'instal_housing',
        'bongkar_housing',
        'pembuatan_cu_link',
        'others',
        'accesories',
        'potong_isolasi_fiber',
        'routine_test',
    ];

    public function man_hour(): BelongsTo
    {
        return $this->belongsTo(ManHour::class,'manhour_id','id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($dryresin) {
            StandardizeWork::create([
                'id_dry_cast_resin' => $dryresin->id,
            ]);
        });

        self::creating(function ($dryresin) {
            $nomorSo = $dryresin->nomor_so;
            $kategori = $dryresin->kategori;
            $ukuranKapasitas = $dryresin->ukuran_kapasitas;

            $nomorSo = str_replace(['/', '-'], '', $nomorSo);

            $kdManhour = $kategori . '' .  $ukuranKapasitas . '' . $nomorSo;

            $dryresin->kd_manhour = $kdManhour;
        });
    }
}