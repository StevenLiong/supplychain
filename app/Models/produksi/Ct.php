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
        'id_fg',
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
                'total_hour' => $ct->total_hour,
                'id_fg' => $ct->id_fg,
                'kd_manhour' => $ct->kd_manhour,
                'nomor_so' => $ct->nomor_so,
                'ukuran_kapasitas' => $ct->ukuran_kapasitas,
                'nama_product' =>'CT',
            ]);
        });

        self::creating(function ($ct) {
            $nomorSo = strtoupper($ct->nomor_so);
            $kategori = $ct->kategori;
            $kapasitas = Kapasitas::where('ukuran_kapasitas', $ct->ukuran_kapasitas)->first();
            if ($kapasitas) {
                $id_kapasitas = $kapasitas->id;
            } else {
                $id_kapasitas = '0';
            }

            $nomorSo = str_replace(['/', '-'], '', $nomorSo);

            $kdManhour = $kategori . '' .  $id_kapasitas . '' . $nomorSo;
            $kdManhour = str_pad($kdManhour, 14, '0', STR_PAD_RIGHT);
            $ct->kd_manhour = $kdManhour;
        });
    }
}
