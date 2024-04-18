<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OilCustom extends Model
{
    use HasFactory;
    protected $fillable = [
        'kd_manhour',
        'nama_product',
        'kategori',
        'id_fg' ,
        'nomor_so',
        'ukuran_kapasitas',
        'total_hour',
        'coil_lv',
        'coil_hv',
        'cca',
        'connection',
        'final_assy',
        'special_assembly',
        'finishing',
        'qc_testing',
        'totalHour_coil_making',
        'totalHour_CoreCoilAssembly',
        'totalHour_Conect',
        'totalHour_FinalAssembly',
        'totalHour_Finishing',
        'totalHour_QCTest',
        'hour_coil_lv',
        'hour_coil_hv',
        'hour_cca',
        'hour_connection',
        'hour_hv_connection',
        'hour_final',
        'hour_final_assy',
        'hour_special_assembly',
        'hour_finishing',
        'hour_qc_testing'
    ];


    public static function boot()
    {
        parent::boot();

        static::created(function ($oil_custom) {
            StandardizeWork::create([
            'id_oil_custom' => $oil_custom->id,
            'total_hour' => $oil_custom->total_hour,
            'id_fg' => $oil_custom->id_fg,
            'kd_manhour' => $oil_custom->kd_manhour,
            'nomor_so' => $oil_custom->nomor_so,
            'ukuran_kapasitas' => $oil_custom->ukuran_kapasitas,
            'nama_product' => 'Oil Custom',
        ]);
        });
    }
}
