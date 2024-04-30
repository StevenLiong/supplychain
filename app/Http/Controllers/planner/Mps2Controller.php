<?php

namespace App\Http\Controllers\planner;

use Carbon\Carbon;
use App\Models\planner\Mps2;
use Illuminate\Http\Request;
use App\Models\planner\GPADry;
use App\Models\planner\GPAOil;
use App\Models\planner\Holiday;
use App\Http\Controllers\Controller;
use App\Models\produksi\OilStandard;
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
        // dd($kvas);
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

        function addIfHoliday($date) {
            while (Holiday::whereDate('date', $date)->exists()) {
                $date = Carbon::parse($date)->addWeekdays()->format('Y-m-d');
            }
            return $date;
        }

        for ($j = 0; $j < count($inputs['id_wo']); $j++) {
            $id_wo = $inputs['id_wo'][$j];
            // $cekidwo = GPADry::where('id_wo', $id_wo)->first();
            // // Validasi jika id_wo sudah ada
            // if ($cekidwo) {
            //     return redirect()->back()->with('error', 'WO sudah disubmit sebelumnya.');
            // }
            $id_so = preg_replace('/(\D)(\d{1})(\d{2})(\d+)/', 'S$2/$3/$4', $id_wo);
            // dd($id_so);

            if (!empty($inputs['id_wo'][$j])) {
                $kd_manhour = StandardizeWork::where('nomor_so', $id_so)
                        ->where('ukuran_kapasitas', $kvas[$j])
                        ->value('kd_manhour');
                // dd($kd_manhour);

                if(!$kd_manhour)
                {
                    return redirect()->back()->with('error', 'Kode Manhour tidak ada.');
                }

                $id_standardizework = StandardizeWork::where('nomor_so', $id_so)
                        ->where('ukuran_kapasitas', $kvas[$j])
                        ->value('id');
                // dd($id_standardizework);

                $nama_product = StandardizeWork::where('nomor_so', $id_so)
                    ->where('ukuran_kapasitas', $kvas[$j])
                    ->value('nama_product');

                $cek_kd_manhour = Mps2::where('kd_manhour', $kd_manhour)->first();
                // Validasi jika kd_manhour sudah ada
                // if ($cek_kd_manhour) {
                //     return redirect()->back()->with('error', 'Kode Manhour sudah disubmit sebelumnya.');
                // }
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
                    'nama_product' => $nama_product
                    // 'id_standardize_work' => StandardizeWork::where('nomor_so', $id_so)
                    //     ->where('ukuran_kapasitas', $kvas[$j])
                    //     ->value('id'),
                ];
            }
            // dd($qty_trafos);
            if($inputs['production_line'][$j] === 'Dry'){
                $kapasitasProduksi = KapasitasProduksi::where('tanggal', $deadlines[$j])
                    ->whereRaw('Drytype < ?', [$qty_trafos[$j]])
                    ->doesntExist();
                    if (!$kapasitasProduksi) {
                        return redirect()->back()->with('error', 'Kapasitas pada tanggal yang diinput sudah penuh. Data tidak dapat disimpan.');
                    }
                KapasitasProduksi::where('tanggal', $deadlines[$j])->decrement('Drytype', (int)$qty_trafos[$j]);
            }
            elseif($inputs['production_line'][$j] === 'PL2'){
                $kapasitasProduksi = KapasitasProduksi::where('tanggal', $deadlines[$j])
                    ->whereRaw('PL2 < ?', [$qty_trafos[$j]])
                    ->doesntExist();
                    if (!$kapasitasProduksi) {
                        return redirect()->back()->with('error', 'Kapasitas pada tanggal yang diinput sudah penuh. Data tidak dapat disimpan.');
                    }
                KapasitasProduksi::where('tanggal', $deadlines[$j])->decrement('PL2', (int)$qty_trafos[$j]);
            }
            elseif($inputs['production_line'][$j] === 'PL3'){
                $kapasitasProduksi = KapasitasProduksi::where('tanggal', $deadlines[$j])
                    ->whereRaw('PL3 < ?', [$qty_trafos[$j]])
                    ->doesntExist();
                    if (!$kapasitasProduksi) {
                        return redirect()->back()->with('error', 'Kapasitas pada tanggal yang diinput sudah penuh. Data tidak dapat disimpan.');
                    }
                KapasitasProduksi::where('tanggal', $deadlines[$j])->decrement('PL3', (int)$qty_trafos[$j]);
            }
        }
        // dd($mps2Data);
        Mps2::insert($mps2Data);
        $data_mps2 = Mps2::all();
        // dd($data_mps2);

        foreach ($data_mps2 as $mps2) {
            $id_wo = $mps2['id_wo'];
            // dd($mps2);
            $cekidwo = GPADry::where('id_wo', $id_wo)->exists();

            if ($cekidwo) {
                continue;
            }
            $id_so = $mps2['id_so'];
            $production_line = $mps2['production_line'];
            $project = $mps2['project'];
            $deadline = $mps2['deadline'];
            $kva = $mps2['kva'];
            $qty_trafo = $mps2['qty_trafo'];
            $kd_manhour = $mps2['kd_manhour'];
            $id_standardize_work = $mps2['id_standardize_work'];
            // Mengambil instance StandardizeWork berdasarkan id
            $standardize_work = StandardizeWork::find($id_standardize_work);
            // Jika instance ditemukan, ambil nilai nama_product
            if ($standardize_work) {
                $nama_product = $standardize_work->nama_product;
            } else {
                // Jika instance tidak ditemukan, atur nilai nama_product menjadi null atau sesuai kebutuhan
                $nama_product = null;
            }
            // dd($nama_product === 'Dry Cast Resin');
            // dd($nama_product, $id_standardize_work);
            $drycastresins = DryCastResin::where('kd_manhour', $kd_manhour)->get();
            $oilstandards = OilStandard::where('kd_manhour', $kd_manhour)->get();

            if($production_line === 'Dry')
            {
                if($nama_product === 'Dry Cast Resin'){
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
                        
                        $start_wc15_v1 = $deadline_new->copy()->subWeekdays($hari_qc_tran_gudang);
                        $start_wc15_v2 = $start_wc15_v1->format('Y-m-d');
                        $start_wc15 = reduceIfHoliday($start_wc15_v2);
                        // dd($start_wc15);
                        $deadline_wc15_v1 = Carbon::parse($start_wc15)->addWeekdays($hari_qc_tran_gudang);
                        $deadline_wc15 = addIfHoliday($deadline_wc15_v1);
                        // dd($start_wc15, $deadline_wc15);
    
                        $start_wc14_v1 = Carbon::parse($start_wc15)->subWeekdays($hari_qc);
                        $start_wc14_v2 = $start_wc14_v1->format('Y-m-d');
                        $start_wc14 = reduceIfHoliday($start_wc14_v2);
                        $deadline_wc14_v1 = Carbon::parse($start_wc14)->addWeekdays($hari_qc);
                        $deadline_wc14 = addIfHoliday($deadline_wc14_v1);
                        // dd($start_wc14, $deadline_wc14);
    
                        $start_wc13_v1 = Carbon::parse($start_wc14)->subWeekdays($hari_finishing);
                        $start_wc13_v2 = $start_wc13_v1->format('Y-m-d');
                        $start_wc13 = reduceIfHoliday($start_wc13_v2);
                        $deadline_wc13_v1 = Carbon::parse($start_wc13)->addWeekdays($hari_finishing);
                        $deadline_wc13 = addIfHoliday($deadline_wc13_v1);
                        // dd($start_wc13, $deadline_wc13);
    
                        $start_wc12_v1 = Carbon::parse($start_wc13)->subWeekdays($hari_connection_finalassembly);
                        $start_wc12_v2 = $start_wc12_v1->format('Y-m-d');
                        $start_wc12 = reduceIfHoliday($start_wc12_v2);
                        $deadline_wc12_v1 = Carbon::parse($start_wc12)->addWeekdays($hari_connection_finalassembly);
                        $deadline_wc12 = addIfHoliday($deadline_wc12_v1);
                        // dd($start_wc12, $deadline_wc12);
    
                        $start_wc11_v1 = Carbon::parse($start_wc12)->subWeekdays($hari_sup_mat_con_fa);
                        $start_wc11_v2 = $start_wc11_v1->format('Y-m-d');
                        $start_wc11 = reduceIfHoliday($start_wc11_v2);
                        $deadline_wc11_v1 = Carbon::parse($start_wc11)->addWeekdays($hari_sup_mat_con_fa);
                        $deadline_wc11 = addIfHoliday($deadline_wc11_v1);
                        // dd($start_wc11, $deadline_wc11);
    
                        $start_wc10_v1 = Carbon::parse($start_wc11)->subWeekdays($hari_susun_core);
                        $start_wc10_v2 = $start_wc10_v1->format('Y-m-d');
                        $start_wc10 = reduceIfHoliday($start_wc10_v2);
                        $deadline_wc10_v1 = Carbon::parse($start_wc10)->addWeekdays($hari_susun_core);
                        $deadline_wc10 = addIfHoliday($deadline_wc10_v1);
                        // dd($start_wc10, $deadline_wc10);
    
                        $start_wc9_v1 = Carbon::parse($start_wc11)->subWeekdays($hari_moulding);
                        $start_wc9_v2 = $start_wc9_v1->format('Y-m-d');
                        $start_wc9 = reduceIfHoliday($start_wc9_v2);
                        $deadline_wc9_v1 = Carbon::parse($start_wc9)->addWeekdays($hari_moulding);
                        $deadline_wc9 = addIfHoliday($deadline_wc9_v1);
                        // dd($start_wc9, $deadline_wc9);
    
                        $start_wc8_v1 = Carbon::parse($start_wc10)->subWeekdays($hari_sup_fix_core);
                        $start_wc8_v2 = $start_wc8_v1->format('Y-m-d');
                        $start_wc8 = reduceIfHoliday($start_wc8_v2);
                        $deadline_wc8_v1 = Carbon::parse($start_wc8)->addWeekdays($hari_sup_fix_core);
                        $deadline_wc8 = addIfHoliday($deadline_wc8_v1);
                        // dd($start_wc8, $deadline_wc8);
    
                        $start_wc7_v1 = Carbon::parse($start_wc8)->subWeekdays($hari_core);
                        $start_wc7_v2 = $start_wc7_v1->format('Y-m-d');
                        $start_wc7 = reduceIfHoliday($start_wc7_v2);
                        $deadline_wc7_v1 = Carbon::parse($start_wc7)->addWeekdays($hari_core);
                        $deadline_wc7 = addIfHoliday($deadline_wc7_v1);
                        // dd($start_wc7, $deadline_wc7);
    
                        $start_wc4_v1 = Carbon::parse($start_wc9)->subWeekdays($hari_sup_mat_moulding);
                        $start_wc4_v2 = $start_wc4_v1->format('Y-m-d');
                        $start_wc4 = reduceIfHoliday($start_wc4_v2);
                        $deadline_wc4_v1 = Carbon::parse($start_wc4)->addWeekdays($hari_sup_mat_moulding);
                        $deadline_wc4 = addIfHoliday($deadline_wc4_v1);
                        // dd($start_wc4, $deadline_wc4);
                        
                        $start_wc6_v1 = Carbon::parse($start_wc4)->subWeekdays($hari_coil_hv);
                        $start_wc6_v2 = $start_wc6_v1->format('Y-m-d');
                        $start_wc6 = reduceIfHoliday($start_wc6_v2);
                        $deadline_wc6_v1 = Carbon::parse($start_wc6)->addWeekdays($hari_coil_hv);
                        $deadline_wc6 = addIfHoliday($deadline_wc6_v1);
                        // dd($start_wc6, $deadline_wc6);
    
                        $start_wc5_v1 = Carbon::parse($start_wc6)->subWeekdays($hari_coil_lv);
                        $start_wc5_v2 = $start_wc5_v1->format('Y-m-d');
                        $start_wc5 = reduceIfHoliday($start_wc5_v2);
                        $deadline_wc5_v1 = Carbon::parse($start_wc5)->addWeekdays($hari_coil_lv);
                        $deadline_wc5 = addIfHoliday($deadline_wc5_v1);
                        // dd($start_wc5, $deadline_wc5);
    
                        $start_wc3_v1 = Carbon::parse($start_wc5)->subWeekdays($hari_sup_mat_ins_coil);
                        $start_wc3_v2 = $start_wc3_v1->format('Y-m-d');
                        $start_wc3 = reduceIfHoliday($start_wc3_v2);
                        $deadline_wc3_v1 = Carbon::parse($start_wc3)->addWeekdays($hari_sup_mat_ins_coil);
                        $deadline_wc3 = addIfHoliday($deadline_wc3_v1);
                        // dd($start_wc3, $deadline_wc5);
    
                        $start_wc2_v1 = Carbon::parse($start_wc3)->subWeekdays($hari_ins_paper);
                        $start_wc2_v2 = $start_wc2_v1->format('Y-m-d');
                        $start_wc2 = reduceIfHoliday($start_wc2_v2);
                        $deadline_wc2_v1 = Carbon::parse($start_wc2)->addWeekdays($hari_ins_paper);
                        $deadline_wc2 = addIfHoliday($deadline_wc2_v1);
                        // dd($start_wc2, $deadline_wc2);
    
                        $start_wc1_v1 = Carbon::parse($start_wc2)->subWeekdays($hari_bom);
                        $start_wc1_v2 = $start_wc1_v1->format('Y-m-d');
                        $start_wc1 = reduceIfHoliday($start_wc1_v2);
                        $deadline_wc1_v1 = Carbon::parse($start_wc1)->addWeekdays($hari_bom);
                        $deadline_wc1 = addIfHoliday($deadline_wc1_v1);
                        // dd($start_wc1, $deadline_wc1);
    
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
                        $gpadrys->start_wc15 = $start_wc15;
                        $gpadrys->start_wc14 = $start_wc14;
                        $gpadrys->start_wc13 = $start_wc13;
                        $gpadrys->start_wc12 = $start_wc12;
                        $gpadrys->start_wc11 = $start_wc11;
                        $gpadrys->start_wc10 = $start_wc10;
                        $gpadrys->start_wc9 = $start_wc9;
                        $gpadrys->start_wc8 = $start_wc8;
                        $gpadrys->start_wc7 = $start_wc7;
                        $gpadrys->start_wc6 = $start_wc6;
                        $gpadrys->start_wc5 = $start_wc5;
                        $gpadrys->start_wc4 = $start_wc4;
                        $gpadrys->start_wc3 = $start_wc3;
                        $gpadrys->start_wc2 = $start_wc2;
                        $gpadrys->start_wc1 = $start_wc1;
    
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
            elseif($production_line === 'PL2'){
                foreach($oilstandards as $oilstandard){
                    // AMBIL DATA HOUR DARI STANDARDIZE WORK
                    $coil_lv = $oilstandard->hour_coil_lv;
                    $coil_hv = $oilstandard->hour_coil_hv;
                    $core_coil_assembly = $oilstandard->hour_core_coil_assembly;
                    $connect = $oilstandard->hour_connect;
                    $final_assembly = $oilstandard->hour_final_assembly; 
                    $qc = $oilstandard->hour_qc_testing;
                    $ins_paper = 8.00;
                    $sup_mat_paper_coil = 8.00;
                    $core_fixing_parts = 8.00;
                    $sup_stacking_core = 8.00;
                    $sup_mat_connect = 8.00;
                    $sup_tangki = 8.00;
                    $sup_mat_final_finishing = 8.00;
                    $oven = 8.00;
                    // finishing sama kayak final assembly
                    $qc_tran_gudang = 8.00;

                    // VARIABEL BARU UNTUK DIUBAH JADI HARI
                    $hari_ins_paper = ceil($ins_paper / 8);
                    $hari_sup_mat_paper_coil = ceil($sup_mat_paper_coil / 8);
                    $hari_core_fixing_parts = ceil($core_fixing_parts / 8);
                    $hari_sup_stacking_core = ceil($sup_stacking_core / 8);
                    $hari_lv_windling = ceil($coil_lv / 8);
                    $hari_hv_windling = ceil($coil_hv / 8);
                    $hari_core_coil_assembly = ceil($core_coil_assembly / 8);
                    $hari_sup_mat_connect = ceil($sup_mat_connect / 8);
                    $hari_connect = ceil($connect / 8);
                    $hari_sup_tangki = ceil($sup_tangki / 8);
                    $hari_sup_mat_final_finishing = ceil($sup_mat_final_finishing / 8);
                    $hari_oven = ceil($oven / 8);
                    $hari_final_assembly = ceil($final_assembly / 8);
                    $hari_qc_testing = ceil($qc / 8);
                    $hari_qc_tran_gudang = ceil($qc_tran_gudang / 8);

                    $total_hari = ceil(
                        $hari_ins_paper + $hari_sup_mat_paper_coil + $hari_core_fixing_parts + $hari_sup_stacking_core + $hari_lv_windling + $hari_hv_windling + $hari_core_coil_assembly + $hari_sup_mat_connect + $hari_connect + $hari_sup_tangki + $hari_sup_mat_final_finishing + $hari_oven + $hari_final_assembly + $hari_qc_testing + $hari_qc_tran_gudang
                    );

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

                    $start_wc16_v1 = $deadline_new->copy()->subWeekdays($hari_qc_tran_gudang);
                    $start_wc16_v2 = $start_wc16_v1->format('Y-m-d');
                    $start_wc16 = reduceIfHoliday($start_wc16_v2);
                    // dd($start_wc16);
                    $deadline_wc16_v1 = Carbon::parse($start_wc16)->addWeekdays($hari_qc_tran_gudang);
                    $deadline_wc16 = addIfHoliday($deadline_wc16_v1);
                    // dd($start_wc16, $deadline_wc16);

                    $start_wc15_v1 = Carbon::parse($start_wc16)->subWeekdays($hari_qc_testing);
                    $start_wc15_v2 = $start_wc15_v1->format('Y-m-d');
                    $start_wc15 = reduceIfHoliday($start_wc15_v2);
                    // dd($start_wc15);
                    $deadline_wc15_v1 = Carbon::parse($start_wc15)->addWeekdays($hari_qc_testing);
                    $deadline_wc15 = addIfHoliday($deadline_wc15_v1);
                    // dd($start_wc15, $deadline_wc15);

                    $start_wc14_v1 = Carbon::parse($start_wc15)->subWeekdays($hari_final_assembly);
                    $start_wc14_v2 = $start_wc14_v1->format('Y-m-d');
                    $start_wc14 = reduceIfHoliday($start_wc14_v2);
                    // dd($start_wc14);
                    $deadline_wc14_v1 = Carbon::parse($start_wc14)->addWeekdays($hari_final_assembly);
                    $deadline_wc14 = addIfHoliday($deadline_wc14_v1);
                    // dd($start_wc14, $deadline_wc14);

                    $start_wc13_v1 = Carbon::parse($start_wc15)->subWeekdays($hari_final_assembly);
                    $start_wc13_v2 = $start_wc13_v1->format('Y-m-d');
                    $start_wc13 = reduceIfHoliday($start_wc13_v2);
                    // dd($start_wc13);
                    $deadline_wc13_v1 = Carbon::parse($start_wc13)->addWeekdays($hari_final_assembly);
                    $deadline_wc13 = addIfHoliday($deadline_wc13_v1);
                    // dd($start_wc13, $deadline_wc13);

                    $start_wc11_v1 = Carbon::parse($start_wc13)->subWeekdays($hari_sup_mat_final_finishing);
                    $start_wc11_v2 = $start_wc11_v1->format('Y-m-d');
                    $start_wc11 = reduceIfHoliday($start_wc11_v2);
                    // dd($start_wc11);
                    $deadline_wc11_v1 = Carbon::parse($start_wc11)->addWeekdays($hari_sup_mat_final_finishing);
                    $deadline_wc11 = addIfHoliday($deadline_wc11_v1);
                    // dd($start_wc11, $deadline_wc11);

                    $start_wc10_v1 = Carbon::parse($start_wc11)->subWeekdays($hari_sup_tangki);
                    $start_wc10_v2 = $start_wc10_v1->format('Y-m-d');
                    $start_wc10 = reduceIfHoliday($start_wc10_v2);
                    // dd($start_wc10);
                    $deadline_wc10_v1 = Carbon::parse($start_wc10)->addWeekdays($hari_sup_tangki);
                    $deadline_wc10 = addIfHoliday($deadline_wc10_v1);
                    // dd($start_wc10, $deadline_wc10);

                    $start_wc12_v1 = Carbon::parse($start_wc13)->subWeekdays($hari_oven);
                    $start_wc12_v2 = $start_wc12_v1->format('Y-m-d');
                    $start_wc12 = reduceIfHoliday($start_wc12_v2);
                    // dd($start_wc12);
                    $deadline_wc12_v1 = Carbon::parse($start_wc12)->addWeekdays($hari_oven);
                    $deadline_wc12 = addIfHoliday($deadline_wc12_v1);
                    // dd($start_wc12, $deadline_wc12);

                    $start_wc9_v1 = Carbon::parse($start_wc12)->subWeekdays($hari_connect);
                    $start_wc9_v2 = $start_wc9_v1->format('Y-m-d');
                    $start_wc9 = reduceIfHoliday($start_wc9_v2);
                    // dd($start_wc9);
                    $deadline_wc9_v1 = Carbon::parse($start_wc9)->addWeekdays($hari_connect);
                    $deadline_wc9 = addIfHoliday($deadline_wc9_v1);
                    // dd($start_wc9, $deadline_wc9);

                    $start_wc7_v1 = Carbon::parse($start_wc9)->subWeekdays($hari_core_coil_assembly);
                    $start_wc7_v2 = $start_wc7_v1->format('Y-m-d');
                    $start_wc7 = reduceIfHoliday($start_wc7_v2);
                    // dd($start_wc7);
                    $deadline_wc7_v1 = Carbon::parse($start_wc7)->addWeekdays($hari_core_coil_assembly);
                    $deadline_wc7 = addIfHoliday($deadline_wc7_v1);
                    // dd($start_wc7, $deadline_wc7);
                    
                    $start_wc8_v1 = Carbon::parse($start_wc7)->subWeekdays($hari_sup_mat_connect);
                    $start_wc8_v2 = $start_wc8_v1->format('Y-m-d');
                    $start_wc8 = reduceIfHoliday($start_wc8_v2);
                    // dd($start_wc8);
                    $deadline_wc8_v1 = Carbon::parse($start_wc8)->addWeekdays($hari_sup_mat_connect);
                    $deadline_wc8 = addIfHoliday($deadline_wc8_v1);
                    // dd($start_wc8, $deadline_wc8);

                    $start_wc6_v1 = Carbon::parse($start_wc7)->subWeekdays($hari_hv_windling);
                    $start_wc6_v2 = $start_wc6_v1->format('Y-m-d');
                    $start_wc6 = reduceIfHoliday($start_wc6_v2);
                    // dd($start_wc6);
                    $deadline_wc6_v1 = Carbon::parse($start_wc6)->addWeekdays($hari_hv_windling);
                    $deadline_wc6 = addIfHoliday($deadline_wc6_v1);
                    // dd($start_wc6, $deadline_wc6);

                    $start_wc5_v1 = Carbon::parse($start_wc6)->subWeekdays($hari_lv_windling);
                    $start_wc5_v2 = $start_wc5_v1->format('Y-m-d');
                    $start_wc5 = reduceIfHoliday($start_wc5_v2);
                    // dd($start_wc5);
                    $deadline_wc5_v1 = Carbon::parse($start_wc5)->addWeekdays($hari_lv_windling);
                    $deadline_wc5 = addIfHoliday($deadline_wc5_v1);
                    // dd($start_wc5, $deadline_wc5);

                    $start_wc4_v1 = Carbon::parse($start_wc7)->subWeekdays($hari_sup_stacking_core);
                    $start_wc4_v2 = $start_wc4_v1->format('Y-m-d');
                    $start_wc4 = reduceIfHoliday($start_wc4_v2);
                    // dd($start_wc4);
                    $deadline_wc4_v1 = Carbon::parse($start_wc4)->addWeekdays($hari_sup_stacking_core);
                    $deadline_wc4 = addIfHoliday($deadline_wc4_v1);
                    // dd($start_wc4, $deadline_wc4);

                    $start_wc3_v1 = Carbon::parse($start_wc4)->subWeekdays($hari_core_fixing_parts);
                    $start_wc3_v2 = $start_wc3_v1->format('Y-m-d');
                    $start_wc3 = reduceIfHoliday($start_wc3_v2);
                    // dd($start_wc3);
                    $deadline_wc3_v1 = Carbon::parse($start_wc3)->addWeekdays($hari_core_fixing_parts);
                    $deadline_wc3 = addIfHoliday($deadline_wc3_v1);
                    // dd($start_wc3, $deadline_wc3);

                    $start_wc2_v1 = Carbon::parse($start_wc3)->subWeekdays($hari_sup_mat_paper_coil);
                    $start_wc2_v2 = $start_wc2_v1->format('Y-m-d');
                    $start_wc2 = reduceIfHoliday($start_wc2_v2);
                    // dd($start_wc2);
                    $deadline_wc2_v1 = Carbon::parse($start_wc2)->addWeekdays($hari_sup_mat_paper_coil);
                    $deadline_wc2 = addIfHoliday($deadline_wc2_v1);
                    // dd($start_wc2, $deadline_wc2);
                    
                    $start_wc1_v1 = Carbon::parse($start_wc2)->subWeekdays($hari_ins_paper);
                    $start_wc1_v2 = $start_wc1_v1->format('Y-m-d');
                    $start_wc1 = reduceIfHoliday($start_wc1_v2);
                    // dd($start_wc1);
                    $deadline_wc1_v1 = Carbon::parse($start_wc1)->addWeekdays($hari_ins_paper);
                    $deadline_wc1 = addIfHoliday($deadline_wc1_v1);
                    // dd($start_wc1, $deadline_wc1);
                    
                    $gpaoils = new GPAOil();
                    $gpaoils->id_mps = $mps2['id'];
                    $gpaoils->id_wo = $mps2['id_wo'];  
                    $gpaoils->project = $mps2['project'];
                    $gpaoils->production_line = $mps2['production_line'];
                    $gpaoils->kva = $mps2['kva'];
                    $gpaoils->qty_trafo = $mps2['qty_trafo'];
                    $gpaoils->deadline = $deadline;
                    $gpaoils->start_wc16 = $start_wc16;
                    $gpaoils->start_wc15 = $start_wc15;
                    $gpaoils->start_wc14 = $start_wc14;
                    $gpaoils->start_wc13 = $start_wc13;
                    $gpaoils->start_wc12 = $start_wc12;
                    $gpaoils->start_wc11 = $start_wc11;
                    $gpaoils->start_wc10 = $start_wc10;
                    $gpaoils->start_wc9 = $start_wc9;
                    $gpaoils->start_wc8 = $start_wc8;
                    $gpaoils->start_wc7 = $start_wc7;
                    $gpaoils->start_wc6 = $start_wc6;
                    $gpaoils->start_wc5 = $start_wc5;
                    $gpaoils->start_wc4 = $start_wc4;
                    $gpaoils->start_wc3 = $start_wc3;
                    $gpaoils->start_wc2 = $start_wc2;
                    $gpaoils->start_wc1 = $start_wc1;

                    $gpaoils->deadline_wc16 = $deadline_wc16;
                    $gpaoils->deadline_wc15 = $deadline_wc15;
                    $gpaoils->deadline_wc14 = $deadline_wc14;
                    $gpaoils->deadline_wc13 = $deadline_wc13;
                    $gpaoils->deadline_wc12 = $deadline_wc12;
                    $gpaoils->deadline_wc11 = $deadline_wc11;
                    $gpaoils->deadline_wc10 = $deadline_wc10;
                    $gpaoils->deadline_wc9 = $deadline_wc9;
                    $gpaoils->deadline_wc8 = $deadline_wc8;
                    $gpaoils->deadline_wc7 = $deadline_wc7;
                    $gpaoils->deadline_wc6 = $deadline_wc6;
                    $gpaoils->deadline_wc5 = $deadline_wc5;
                    $gpaoils->deadline_wc4 = $deadline_wc4;
                    $gpaoils->deadline_wc3 = $deadline_wc3;
                    $gpaoils->deadline_wc2 = $deadline_wc2;
                    $gpaoils->deadline_wc1 = $deadline_wc1;

                    $gpaoils->save();
                }
            }
        }
        return redirect()->route('mps2-index')->with('success', 'Data berhasil disimpan.');
    }
}