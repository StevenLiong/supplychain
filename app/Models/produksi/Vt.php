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
        'id_fg',
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
                'total_hour' => $vt->total_hour,
                'id_fg' => $vt->id_fg,
                'kd_manhour' => $vt->kd_manhour,
                'nomor_so' => $vt->nomor_so,
                'ukuran_kapasitas' => $vt->ukuran_kapasitas,
                'nama_product' =>'VT',
            ]);
        });

        self::creating(function ($vt) {
            $nomorSo = strtoupper($vt->nomor_so);
            $kategori = $vt->kategori;
            $kapasitas = Kapasitas::where('ukuran_kapasitas', $vt->ukuran_kapasitas)->first();
            if ($kapasitas) {
                $id_kapasitas = $kapasitas->id;
            } else {
                $id_kapasitas = '0';
            }

            $nomorSo = str_replace(['/', '-'], '', $nomorSo);

            $kdManhour = $kategori . '' .  $id_kapasitas . '' . $nomorSo;
            $kdManhour = str_pad($kdManhour, 14, '0', STR_PAD_RIGHT);
            $vt->kd_manhour = $kdManhour;
        });
    }
}
