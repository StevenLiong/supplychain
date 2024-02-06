<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Repair extends Model
{
    use HasFactory;
    protected $fillable = [
        'kd_manhour',
        'nama_product',
        'kategori',
        'nomor_so',
        'id_fg',
        'ukuran_kapasitas',
        'total_hour',
        'on_cover_standard',
        'sidewall',
        'conservator_cabelbox',
        'radiator',
        'accessories_proteksi',
        'angkat_coil',
        'coil_lv',
        'coil_lv_plus',
        'coil_hv',
        'coil_hv_plus',
        'core_coil_assembly',
        'connection_final_assembly',
        'hv_connection',
        'lv_connection',
        'accessories',
        'special_assembly',
        'finishing',
        'cable_box',
        'wiring_control_box',
        'copper_link',
        'radiator_panel',
        'conservator_finish',
        'qc_testing',
        'totalHour_untangking',
        'totalHour_bongkar',
        'totalHour_coil_making',
        'totalHour_CoreAssembly',
        'totalHour_ConectAssembly',
        'totalHour_FinalAssembly',
        'totalHour_SpecialFinalAssembly',
        'totalHour_Finishing',
        'totalHour_cabelbox',
        'totalHour_wiring_controlbox',
        'totalHour_copper_link',
        'totalHour_radiator_panel',
        'totalHour_conservator',
        'totalHour_QCTest',
        'hour_on_cover_standard',
        'hour_sidewall',
        'hour_conservator_cabelbox',
        'hour_radiator',
        'hour_accessories_proteksi',
        'hour_angkat_coil',
        'hour_coil_lv',
        'hour_coil_lv_plus',
        'hour_coil_hv',
        'hour_coil_hv_plus',
        'hour_core_coil_assembly',
        'hour_connection_final_assembly',
        'hour_hv_connection',
        'hour_lv_connection',
        'hour_accessories',
        'hour_special_assembly',
        'hour_cable_box',
        'hour_wiring_control_box',
        'hour_copper_link',
        'hour_radiator_panel',
        'hour_conservator_finish',
        'hour_qc_testing'
    ];

    public function man_hour(): BelongsTo
    {
        return $this->belongsTo(ManHour::class,'manhour_id','id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($repair) {
            StandardizeWork::create([
                'id_repair' => $repair->id,
                'nama_product' =>'Repair',
            ]);
        });

        self::creating(function ($repair) {
            $nomorSo = $repair->nomor_so;
            $kategori = $repair->kategori;
            $ukuranKapasitas = $repair->ukuran_kapasitas;

            $nomorSo = str_replace(['/', '-'], '', $nomorSo);

            $kdManhour = $kategori . '' .  $ukuranKapasitas . '' . $nomorSo;

            $repair->kd_manhour = $kdManhour;
        });
    }
}
