<?php

namespace App\Http\Controllers\planner;

use Carbon\Carbon;
use App\Models\planner\Mps2;
use Illuminate\Http\Request;
use App\Models\planner\GPADry;
use App\Models\planner\Holiday;
use App\Http\Controllers\Controller;
use App\Models\produksi\DryCastResin;
use App\Models\produksi\StandardizeWork;
use App\Models\planner\KapasitasProduksi;

class Mps2Controller extends Controller
{
    public function index(){
        $startDate = Carbon::create(2024, 1, 1); // Tanggal awal yang Anda inginkan
        $endDate = Carbon::create(2024, 12, 31); // Tanggal akhir yang Anda inginkan
        // Ambil nama bulan dari tanggal startdate atau enddate
        $monthName = ucfirst($startDate->translatedFormat('F')); // Ambil nama bulan dari startdate
        $monthName2 = ucfirst($endDate->translatedFormat('F')); // Ambil nama bulan dari startdate
        $kapasitasPL2 = KapasitasProduksi::whereBetween('tanggal', [$startDate, $endDate])
                                          ->pluck('pl2', 'tanggal')
                                          ->toArray();
        $kapasitasPL3 = KapasitasProduksi::whereBetween('tanggal', [$startDate, $endDate])
                                          ->pluck('pl3', 'tanggal')
                                          ->toArray();
        $kapasitasDrytype = KapasitasProduksi::whereBetween('tanggal', [$startDate, $endDate])
                                          ->pluck('drytype', 'tanggal')
                                          ->toArray();
        // Ubah format tanggal menjadi hanya tanggal (day)
        $tanggalHeaders = KapasitasProduksi::whereBetween('tanggal', [$startDate, $endDate])
                                          ->pluck('tanggal')
                                          ->toArray();

        $mps2s = Mps2::all();
        
        return view('planner.MPS2.gantt', compact('kapasitasPL2', 'kapasitasPL3', 'kapasitasDrytype', 'tanggalHeaders', 'mps2s', 'monthName', 'monthName2'));
    }  

    public function store(Request $request)
    {
        $inputs = $request->all();
        $mps2Data = [];
        $kd_manhours = [];
        $id_standardizeworks = [];
        $deadlines = $inputs['deadline'];
        $kvas = $inputs['kva'];
        $qty_trafos = $inputs['qty_trafo'];

        function isHoliday($date) {
            return Holiday::whereDate('date', $date)->exists();
        }
        
        

        function reduceIfHoliday($date) {
            while (Holiday::whereDate('date', $date)->exists()) {
                $date = Carbon::parse($date)->subWeekdays()->format('Y-m-d');
            }
            return $date;
        }

        for ($j = 0; $j < count($inputs['id_wo']); $j++) {
            $id_wo = $inputs['id_wo'][$j];
            $cekidwo = GPADry::where('id_wo', $id_wo)->first();
            // Validasi jika id_wo sudah ada
            if ($cekidwo) {
                return redirect()->back()->with('error', 'WO sudah disubmit sebelumnya.');
            }
            $id_so = preg_replace('/(\D)(\d{1})(\d{2})(\d+)/', 'S$2/$3/$4', $id_wo);

            if (!empty($inputs['id_wo'][$j])) {
                $kd_manhour = StandardizeWork::where('nomor_so', $id_so)
                        ->where('ukuran_kapasitas', $kvas[$j])
                        ->value('kd_manhour');

                $id_standardizework = StandardizeWork::where('nomor_so', $id_so)
                        ->where('ukuran_kapasitas', $kvas[$j])
                        ->value('id');
                $id_standardizeworks[] = $id_standardizework;
                $kd_manhours[] = $kd_manhour;
                $mps2Data[] = [
                    // 'id' => null,
                    'id_wo' => $id_wo,
                    'id_so' => $id_so,
                    'production_line' => $inputs['production_line'][$j],
                    'project' => $inputs['project'][$j],
                    'deadline' => $deadlines[$j],
                    'kva' => $kvas[$j],
                    'qty_trafo' => $qty_trafos[$j],
                    // 'kd_manhour' => StandardizeWork::where('nomor_so', $id_so)
                    //     ->where('ukuran_kapasitas', $kvas[$j])
                    //     ->value('kd_manhour'),
                    'kd_manhour' => $kd_manhour,
                    'id_standardize_work' => $id_standardizework,
                    // 'id_standardize_work' => StandardizeWork::where('nomor_so', $id_so)
                    //     ->where('ukuran_kapasitas', $kvas[$j])
                    //     ->value('id'),
                ];
            }
            // dd($qty_trafos);
            $kapasitasProduksi = KapasitasProduksi::where('tanggal', $deadlines[$j])
                ->whereRaw('Drytype < ?', [$qty_trafos[$j]])
                ->doesntExist();
                if (!$kapasitasProduksi) {
                    return redirect()->back()->with('error', 'Kapasitas pada tanggal yang diinput sudah penuh. Data tidak dapat disimpan.');
                }
                KapasitasProduksi::where('tanggal', $deadlines[$j])->decrement('Drytype', (int)$qty_trafos[$j]);
        }
        // dd($mps2Data);
        Mps2::insert($mps2Data);
        $data_mps2 = Mps2::all();
        // dd($data_mps2);

        foreach ($data_mps2 as $mps2) {
            $id_wo = $mps2['id_wo'];
            // dd($mps2);
            $id_so = $mps2['id_so'];
            $production_line = $mps2['production_line'];
            $project = $mps2['project'];
            $deadline = $mps2['deadline'];
            $kva = $mps2['kva'];
            $qty_trafo = $mps2['qty_trafo'];
            $kd_manhour = $mps2['kd_manhour'];
            $id_standardize_work = $mps2['id_standardize_work'];
            $drycastresins = DryCastResin::where('kd_manhour', $kd_manhour)->get();
            $cekidwo = GPADry::where('id_wo', $id_wo)->first();

            if ($cekidwo) {
                continue;
            }

            if($production_line === 'Dry')
            {
                foreach($drycastresins as $drycastresin){
                    // AMBIL DATA HOUR DARI STANDARDIZE WORK
                    $coil_lv = $drycastresin->hour_coil_lv + $drycastresin->hour_potong_leadwire + $drycastresin->hour_potong_isolasi;
                    $coil_hv = $drycastresin->hour_coil_hv;
                    $oven_hour = $drycastresin->hour_oven;
                    if($oven_hour > 0){
                        $oven_hour = 0.50;
                    }else{
                        $oven_hour = 0.00;
                    }
                    $moulding = $drycastresin->hour_hv_moulding + $drycastresin->hour_lv_moulding + $drycastresin->hour_hv_casting + $drycastresin->hour_hv_demoulding + 
                                $drycastresin->hour_lv_bobbin + $drycastresin->hour_touch_up + $oven_hour;
                    $susun_core = $drycastresin->hour_type_susun_core;
                    // $susun_core = $drycastresin->hour_type_susun_core + $drycastresin->hour_potong_isolasi_fiber; -> Cara Lama
                    $cek_acc = $drycastresin->accesories;
                    $oltc = 0.00;
                    $acc_selain_oltc = 0.00;
                    // dd($cek_acc);
                    if($cek_acc === 'OLTC')
                    {
                        $oltc = $drycastresin->hour_accesories;
                    }else{
                        $acc_selain_oltc = $drycastresin->hour_accesories;
                    }
                    // dd($oltc);
                    $finishing = $drycastresin->hour_wiring + $drycastresin->hour_instal_housing + $drycastresin->hour_bongkar_housing + 
                                $drycastresin->hour_pembuatan_cu_link + $oltc;
                    // dd($finishing);
                    $connection_finalassembly = $drycastresin->hour_others + $drycastresin->hour_potong_isolasi_fiber + $acc_selain_oltc;
                    $qc = $drycastresin->hour_qc_testing;
                    $bom = 8.00;
                    $ins_paper = 8.00;
                    $sup_mat_ins_coil = 8.00;
                    $sup_mat_moulding = 8.00;
                    $core = 8.00;
                    $sup_fix_core = 8.00;
                    $sup_mat_con_fa = 8.00;
                    $qc_tran_gudang = 8.00;

                    // VARIABEL BARU UNTUK DIUBAH JADI HARI
                    $hari_coil_lv = ceil($coil_lv / 8);
                    $hari_coil_hv = ceil($coil_hv / 8);
                    $hari_moulding = ceil($moulding / 8);
                    $hari_susun_core = ceil($susun_core / 8);
                    $hari_finishing = ceil($finishing / 8);
                    $hari_connection_finalassembly = ceil($connection_finalassembly / 8);
                    $hari_qc = ceil($qc / 8);
                    $hari_bom = ceil($bom / 8);
                    $hari_ins_paper = ceil($ins_paper / 8);
                    $hari_sup_mat_ins_coil = ceil($sup_mat_ins_coil / 8);
                    $hari_sup_mat_moulding = ceil($sup_mat_moulding / 8);
                    $hari_core = ceil($core / 8);
                    $hari_sup_fix_core = ceil($sup_fix_core / 8);
                    $hari_sup_mat_con_fa = ceil($sup_mat_con_fa / 8);
                    $hari_qc_tran_gudang = ceil($qc_tran_gudang / 8);

                    // dd(
                    //     $id_wo, ceil($bom), ceil($ins_paper), ceil($sup_mat_ins_coil), ceil($sup_mat_moulding),
                    //     ceil($coil_lv), ceil($coil_hv), ceil($core), ceil($sup_fix_core),
                    //     ceil($moulding), ceil($susun_core), ceil($sup_mat_con_fa), ceil($connection_finalassembly),
                    //     ceil($finishing), ceil($qc), ceil($qc_tran_gudang)
                    // );

                    // dd(
                    //     $hari_bom, $hari_ins_paper, $hari_sup_mat_ins_coil, $hari_sup_mat_moulding,
                    //     $hari_core, $hari_sup_fix_core, $hari_sup_mat_con_fa, $hari_qc_tran_gudang,
                    //     $hari_coil_hv, $hari_coil_lv, $hari_moulding, $hari_susun_core,
                    //     $hari_finishing, $hari_connection_finalassembly, $hari_qc
                    // );
                    // $total_hour = ceil(
                    //     $bom + $ins_paper + $sup_mat_ins_coil + $sup_mat_moulding +
                    //     $core + $sup_fix_core + $sup_mat_con_fa + $qc_tran_gudang +
                    //     $coil_hv + $coil_lv + $moulding + $susun_core +
                    //     $finishing + $connection_finalassembly + $qc
                    // );

                    // $total_hari = ceil(
                    //     $hari_bom + $hari_ins_paper + $hari_sup_mat_ins_coil + $hari_sup_mat_moulding +
                    //     $hari_core + $hari_sup_fix_core + $hari_sup_mat_con_fa + $hari_qc_tran_gudang +
                    //     $hari_coil_hv + $hari_coil_lv + $hari_moulding + $hari_susun_core +
                    //     $hari_finishing + $hari_connection_finalassembly + $hari_qc
                    // );
                    $total_hari = ceil(
                        $hari_bom + $hari_ins_paper + $hari_sup_mat_ins_coil +
                        $hari_sup_mat_con_fa + $hari_qc_tran_gudang + $hari_moulding + 
                        $hari_coil_hv + $hari_coil_lv + $hari_finishing + $hari_connection_finalassembly + $hari_qc
                    );
                    // dd($total_hari);

                    //MASUK KE CODE UNTUK DEADLINE GPA
                    $deadline_pecah = $mps2['deadline'];
                    // dd($deadline_pecah);
                    $deadline = sprintf('%04d-%02d-%02d', $deadline_pecah['year'], $deadline_pecah['month'], $deadline_pecah['day']);
                    $deadline_new = Carbon::parse($deadline);
                    // dd($deadline);
                    $deadline_awal = Carbon::parse($deadline)->subWeekdays($total_hari);

                    $holidays = Holiday::whereBetween('date', [$deadline_awal, $deadline_new])->count();
                    // dd($holidays);

                    $deadline_awal_banget = Carbon::parse($deadline_awal)->addWeekdays($holidays);
                    // dd($deadline_awal,$deadline_awal_banget);

                    // $deadline_awal_v1 = $deadline_awal + Carbon::parse($deadline_awal)->subWeekdays(countHolidays($deadline_new, $deadline_awal));
                    // dd($deadline_awal, $deadline_awal_v1, $deadline_new);
                    
                    $deadline_wc15_v1 = $deadline_new->copy()->subWeekdays($hari_qc_tran_gudang);
                    $deadline_wc15_v2 = $deadline_wc15_v1->format('Y-m-d');
                    $deadline_wc15 = reduceIfHoliday($deadline_wc15_v2);
                    $deadline_wc14_v1 = Carbon::parse($deadline_wc15)->subWeekdays($hari_qc);
                    $deadline_wc14_v2 = $deadline_wc14_v1->format('Y-m-d');
                    $deadline_wc14 = reduceIfHoliday($deadline_wc14_v2);
                    $deadline_wc13_v1 = Carbon::parse($deadline_wc14)->subWeekdays($hari_finishing);
                    $deadline_wc13_v2 = $deadline_wc13_v1->format('Y-m-d');
                    $deadline_wc13 = reduceIfHoliday($deadline_wc13_v2);
                    $deadline_wc12_v1 = Carbon::parse($deadline_wc13)->subWeekdays($hari_connection_finalassembly);
                    $deadline_wc12_v2 = $deadline_wc12_v1->format('Y-m-d');
                    $deadline_wc12 = reduceIfHoliday($deadline_wc12_v2);
                    $deadline_wc11_v1 = Carbon::parse($deadline_wc12)->subWeekdays($hari_sup_mat_con_fa);
                    $deadline_wc11_v2 = $deadline_wc11_v1->format('Y-m-d');
                    $deadline_wc11 = reduceIfHoliday($deadline_wc11_v2);
                    $deadline_wc10_v1 = Carbon::parse($deadline_wc11)->subWeekdays($hari_susun_core);
                    $deadline_wc10_v2 = $deadline_wc10_v1->format('Y-m-d');
                    $deadline_wc10 = reduceIfHoliday($deadline_wc10_v2);
                    $deadline_wc9_v1 = Carbon::parse($deadline_wc11)->subWeekdays($hari_moulding);
                    $deadline_wc9_v2 = $deadline_wc9_v1->format('Y-m-d');
                    $deadline_wc9 = reduceIfHoliday($deadline_wc9_v2);
                    $deadline_wc8_v1 = Carbon::parse($deadline_wc10)->subWeekdays($hari_sup_fix_core);
                    $deadline_wc8_v2 = $deadline_wc8_v1->format('Y-m-d');
                    $deadline_wc8 = reduceIfHoliday($deadline_wc8_v2);
                    $deadline_wc7_v1 = Carbon::parse($deadline_wc8)->subWeekdays($hari_core);
                    $deadline_wc7_v2 = $deadline_wc7_v1->format('Y-m-d');
                    $deadline_wc7 = reduceIfHoliday($deadline_wc7_v2);
                    $deadline_wc4_v1 = Carbon::parse($deadline_wc9)->subWeekdays($hari_sup_mat_moulding);
                    $deadline_wc4_v2 = $deadline_wc4_v1->format('Y-m-d');
                    $deadline_wc4 = reduceIfHoliday($deadline_wc4_v2);
                    $deadline_wc6_v1 = Carbon::parse($deadline_wc4)->subWeekdays($hari_coil_hv);
                    $deadline_wc6_v2 = $deadline_wc6_v1->format('Y-m-d');
                    $deadline_wc6 = reduceIfHoliday($deadline_wc6_v2);
                    $deadline_wc5_v1 = Carbon::parse($deadline_wc6)->subWeekdays($hari_coil_lv);
                    $deadline_wc5_v2 = $deadline_wc5_v1->format('Y-m-d');
                    $deadline_wc5 = reduceIfHoliday($deadline_wc5_v2);
                    $deadline_wc3_v1 = Carbon::parse($deadline_wc5)->subWeekdays($hari_sup_mat_ins_coil);
                    $deadline_wc3_v2 = $deadline_wc3_v1->format('Y-m-d');
                    $deadline_wc3 = reduceIfHoliday($deadline_wc3_v2);
                    $deadline_wc2_v1 = Carbon::parse($deadline_wc3)->subWeekdays($hari_ins_paper);
                    $deadline_wc2_v2 = $deadline_wc2_v1->format('Y-m-d');
                    $deadline_wc2 = reduceIfHoliday($deadline_wc2_v2);
                    $deadline_wc1_v1 = Carbon::parse($deadline_wc2)->subWeekdays($hari_bom);
                    $deadline_wc1_v2 = $deadline_wc1_v1->format('Y-m-d');
                    $deadline_wc1 = reduceIfHoliday($deadline_wc1_v2);

                    // dd($deadline_wc9_v1, $hari_moulding, $deadline_wc1, $deadline_wc2, $deadline_wc3, $deadline_wc5, $deadline_wc6, $deadline_wc4, $deadline_wc7, $deadline_wc8, $deadline_wc9, $deadline_wc10, $deadline_wc11, $deadline_wc12, $deadline_wc13, $deadline_wc14, $deadline_wc15);

                    $gpadrys = new GPADry();
                    $gpadrys->id_mps = $mps2['id'];
                    $gpadrys->id_wo = $mps2['id_wo'];  
                    $gpadrys->project = $mps2['project'];
                    $gpadrys->production_line = $mps2['production_line'];
                    $gpadrys->kva = $mps2['kva'];
                    $gpadrys->qty_trafo = $mps2['qty_trafo'];
                    if($drycastresin->accesories == 'LEM SPACER BLOCK/AIR GAP')
                    {
                        $gpadrys->keterangan = 'Tidak Menggunakan Finishing & FAN';
                    }
                    elseif($drycastresin->accesories == "FAN,LEM SPACER BLOCK/AIR GAP" && $drycastresin->wiring === null)
                    {
                        $gpadrys->keterangan = 'Final Menggunakan FAN';
                    }
                    elseif($drycastresin->wiring === "COMPLETE" && $drycastresin->others === "PEMBUATAN CU BAR,PEMBUATAN KONEKSI HV,FINISHING" && $drycastresin->accesories === "FAN,LEM SPACER BLOCK/AIR GAP")
                    {
                        $gpadrys->keterangan = 'Finishing menggunakan FAN';
                    }
                    elseif($drycastresin->accesories == "FAN,OLTC,LEM SPACER BLOCK/AIR GAP" && $drycastresin->wiring === "COMPLETE")
                    {
                        $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                    }

                    $gpadrys->deadline = $deadline;
                    $gpadrys->deadline_wc15 = $deadline_wc15;
                    $gpadrys->deadline_wc14 = $deadline_wc14;
                    $gpadrys->deadline_wc13 = $deadline_wc13;
                    $gpadrys->deadline_wc12 = $deadline_wc12;
                    $gpadrys->deadline_wc11 = $deadline_wc11;
                    $gpadrys->deadline_wc10 = $deadline_wc10;
                    $gpadrys->deadline_wc9 = $deadline_wc9;
                    $gpadrys->deadline_wc8 = $deadline_wc8;
                    $gpadrys->deadline_wc7 = $deadline_wc7;
                    $gpadrys->deadline_wc6 = $deadline_wc6;
                    $gpadrys->deadline_wc5 = $deadline_wc5;
                    $gpadrys->deadline_wc4 = $deadline_wc4;
                    $gpadrys->deadline_wc3 = $deadline_wc3;
                    $gpadrys->deadline_wc2 = $deadline_wc2;
                    $gpadrys->deadline_wc1 = $deadline_wc1;

                    $gpadrys->save();
                }   
            }
        }
        return redirect()->route('mps2-index')->with('success', 'Data berhasil disimpan.');
    }

    // private function reduceIfHoliday($date)
    // {
    //     $carbonDate = Carbon::parse($date);
        
    //     // Cek apakah tanggal adalah hari libur
    //     if (Holiday::whereDate('date', $carbonDate)->exists()) {
    //         // Kurangi 1 hari dari tanggal
    //         $carbonDate->subWeekdays();
            
    //         // // Jika tanggal setelah pengurangan masih hari libur, kurangi lagi
    //         // return $this->reduceIfHoliday($carbonDate->format('Y-m-d'));
    //     }
        
    //     return $carbonDate;
    // }
}