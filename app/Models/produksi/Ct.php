<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ct extends Model
{
    use HasFactory;
    protected $fillable = [
        'kd_manhour',
        'nama_product',
        'kategori',
        'nomor_so',
        'ukuran_kapasitas',
        'total_hour',
        'coil_ct',
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

        static::created(function ($ct) {
            StandardizeWork::create([
                'id_ct' => $ct->id,
            ]);
        });

        self::creating(function ($ct) {
            $nomorSo = $ct->nomor_so;
            $kategori = $ct->kategori;
            $ukuranKapasitas = $ct->ukuran_kapasitas;

            $nomorSo = str_replace(['/', '-'], '', $nomorSo);

            $kdManhour = $kategori . '' .  $ukuranKapasitas . '' . $nomorSo;

            $ct->kd_manhour = $kdManhour;
        });
    }
}
