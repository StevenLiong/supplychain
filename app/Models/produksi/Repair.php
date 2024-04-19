<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_product',
        'kd_manhour',
        'nomor_so',
        'id_fg',
        'total_hour',
        'kategori',
        'ukuran_kapasitas',
        'untanking',
        'bongkar_conservator',
        'bongkar_cable_box',
        'bongkar_radiator_panel',
        'bongkar_accesories',
        'bongkar_core',
        'coil_lv',
        'coil_hv',
        'cca',
        'connect',
        'hv_connect',
        'lv_connect',
        'final_assembly',
        'accessories',
        'wiring',
        'copper_link',
        'cable_box',
        'radiator_panel',
        'conservator',
        'qc',
        'totalHour_bongkar',
        'totalHour_coil_making',
        'totalHour_CCA',
        'totalHour_Conect',
        'totalHour_FinalAssembly',
        'totalHour_Finishing',
        'totalHour_QCTest',
        'hour_untanking',
        'hour_bongkar_conservator',
        'hour_bongkar_cable_box',
        'hour_bongkar_radiator_panel',
        'hour_bongkar_accesories',
        'hour_bongkar_core',
        'hour_coil_lv',
        'hour_coil_hv',
        'hour_cca',
        'hour_connect',
        'hour_hv_connect',
        'hour_lv_connect',
        'hour_final_assembly',
        'hour_accessories',
        'hour_wiring',
        'hour_copper_link',
        'hour_cable_box',
        'hour_radiator_panel',
        'hour_conservator',
        'hour_qc',
    ];
    public static function boot()
    {
        parent::boot();

        static::created(function ($repair) {
            StandardizeWork::create([
            'id_repair' => $repair->id,
            'total_hour' => $repair->total_hour,
            'id_fg' => $repair->id_fg,
            'kd_manhour' => $repair->kd_manhour,
            'nomor_so' => $repair->nomor_so,
            'ukuran_kapasitas' => $repair->ukuran_kapasitas,
            'nama_product' => 'Repair',
        ]);
        });
    }
}
