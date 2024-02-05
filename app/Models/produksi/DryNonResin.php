<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DryNonResin extends Model
{
    use HasFactory;
    protected $table = 'dry_non_resins';

    protected $fillable = [
        'kd_manhour',
        'nama_product',
        'kategori',
        'nomor_so',
        'id_fg',
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
        'totalHour_coil_making',
        'totalHour_MouldCasting',
        'totalHour_CoreCoilAssembly',
        'totalHour_QCTest',
        'hour_coil_lv',
        'hour_coil_hv',
        'hour_potong_leadwire',
        'hour_potong_isolasi',
        'hour_moulding_casting',
        'hour_type_susun_core',
        'hour_hv_connection',
        'hour_lv_connection',
        'hour_wiring',
        'hour_instal_housing',
        'hour_bongkar_housing',
        'hour_pembuatan_cu_link',
        'hour_others',
        'hour_accesories',
        'hour_potong_isolasi_fiber',
        'hour_qc_testing',
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
                'total_hour' => $drynonresin->total_hour,
                'id_fg' => $drynonresin->id_fg,
                'kd_manhour' => $drynonresin->kd_manhour,
                'nama_product' =>'Dry Non Cast Resin',
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
