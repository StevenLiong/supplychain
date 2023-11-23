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
        'nomor_so',
        'ukuran_kapasitas',
        'total_hour',
        'coil_lv',
        'coil_lv_plus',
        'coil_hv',
        'coil_hv_plus',
        'core_coil_assembly',
        'connection',
        'hv_lv_connection',
        'final_assy',
        'final_assy_plus',
        'special_assembly',
        'finishing',
        'qc_testing',
    ];

    public function man_hour(): BelongsTo
    {
        return $this->belongsTo(ManHour::class,'manhour_id','id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($oil_custom) {
            StandardizeWork::create([
                'id_oil_custom' => $oil_custom->id,
            ]);
        });

        self::creating(function ($oil_custom) {
            $nomorSo = $oil_custom->nomor_so;
            $kategori = $oil_custom->kategori;
            $ukuranKapasitas = $oil_custom->ukuran_kapasitas;

            $nomorSo = str_replace(['/', '-'], '', $nomorSo);

            $kdManhour = $kategori . '' .  $ukuranKapasitas . '' . $nomorSo;

            $oil_custom->kd_manhour = $kdManhour;
        });
    }
}
