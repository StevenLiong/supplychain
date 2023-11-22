<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vt extends Model
{
    use HasFactory;
    protected $fillable = [
        'kd_manhour',
        'nama_product',
        'kategori',
        'nomor_so',
        'ukuran_kapasitas',
        'total_hour',
        'coil_vt',
        'mould_casting',
        'final_assembly',
        'potong_isolasi',
        'qc_testing',
    ];

    public function man_hour(): BelongsTo
    {
        return $this->belongsTo(ManHour::class,'manhour_id','id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($vt) {
            StandardizeWork::create([
                'id_vt' => $vt->id,
            ]);
        });

        self::creating(function ($vt) {
            $nomorSo = $vt->nomor_so;
            $kategori = $vt->kategori;
            $ukuranKapasitas = $vt->ukuran_kapasitas;

            $nomorSo = str_replace(['/', '-'], '', $nomorSo);

            $kdManhour = $kategori . '' .  $ukuranKapasitas . '' . $nomorSo;

            $vt->kd_manhour = $kdManhour;
        });
    }
}
