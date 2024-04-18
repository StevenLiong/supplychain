<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CtVt extends Model
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
           'balut_core_ct',
           'cca_balutvt',
           'buat_pasang_shelding',
           'gulung_coil_sekunder_ct',
           'buat_coil_primer_ct_manual',
           'buat_coil_primer_ct_mesin',
           'conect_ct_vt',
           'solder',
           'gulung_coil_primer_cutcore',
           'gulung_coil_primer_nocutcor',
           'gulungcoil_vt_mesin',
           'gulungcoil_vt_manual',
           'mould_assembly_ct',
           'prosesmouldassembly_typevt',
           'mould_assembly_rct',
           'oven',
           'pembuatan_material',
           'casting',
           'demoulding',
           'gerinda',
           'cat',
           'accessoris',
           'qc_testing',
            'totalHour_coil_making',
            'totalHour_MouldCasting',
            'totalHour_FinalAssembly',
            'hour_balut_core_ct',
            'hour_cca_balutvt',
            'hour_buat_pasang_shelding',
            'hour_gulung_coil_sekunder_ct',
            'hour_buat_coil_primer_ct_manual',
            'hour_buat_coil_primer_ct_mesin',
            'hour_conect_ct_vt',
            'hour_solder',
            'hour_gulung_coil_primer_cutcore',
            'hour_gulung_coil_primer_nocutcor',
            'hour_gulungcoil_vt_mesin',
            'hour_gulungcoil_vt_manual',
            'hour_mould_assembly_ct',
            'hour_prosesmouldassembly_typevt',
            'hour_mould_assembly_rct',
            'hour_oven',
            'hour_pembuatan_material',
            'hour_casting',
            'hour_demoulding',
            'hour_gerinda',
            'hour_cat',
            'hour_accessoris',
            'hour_qc_testing'
        ];

        // public function man_hour(): BelongsTo
        // {
        //     return $this->belongsTo(ManHour::class,'manhour_id','id');
        // }

        public static function boot()
        {
            parent::boot();

            static::created(function ($ctvt) {
                StandardizeWork::create([
                    'id_ctvt' => $ctvt->id,
                    'total_hour' => $ctvt->total_hour,
                    'id_fg' => $ctvt->id_fg,
                    'kd_manhour' => $ctvt->kd_manhour,
                    'nomor_so' => $ctvt->nomor_so,
                    'ukuran_kapasitas' => $ctvt->ukuran_kapasitas,
                    'nama_product' => 'CTVT',
                ]);
            });

            // self::creating(function ($ct) {
            //     $nomorSo = strtoupper($ct->nomor_so);
            //     $kategori = $ct->kategori;
            //     $kapasitas = Kapasitas::where('ukuran_kapasitas', $ct->ukuran_kapasitas)->first();
            //     if ($kapasitas) {
            //         $id_kapasitas = $kapasitas->id;
            //     } else {
            //         $id_kapasitas = '0';
            //     }

            //     $nomorSo = str_replace(['/', '-'], '', $nomorSo);

            //     $kdManhour = $kategori . '' .  $id_kapasitas . '' . $nomorSo;
            //     $kdManhour = str_pad($kdManhour, 14, '0', STR_PAD_RIGHT);
            //     $ct->kd_manhour = $kdManhour;
            // });

    }
}
