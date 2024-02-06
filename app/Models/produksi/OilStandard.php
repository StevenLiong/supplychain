<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OilStandard extends Model
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
        'coil_lv',
        'coil_hv',
        'leadwire',
        'press_coil',
        'core_coil_assembly',
        'connect',
        'final_assembly',
        'qc_testing',
        'totalHour_coil_making',
        'totalHour_CoreCoilAssembly',
        'totalHour_Conect',
        'totalHour_FinalAssembly',
        'totalHour_QCTest',
        'hour_coil_lv',
        'hour_coil_hv',
        'hour_leadwire',
        'hour_press_coil',
        'hour_core_coil_assembly',
        'hour_connect',
        'hour_final_assembly',
        'hour_qc_testing'
    ];

    public function man_hour(): BelongsTo
    {
        return $this->belongsTo(ManHour::class, 'manhour_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($oil_standard) {
            StandardizeWork::create([
                'id_oil_standard' => $oil_standard->id,
                'nama_product' => 'Oil Standard',
            ]);
        });

        self::creating(function ($oil_standard) {
            $nomorSo = $oil_standard->nomor_so;
            $kategori = $oil_standard->kategori;
            $ukuranKapasitas = $oil_standard->ukuran_kapasitas;

            $nomorSo = str_replace(['/', '-'], '', $nomorSo);

            $kdManhour = $kategori . '' .  $ukuranKapasitas . '' . $nomorSo;

            $oil_standard->kd_manhour = $kdManhour;
        });
    }
}
