<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DryCastResin extends Model
{
    use HasFactory;
    protected $table = 'dry_cast_resins';

    protected $fillable = [
        'kd_manhour',
        'nama_product',
        'kategori',
        'id_fg',
        'nomor_so',
        'ukuran_kapasitas',
        'total_hour',
        'coil_lv',
        'coil_hv',
        'potong_leadwire',
        'potong_isolasi',
        'hv_moulding',
        'hv_casting',
        'hv_demoulding',
        'lv_bobbin',
        'lv_moulding',
        'touch_up',
        'type_susun_core',
        'wiring',
        'instal_housing',
        'bongkar_housing',
        'pembuatan_cu_link',
        'others',
        'accesories',
        'potong_isolasi_fiber',
        'qc_testing',
        'totalHour_coil_making',
        'totalHour_coil_makinglv',
        'totalHour_MouldCasting',
        'totalHour_CoreCoilAssembly',
        'totalHour_SusunCore',
        'totalHour_Finishing',
        'totalHour_Connection_Final_Assembly',
        'totalHour_QCTest',
        'hour_coil_lv',
        'hour_coil_hv',
        'hour_potong_leadwire',
        'hour_potong_isolasi',
        'hour_hv_moulding',
        'hour_hv_casting',
        'hour_hv_demoulding',
        'hour_lv_bobbin',
        'hour_lv_moulding',
        'hour_touch_up',
        'hour_type_susun_core',
        'hour_wiring',
        'hour_instal_housing',
        'hour_bongkar_housing',
        'hour_pembuatan_cu_link',
        'hour_others',
        'hour_accesories',
        'hour_potong_isolasi_fiber',
        'hour_qc_testing',
        'keterangan',
    ];

    public function man_hour(): BelongsTo
    {
        return $this->belongsTo(ManHour::class, 'manhour_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($dryresin) {
            StandardizeWork::create([
                'id_dry_cast_resin' => $dryresin->id,
                'total_hour' => $dryresin->total_hour,
                'id_fg' => $dryresin->id_fg,
                'kd_manhour' => $dryresin->kd_manhour,
                'nomor_so' => $dryresin->nomor_so,
                'ukuran_kapasitas' => $dryresin->ukuran_kapasitas,
                'nama_product' => 'Dry Cast Resin',
            ]);
        });

        self::creating(function ($dryresin) {
            $nomorSo = $dryresin->nomor_so;
            $kategori = $dryresin->kategori;
            $ukuranKapasitas = $dryresin->ukuran_kapasitas;

            $nomorSo = str_replace(['/', '-'], '', $nomorSo);

            $kdManhour = $kategori . '' .  $ukuranKapasitas . '' . $nomorSo;

            $dryresin->kd_manhour = $kdManhour;
        });
        self::creating(function ($dryresin) {
            $hour_potong_isolasi_fiber = $dryresin->hour_potong_isolasi_fiber;
            $hour_susun_core = $dryresin->hour_type_susun_core;

            // Tambahkan pengecekan jika kedua nilai tersebut tidak null sebelum melakukan perhitungan
            if ($hour_potong_isolasi_fiber !== null && $hour_susun_core !== null) {
                $hour = $hour_susun_core + $hour_potong_isolasi_fiber;

                $dryresin->totalHour_SusunCore = $hour;
            }
        });
        self::creating(function ($dryresin) {
            $hour = $dryresin->hour_others;

            $dryresin->totalHour_Connection_Final_Assembly = $hour;
        });
        self::creating(function ($dryresin) {
            $wiring = $dryresin->hour_wiring ?? 0;
            $instal_housing = $dryresin->hour_instal_housing ?? 0;
            $bongkar_housing = $dryresin->hour_bongkar_housing ?? 0;
            $pembuatan_cu_link = $dryresin->hour_pembuatan_cu_link ?? 0;
            $accesories = $dryresin->hour_accesories ?? 0;

            $hour = $wiring + $instal_housing + $bongkar_housing + $pembuatan_cu_link + $accesories;

            $dryresin->totalHour_Finishing = ($hour > 0) ? $hour : null;
        });
        self::creating(function ($dryresin) {
            $coillv = $dryresin->hour_coil_lv ?? 0;
            $potong_leadwire = $dryresin->hour_potong_leadwire ?? 0;
            $potong_isolasi = $dryresin->hour_potong_isolasi ?? 0;

            $hour = $coillv + $potong_isolasi + $potong_leadwire ;

            $dryresin->totalHour_coil_makinglv = ($hour > 0) ? $hour : null;
        });

    }
}
