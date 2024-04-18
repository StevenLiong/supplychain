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
        $startDate = Carbon::create(2024, 3, 1); // Tanggal awal yang Anda inginkan
        $endDate = Carbon::create(2024, 4, 30); // Tanggal akhir yang Anda inginkan
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

        for ($j = 0; $j < count($inputs['id_wo']); $j++) {
            $id_wo = $inputs['id_wo'][$j];
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
                    // dd($deadline);
                    $deadline_awal = Carbon::parse($deadline)->subWeekdays($total_hari);
                    // dd($deadline_awal);

                    $deadline_wc1 = $deadline_awal;
                    $deadline_wc2 = $deadline_wc1->copy()->addWeekdays($hari_ins_paper);
                    $deadline_wc3 = $deadline_wc2->copy()->addWeekdays($hari_sup_mat_ins_coil);
                    $deadline_wc5 = $deadline_wc3->copy()->addWeekdays($hari_coil_lv);
                    $deadline_wc6 = $deadline_wc5->copy()->addWeekdays($hari_coil_hv);
                    $deadline_wc7 = $deadline_wc5->copy()->addWeekdays($hari_core);
                    $deadline_wc4 = $deadline_wc6->copy()->addWeekdays($hari_sup_mat_moulding);
                    $deadline_wc8 = $deadline_wc7->copy()->addWeekdays($hari_sup_fix_core);
                    $deadline_wc9 = $deadline_wc6->copy()->addWeekdays($hari_moulding);
                    $deadline_wc10 = $deadline_wc8->copy()->addWeekdays($hari_susun_core);
                    $deadline_wc11 = $deadline_wc9->copy()->addWeekdays($hari_sup_mat_con_fa);
                    $deadline_wc12 = $deadline_wc11->copy()->addWeekdays($hari_connection_finalassembly);
                    $deadline_wc13 = $deadline_wc12->copy()->addWeekdays($hari_finishing);
                    $deadline_wc14 = $deadline_wc13->copy()->addWeekdays($hari_qc);
                    $deadline_wc15 = $deadline_wc14->copy()->addWeekdays($hari_qc_tran_gudang);

                    // $deadline_wc1 = $deadline_awal;
                    // // dd($deadline_wc1);
                    // $deadline_wc2 = Carbon::parse($deadline_wc1)->addDays($hari_ins_paper);
                    // // dd($deadline_wc2);
                    // $deadline_wc3 = Carbon::parse($deadline_wc2)->addDays($hari_sup_mat_ins_coil);
                    // // dd($deadline_wc3);
                    // $deadline_wc5 = Carbon::parse($deadline_wc3)->addDays($hari_coil_lv);
                    // // dd($deadline_wc5);
                    // $deadline_wc6 = Carbon::parse($deadline_wc5)->addDays($hari_coil_hv);
                    // // dd($deadline_wc6);
                    // $deadline_wc7 = Carbon::parse($deadline_wc5)->addDays($hari_core);
                    // // dd($deadline_wc7);
                    // $deadline_wc4 = Carbon::parse($deadline_wc6)->addDays($hari_sup_mat_moulding);
                    // // dd($deadline_wc4);
                    // $deadline_wc8 = Carbon::parse($deadline_wc7)->addDays($hari_sup_fix_core);
                    // // dd($deadline_wc8);
                    // $deadline_wc9 = Carbon::parse($deadline_wc6)->addDays($hari_moulding);
                    // // dd($deadline_wc9);
                    // $deadline_wc10 = Carbon::parse($deadline_wc8)->addDays($hari_susun_core);
                    // // dd($deadline_wc10);
                    // $deadline_wc11 = Carbon::parse($deadline_wc10)->addDays($hari_sup_mat_con_fa);
                    // // dd($deadline_wc11);
                    // $deadline_wc12 = Carbon::parse($deadline_wc11)->addDays($hari_connection_finalassembly);
                    // // dd($deadline_wc12);
                    // $deadline_wc13 = Carbon::parse($deadline_wc12)->addDays($hari_finishing);
                    // // dd($deadline_wc13);
                    // $deadline_wc14 = Carbon::parse($deadline_wc13)->addDays($hari_qc);
                    // // dd($deadline_wc14);
                    // $deadline_wc15 = Carbon::parse($deadline_wc14)->addDays($hari_qc_tran_gudang);

                    $gpadrys = new GPADry();
                    $gpadrys->id_mps = $mps2['id'];
                    $gpadrys->id_wo = $mps2['id_wo'];  
                    $gpadrys->project = $mps2['project'];
                    $gpadrys->production_line = $mps2['production_line'];
                    $gpadrys->kva = $mps2['kva'];
                    $gpadrys->qty_trafo = $mps2['qty_trafo'];
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
}