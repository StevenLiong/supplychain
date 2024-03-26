<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DryNonResin extends Model
{
    use HasFactory;
    protected $table = 'dry_non_resins';

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
        'potong_leadwire',
        'potong_isolasi',
        'moulding_casting',
        'type_susun_core',
        'hv_connection',
        'lv_connection',
        'wiring',
        'instal_housing',
        'bongkar_housing',
        'pembuatan_cu_link',
        'others',
        'accesories',
        'potong_isolasi_fiber',
        'qc_testing',
        'totalHour_coil_making',
        'totalHour_MouldCasting',
        'totalHour_CoreCoilAssembly',
        'totalHour_QCTest',
        'hour_coil_lv',
        'hour_coil_hv',
        'hour_potong_leadwire',
        'hour_potong_isolasi',
        'hour_moulding_casting',
        'hour_type_susun_core',
        'hour_hv_connection',
        'hour_lv_connection',
        'hour_wiring',
        'hour_instal_housing',
        'hour_bongkar_housing',
        'hour_pembuatan_cu_link',
        'hour_others',
        'hour_accesories',
        'hour_potong_isolasi_fiber',
        'hour_qc_testing',
    ];

    public function man_hour(): BelongsTo
    {
        return $this->belongsTo(ManHour::class,'manhour_id','id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($drynonresin) {
            StandardizeWork::create([
                'id_dry_non_resin' => $drynonresin->id,
                'total_hour' => $drynonresin->total_hour,
                'id_fg' => $drynonresin->id_fg,
                'kd_manhour' => $drynonresin->kd_manhour,
                'nomor_so' => $drynonresin->nomor_so,
                'ukuran_kapasitas' => $drynonresin->ukuran_kapasitas,
                'nama_product' =>'Dry Non Cast Resin',
            ]);
        });
        self::creating(function ($drynonresin) {
            $nomorSo = strtoupper($drynonresin->nomor_so);
            $kategori = $drynonresin->kategori;
            $kapasitas = Kapasitas::where('ukuran_kapasitas', $drynonresin->ukuran_kapasitas)->first();
            if ($kapasitas) {
                $id_kapasitas = $kapasitas->id;
            } else {
                $id_kapasitas = '0';
            }

            $nomorSo = str_replace(['/', '-'], '', $nomorSo);

            $kdManhour = $kategori . '' .  $id_kapasitas . '' . $nomorSo;
            $kdManhour = str_pad($kdManhour, 14, '0', STR_PAD_RIGHT);
            $drynonresin->kd_manhour = $kdManhour;
        });
        // self::creating(function ($drynonresin) {
        //     $hour_potong_isolasi_fiber = $drynonresin->hour_potong_isolasi_fiber;
        //     $hour_susun_core = $drynonresin->hour_type_susun_core;

        //     // Tambahkan pengecekan jika kedua nilai tersebut tidak null sebelum melakukan perhitungan
        //     if ($hour_potong_isolasi_fiber !== null && $hour_susun_core !== null) {
        //         $hour = $hour_susun_core + $hour_potong_isolasi_fiber;

        //         $drynonresin->totalHour_SusunCore = $hour;
        //     }
        // });
        // self::creating(function ($drynonresin) {
        //     $hour = $drynonresin->hour_others;

        //     $drynonresin->totalHour_Connection_Final_Assembly = $hour;
        // });
        // self::creating(function ($drynonresin) {
        //     $wiring = $drynonresin->hour_wiring ?? 0;
        //     $instal_housing = $drynonresin->hour_instal_housing ?? 0;
        //     $bongkar_housing = $drynonresin->hour_bongkar_housing ?? 0;
        //     $pembuatan_cu_link = $drynonresin->hour_pembuatan_cu_link ?? 0;
        //     $accesories = $drynonresin->hour_accesories ?? 0;

        //     $hour = $wiring + $instal_housing + $bongkar_housing + $pembuatan_cu_link + $accesories;

        //     $drynonresin->totalHour_Finishing = ($hour > 0) ? $hour : null;
        // });
        // self::creating(function ($drynonresin) {
        //     $coillv = $drynonresin->hour_coil_lv ?? 0;
        //     $potong_leadwire = $drynonresin->hour_potong_leadwire ?? 0;
        //     $potong_isolasi = $drynonresin->hour_potong_isolasi ?? 0;

        //     $hour = $coillv + $potong_isolasi + $potong_leadwire ;

        //     $drynonresin->totalHour_coil_makinglv = ($hour > 0) ? $hour : null;
        // });
    }


}
