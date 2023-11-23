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
        'ukuran_kapasitas',
        'total_hour',
        'on_cover_standard',
        'sidewall',
        'conservator',
        'cable_box_hv',
        'radiator',
        'accessories_proteksi',
        'angkat_coil',
        'isolasi_coil',
        'isolasi_cca',
        'material_coil_lv_hv',
        'core_coil_assembly',
        'connection',
        'hv_connection',
        'lv_connection',
        'final_assembly',
        'accessories',
        'cable_box',
        'wiring',
        'copper_link',
        'radiator_panel',
        'conservator_finish',
        'qc_testing',
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
