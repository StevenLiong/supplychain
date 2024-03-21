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
use App\Models\planner\WorkcenterDryType;
use App\Models\planner\LeadtimeNofinishings;
use App\Models\planner\LeadtimeWithfinishings;
use App\Models\planner\LeadtimeNofinishingfans;
use App\Models\planner\LeadtimeWithfinishingoltcs;

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

    public function store(Request $request){
        // Mendapatkan nilai id_wo dari formulir
        $id_wo = $request->input('id_wo');

        // Membuat format id_so dari id_wo
        $id_so = preg_replace('/(\D)(\d{1})(\d{2})(\d+)/', 'S$2/$3/$4', $id_wo);
        
        // Mencari nilai manhour_code dari tabel dry_cast_resin berdasarkan id_so dan kva
        $manhour_code = StandardizeWork::where('nomor_so', $id_so)
                                      ->where('ukuran_kapasitas', $request->input('kva'))
                                      ->value('kd_manhour');

        $id_standardizework = StandardizeWork::where('nomor_so', $id_so)
                                    ->where('ukuran_kapasitas', $request->input('kva'))
                                    ->value('id');

        // Dapatkan nilai qty_trafo dan deadline dari formulir
        $qty_trafo = $request->input('qty_trafo');
        $deadline = $request->input('deadline');
        
        // Periksa apakah kapasitas pada tanggal yang diinput sudah penuh atau tidak
        $kapasitasPenuh = KapasitasProduksi::where('tanggal', $deadline)
                                            ->where('Drytype', '<', $qty_trafo)
                                            ->exists();

        // Jika kapasitas sudah penuh, tampilkan pesan peringatan
        if ($kapasitasPenuh) {
            return redirect()->back()->with('error', 'Kapasitas pada tanggal yang diinput sudah penuh. Data tidak dapat disimpan.');
        }

        // Kurangi nilai qty_trafo dari kapasitas Drytype di tabel kapasitas_produksis berdasarkan deadline
        KapasitasProduksi::where('tanggal', $deadline)->decrement('Drytype', $qty_trafo);
        
        $mps2 = new Mps2();
        $mps2->id_wo = $id_wo;
        $mps2->id_so = $id_so;
        $mps2->production_line = $request->get('production_line');
        $mps2->project = $request->get('project');
        $mps2->deadline = $deadline;
        $mps2->kva = $request->get('kva');
        $mps2->qty_trafo = $qty_trafo;
        $mps2->kd_manhour = $manhour_code;
        $mps2->id_standardize_work = $id_standardizework;
        
        $mps2->save();

        $drycastresins = DryCastResin::where('kd_manhour', $manhour_code)->get();
        
        // ? Breakdown GPA & Work Center
        if($request->get('production_line') === 'Dry'){
            $workcenterDryTypes = WorkcenterDryType::all();
            $leadTimeNoFinishings = LeadtimeNofinishings::all();
            $leadTimeNoFinishingFans = LeadtimeNofinishingfans::all();
            $leadTimeWithFinishings = LeadtimeWithfinishings::all();
            $leadTimeWithFinishingOltcs = LeadtimeWithfinishingoltcs::all();

            foreach ($workcenterDryTypes as $workcenterDryType) {
                foreach ($drycastresins as $drycastresin) {
                    $gpadrys = new GPADry();
                    $gpadrys->id_wo = $mps2->id_wo;  
                    $gpadrys->project = $mps2->project;
                    $gpadrys->production_line = $mps2->production_line;
                    $gpadrys->kva = $mps2->kva;
                    $gpadrys->qty_trafo = $mps2->qty_trafo;
                    $adjustedStart = $request->get('deadline');
                    $adjustedDeadline = $request->get('deadline');
                    $gpadrys->nama_workcenter = $workcenterDryType->nama_workcenter;
                    $gpadrys->id_mps = $mps2->id;
                    $lv_windling = $drycastresin->hour_coil_lv + $drycastresin->hour_potong_leadwire + $drycastresin->hour_potong_isolasi;
                    $hv_windling = $drycastresin->hour_coil_hv;
                    $moulding = $drycastresin->hour_hv_moulding + $drycastresin->hour_lv_moulding + $drycastresin->hour_hv_casting + $drycastresin->hour_hv_demoulding + $drycastresin->hour_lv_bobbin + $drycastresin->hour_touch_up;
                    $susun_core = $drycastresin->hour_type_susun_core + $drycastresin->hour_potong_isolasi_fiber;
                    $connection_finalassembly = $drycastresin->hour_others;
                    $connection_finalassembly_fan = $drycastresin->hour_others + $drycastresin->hour_accesories;
                    $finishing = $drycastresin->hour_wiring + $drycastresin->hour_instal_housing + $drycastresin->hour_bongkar_housing + $drycastresin->hour_pembuatan_cu_link + $drycastresin->hour_accesories;
                    $tanpaoltc = 50;
                    $finishingnooltc = $tanpaoltc - ($drycastresin->hour_wiring + $drycastresin->hour_instal_housing + $drycastresin->hour_bongkar_housing + $drycastresin->hour_pembuatan_cu_link + $drycastresin->hour_accesories);
                    $finishingOltc = $drycastresin->hour_wiring + $drycastresin->hour_instal_housing + $drycastresin->hour_bongkar_housing + $drycastresin->hour_pembuatan_cu_link + $drycastresin->hour_accesories;
                    $qctest = $drycastresin->hour_qc_testing;

                    $hoursInDay = 8;
                    $daysToSubtractLV = $lv_windling / $hoursInDay;
                    $daysToSubtractHV = $hv_windling / $hoursInDay;
                    $daysToSubtractMoulding = $moulding / $hoursInDay;
                    $daysToSubtractSusunCore = $susun_core / $hoursInDay;
                    $daysToSubtractConnectionFinalassembly = $connection_finalassembly / $hoursInDay;
                    $daysToSubtractConnectionFinalassemblyFan = $connection_finalassembly_fan / $hoursInDay;
                    $daysToSubtractFinishing = $finishing / $hoursInDay;
                    $daysToSubtractFinishingNoOltc = $finishingnooltc / $hoursInDay;
                    $daysToSubtractFinishingOltc = $finishingOltc / $hoursInDay;
                    $daysToSubtractQcTesting = $qctest / $hoursInDay;
                    // dd($daysToSubtractFinishingOltc > 0);
                    // dd($gpadrys->kva >= 250 && $gpadrys->kva <= 4000);

                    // ! Menginisiasi breakdown GPA jika tidak menggunakan finishing
                    if($daysToSubtractFinishing == 0){
                        foreach ($leadTimeNoFinishings as $leadtimenofinishing){
                            if ($gpadrys->kva >= 800 && $gpadrys->kva <= 1600 && $leadtimenofinishing->kva == 800) {
                                if($workcenterDryType->nama_workcenter === 'Quality Control Transfer Gudang'){
                                    $adjustedStartTimestamp = strtotime($adjustedStart);
                                    $daysToSubtract = $leadtimenofinishing->jeda_QCTransfer; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
        
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
        
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
        
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    $adjustedDeadlineTimestamp = $request->get('deadline');
                                    
                                    // $adjustedDeadline2 = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartQCTransfer = $adjustedStart;
                                    $adjustedDeadlineQCTransfer = $adjustedDeadlineTimestamp;

                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartQCTransfer;
                                    $gpadrys->deadline = $adjustedDeadlineQCTransfer;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Quality Control'){
                                    $adjustedStartQC = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartQC);
                                    $daysToSubtract = $leadtimenofinishing->jeda_QC + $daysToSubtractQcTesting; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;

                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
        
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
        
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);

                                    $adjustedDeadlineQC = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineQC);
                                    $daysToSubtract = $leadtimenofinishing->jeda_QC_deadline + $daysToSubtractQcTesting;
                                    $countWorkDays2 = 0;

                                    while ($daysToSubtract > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
        
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays2++;
                                        }
                                    }
        
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartQC = $adjustedStart;
                                    $adjustedDeadlineQC = $adjustedDeadline;
        
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartQC;
                                    $gpadrys->deadline = $adjustedDeadlineQC;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Finishing'){
                                    $adjustedStartFinishing = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartFinishing);
                                    $daysToSubtract = $leadtimenofinishing->jeda_finishing + $daysToSubtractFinishing; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartFinishing = $adjustedStart;
                                    $adjustedDeadlineFinishing = $adjustedStart;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartFinishing;
                                    $gpadrys->deadline = $adjustedDeadlineFinishing;

                                    // Menyimpan kalimat keterangan
                                    $gpadrys->keterangan = 'Tidak Menggunakan Finishing & FAN';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Connection & Final Assembly'){
                                    $adjustedStartConnectionFinalassembly = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartConnectionFinalassembly);
                                    $daysToSubtract = $leadtimenofinishing->jeda_confa + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);

                                    $adjustedDeadlineConnectionFinalassembly = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineConnectionFinalassembly);
                                    $daysToSubtract = $leadtimenofinishing->jeda_confa_deadline + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartConnectionFinalassembly = $adjustedStart;
                                    $adjustedDeadlineConnectionFinalassembly = $adjustedDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartConnectionFinalassembly;
                                    $gpadrys->deadline = $adjustedDeadlineConnectionFinalassembly;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Material Connection & Final Assembly'){
                                    $adjustedStartSupplyConnectFinal = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartSupplyConnectFinal);
                                    $daysToSubtract = $leadtimenofinishing->jeda_supmatconfa + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartConnectFinal = $adjustedStart;
                                    $adjustedDeadlineConnectFinal = $adjustedStart;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartConnectFinal;
                                    $gpadrys->deadline = $adjustedDeadlineConnectFinal;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Susun Core'){
                                    $adjustedStartSusunCore = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartSusunCore);
                                    $daysToSubtract = $leadtimenofinishing->jeda_susuncore + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);

                                    $adjustedDeadlineSusunCore = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSusunCore);
                                    $daysToSubtract = $leadtimenofinishing->jeda_susuncore_deadline + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartSusunCore = $adjustedStart;
                                    $adjustedDeadlineSusunCore = $adjustedDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartSusunCore;
                                    $gpadrys->deadline = $adjustedDeadlineSusunCore;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Moulding'){
                                    $adjustedStartMoulding = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartMoulding);
                                    $daysToSubtract = $leadtimenofinishing->jeda_mould + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);

                                    $adjustedDeadlineMoulding = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineMoulding);
                                    $daysToSubtract = $leadtimenofinishing->jeda_mould_deadline + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartMoulding = $adjustedStart;
                                    $adjustedDeadlineMoulding = $adjustedDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartMoulding;
                                    $gpadrys->deadline = $adjustedDeadlineMoulding;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Fixing Parts & Core'){
                                    $adjustedStartSupplyFixingCore = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartSupplyFixingCore);
                                    $daysToSubtract = $leadtimenofinishing->jeda_supfixcore + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++; 
                                        }
                                    }
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartSupplyFixingCore = $adjustedStart;
                                    $adjustedDeadlineSupplyFixingCore = $adjustedStart;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartSupplyFixingCore;
                                    $gpadrys->deadline = $adjustedDeadlineSupplyFixingCore;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Core'){
                                    $adjustedStartCore = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartCore);
                                    $daysToSubtract = $leadtimenofinishing->jeda_core + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++; 
                                        }
                                    }
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartCore = $adjustedStart;
                                    $adjustedDeadlineCore = $adjustedStart;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartCore;
                                    $gpadrys->deadline = $adjustedDeadlineCore;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'HV Windling'){
                                    $adjustedStartHV = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartHV);
                                    $daysToSubtract = $leadtimenofinishing->jeda_hv + $daysToSubtractHV; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++; 
                                        }
                                    }
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);

                                    $adjustedDeadlineHV = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineHV);
                                    $daysToSubtract = $leadtimenofinishing->jeda_hv_deadline + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++; 
                                        }
                                    }
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);

                                    $adjustedDeadlineHV = $adjustedDeadline;
                                    $isHoliday = Holiday::where('date', $adjustedDeadlineHV)->exists();
                                    // dd($isHoliday);
                                    if ($isHoliday) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari lagi jika tanggal adalah hari libur
                                    }
                                    
                                    $adjustednewDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartHV = $adjustedStart;
                                    $adjustedDeadlineHV = $adjustednewDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartHV;
                                    $gpadrys->deadline = $adjustedDeadlineHV;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'LV Windling'){
                                    $adjustedStartLV = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartLV);
                                    $daysToSubtract = $leadtimenofinishing->jeda_lv + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) { 
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu) 
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) { 
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur 
                                            $countWorkDays++; 
                                        } 
                                    } 
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    $adjustedDeadlineLV = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineLV);
                                    $daysToSubtract = $leadtimenofinishing->jeda_lv_deadline + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++; 
                                        }
                                    }
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel 
                                    $adjustedStartLV = $adjustedStart; 
                                    $adjustedDeadlineLV = $adjustedDeadline; 
            
                                    // Simpan ke dalam objek GPADry 
                                    $gpadrys->start = $adjustedStartLV; 
                                    $gpadrys->deadline = $adjustedDeadlineLV; 
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Material Moulding'){
                                    $adjustedStartSupplyMoulding = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartSupplyMoulding);
                                    $daysToSubtract = $leadtimenofinishing->jeda_supmatmould + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartSupplyMoulding= $adjustedStart;
                                    $adjustedDeadlineSupplyMoulding= $adjustedStart;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartSupplyMoulding;
                                    $gpadrys->deadline = $adjustedDeadlineSupplyMoulding;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Material Insulation & Coil'){
                                    $adjustedStartSupplyInsulationCoil = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartSupplyInsulationCoil);
                                    $daysToSubtract = $leadtimenofinishing->jeda_supmatinscoil + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) { 
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu) 
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) { 
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur 
                                            $countWorkDays++; 
                                        } 
                                    } 
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp); 
                                    
                                    // Simpan Start yang telah disesuaikan ke dalam variabel 
                                    $adjustedStartSupplyInsulationCoil = $adjustedStart; 
                                    $adjustedDeadlineSupplyInsulationCoil = $adjustedStart; 
            
                                    // Simpan ke dalam objek GPADry 
                                    $gpadrys->start = $adjustedStartSupplyInsulationCoil;
                                    $gpadrys->deadline = $adjustedDeadlineSupplyInsulationCoil;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Insulation Paper'){
                                    $adjustedStartInsPaper = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartInsPaper);
                                    $daysToSubtract = $leadtimenofinishing->jeda_inspaper + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) { 
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu) 
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) { 
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur 
                                            $countWorkDays++; 
                                        } 
                                    } 
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    $adjustedDeadlineInsPaper = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineInsPaper);
                                    $daysToSubtract = $leadtimenofinishing->jeda_supmatinscoil + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) { 
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu) 
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) { 
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur 
                                            $countWorkDays++; 
                                        } 
                                    } 
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel 
                                    $adjustedStartInsPaper = $adjustedStart; 
                                    $adjustedDeadlineInsPaper = $adjustedDeadline; 
            
                                    // Simpan ke dalam objek GPADry 
                                    $gpadrys->start = $adjustedStartInsPaper;
                                    $gpadrys->deadline = $adjustedDeadlineInsPaper;
                                }
                            }
                        }
                    }
                    

                    // ! Menginisiasi breakdown GPA jika menggunakan finishing
                    else if ($daysToSubtractFinishingOltc > 0){
                        foreach($leadTimeWithFinishingOltcs as $leadtimewithfinishingoltc){
                            if($gpadrys->kva >= 250 && $gpadrys->kva <= 4000){
                                if($workcenterDryType->nama_workcenter === 'Quality Control Transfer Gudang'){
                                    $adjustedStartTimestamp = strtotime($adjustedStart);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_QCTransfer; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
        
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
        
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
        
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);

                                    $adjustedDeadlineTimestamp = $request->get('deadline');
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartQCTransfer = $adjustedStart;
                                    $adjustedDeadlineQCTransfer = $adjustedDeadlineTimestamp;
        
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartQCTransfer;
                                    $gpadrys->deadline = $adjustedDeadlineQCTransfer;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
								elseif($workcenterDryType->nama_workcenter === 'Quality Control'){
                                    $adjustedStartQC = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartQC);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_QC + $daysToSubtractQcTesting; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;

                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
        
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
        
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);

                                    $adjustedDeadlineQC = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineQC);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_QC_deadline + $daysToSubtractQcTesting;
                                    $countWorkDays2 = 0;

                                    while ($daysToSubtract > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
        
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays2++;
                                        }
                                    }
        
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartQC = $adjustedStart;
                                    $adjustedDeadlineQC = $adjustedDeadline;
        
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartQC;
                                    $gpadrys->deadline = $adjustedDeadlineQC;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Finishing'){
                                    $adjustedStartFinishing = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartFinishing);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_finishing + $daysToSubtractFinishingOltc; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;

                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
        
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
        
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);

                                    $adjustedDeadlineFinishing = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineFinishing);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_finishing_deadline + $daysToSubtractFinishingOltc;
                                    $countWorkDays2 = 0;

                                    while ($daysToSubtract > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
        
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays2++;
                                        }
                                    }
        
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartFinishing = $adjustedStart;
                                    $adjustedDeadlineFinishing = $adjustedDeadline;
        
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartFinishing;
                                    $gpadrys->deadline = $adjustedDeadlineFinishing;

                                    // Menyimpan kalimat keterangan
                                    $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Connection & Final Assembly'){
                                    $adjustedStartConnectionFinalassembly = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartConnectionFinalassembly);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_confa + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);

                                    $adjustedDeadlineConnectionFinalassembly = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineConnectionFinalassembly);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_confa_deadline + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartConnectionFinalassembly = $adjustedStart;
                                    $adjustedDeadlineConnectionFinalassembly = $adjustedDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartConnectionFinalassembly;
                                    $gpadrys->deadline = $adjustedDeadlineConnectionFinalassembly;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Material Connection & Final Assembly'){
                                    $adjustedStartSupplyConnectFinal = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartSupplyConnectFinal);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_supmatconfa + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartSupplyConnectFinal = $adjustedStart;
                                    $adjustedDeadlineSupplyConnectFinal = $adjustedStart;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartSupplyConnectFinal;
                                    $gpadrys->deadline = $adjustedDeadlineSupplyConnectFinal;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Susun Core'){
                                    $adjustedStartSusunCore = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartSusunCore);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_susuncore + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartSusunCore = $adjustedStart;
                                    $isHoliday = Holiday::where('date', $adjustedStartSusunCore)->exists();
                                    // dd($isHoliday);
                                    if ($isHoliday) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari lagi jika tanggal adalah hari libur
                                    }
                                    
                                    $adjustednewStart = date('Y-m-d', $adjustedStartTimestamp);

                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustednewStart;

                                    $adjustedDeadlineSusunCore = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSusunCore);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_susuncore_deadline + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedDeadlineSusunCore = $adjustedDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->deadline = $adjustedDeadlineSusunCore;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Moulding'){
                                    $adjustedStartMoulding = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartMoulding);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_mould + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);

                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartMoulding = $adjustedStart;
                                    $isHoliday = Holiday::where('date', $adjustedStartMoulding)->exists();
                                    // dd($isHoliday);
                                    if ($isHoliday) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari lagi jika tanggal adalah hari libur
                                        $adjustednewStart = date('Y-m-d', $adjustedStartTimestamp);
                                        // Simpan ke dalam objek GPADry
                                        $gpadrys->start = $adjustednewStart;
                                    }
                                    else{
                                        $gpadrys->start = $adjustedStartMoulding;
                                    }
                                    $adjustedDeadlineMoulding = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineMoulding);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_mould_deadline + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartMoulding = $adjustedStart;
                                    $adjustedDeadlineMoulding = $adjustedDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartMoulding;
                                    $gpadrys->deadline = $adjustedDeadlineMoulding;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Fixing Parts & Core'){
                                    $adjustedStartSupplyFixingCore = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartSupplyFixingCore);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_supfixcore + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++; 
                                        }
                                    }
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartSupplyFixingCore = $adjustedStart;
                                    $adjustedDeadlineSupplyFixingCore = $adjustedStart;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartSupplyFixingCore;
                                    $gpadrys->deadline = $adjustedDeadlineSupplyFixingCore;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Core'){
                                    $adjustedStartCore = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartCore);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_core + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++; 
                                        }
                                    }
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);

                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartCore = $adjustedStart;
                                    $isHoliday = Holiday::where('date', $adjustedStartCore)->exists();
                                    // dd($isHoliday);
                                    if ($isHoliday) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari lagi jika tanggal adalah hari libur
                                        $adjustednewStart1 = date('Y-m-d', $adjustedStartTimestamp);
                                        $isHoliday1 = Holiday::where('date', $adjustednewStart1)->exists();
                                        if($isHoliday1){
                                            $adjustedStartTimestamp -= 24 * 60 * 60;
                                            $adjustednewStart = date('Y-m-d', $adjustedStartTimestamp);
                                            // Simpan ke dalam objek GPADry
                                            $gpadrys->start = $adjustednewStart;
                                            $gpadrys->deadline = $adjustednewStart;
                                        }
                                        else{
                                            $gpadrys->start = $adjustedStartCore;
                                            $gpadrys->deadline = $adjustedStartCore;
                                        }
                                    }
                                }
                                elseif($workcenterDryType->nama_workcenter === 'HV Windling'){
                                    $adjustedStartHV = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartHV);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_hv + $daysToSubtractHV; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++; 
                                        }
                                    }
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);

                                    $adjustedDeadlineHV = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineHV);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_hv_deadline + $daysToSubtractHV; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++; 
                                        }
                                    }
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);

                                    $adjustedDeadlineHV = $adjustedDeadline;
                                    $isHoliday = Holiday::where('date', $adjustedDeadlineHV)->exists();
                                    // dd($isHoliday);
                                    if ($isHoliday) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari lagi jika tanggal adalah hari libur
                                    }
                                    
                                    $adjustednewDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartHV = $adjustedStart;
                                    $adjustedDeadlineHV = $adjustednewDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartHV;
                                    $gpadrys->deadline = $adjustedDeadlineHV;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'LV Windling'){
                                    $adjustedStartLV = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartLV);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_lv + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) { 
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu) 
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) { 
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur 
                                            $countWorkDays++; 
                                        } 
                                    } 
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    $adjustedDeadlineLV = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineLV);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_lv_deadline + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++; 
                                        }
                                    }
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel 
                                    $adjustedStartLV = $adjustedStart; 
                                    $adjustedDeadlineLV = $adjustedDeadline; 
            
                                    // Simpan ke dalam objek GPADry 
                                    $gpadrys->start = $adjustedStartLV; 
                                    $gpadrys->deadline = $adjustedDeadlineLV;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Material Moulding'){
                                    $adjustedStartSupplyMoulding = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartSupplyMoulding);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_supmatmould + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay < 6) {
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur
                                            $countWorkDays++;
                                        }
                                    }
            
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartSupplyMoulding = $adjustedStart;
                                    $isHoliday = Holiday::where('date', $adjustedStartSupplyMoulding)->exists();
                                    // dd($isHoliday);
                                    if ($isHoliday) {
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari lagi jika tanggal adalah hari libur
                                        $adjustednewStart1 = date('Y-m-d', $adjustedStartTimestamp);
                                        $isHoliday1 = Holiday::where('date', $adjustednewStart1)->exists();
                                        if($isHoliday1){
                                            $adjustedStartTimestamp -= 24 * 60 * 60;
                                            $adjustednewStart = date('Y-m-d', $adjustedStartTimestamp);
                                            // Simpan ke dalam objek GPADry
                                            $gpadrys->start = $adjustednewStart;
                                            $gpadrys->deadline = $adjustednewStart;
                                        }
                                        else{
                                            $gpadrys->start = $adjustednewStart1;
                                            $gpadrys->deadline = $adjustednewStart1;
                                        }
                                    }
                                    else{
                                        $gpadrys->start = $adjustedStartSupplyMoulding;
                                        $gpadrys->deadline = $adjustedStartSupplyMoulding;
                                    }
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Material Insulation & Coil'){
                                    $adjustedStartSupplyInsulationCoil = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartSupplyInsulationCoil);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_supmatinscoil + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) { 
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu) 
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) { 
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur 
                                            $countWorkDays++; 
                                        } 
                                    } 
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp); 
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel
                                    $adjustedStartSupplyInsulationCoil = $adjustedStart; 
                                    $adjustedDeadlineSupplyInsulationCoil = $adjustedStart; 
            
                                    // Simpan ke dalam objek GPADry 
                                    $gpadrys->start = $adjustedStartSupplyInsulationCoil;
                                    $gpadrys->deadline = $adjustedDeadlineSupplyInsulationCoil;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Insulation Paper'){
                                    $adjustedStartInsPaper = $request->get('deadline');
                                    $adjustedStartTimestamp = strtotime($adjustedStartInsPaper);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_inspaper + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) { 
                                        $adjustedStartTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedStartTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu) 
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) { 
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur 
                                            $countWorkDays++; 
                                        } 
                                    } 
                                    $adjustedStart = date('Y-m-d', $adjustedStartTimestamp);
                                    
                                    $adjustedDeadlineInsPaper = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineInsPaper);
                                    $daysToSubtract = 35 + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
                                    $countWorkDays = 0;
                                    while ($daysToSubtract > 0) { 
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu) 
            
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu) 
                                        if ($currentDay < 6) { 
                                            $daysToSubtract--; // Kurangi hari jika bukan hari libur 
                                            $countWorkDays++; 
                                        } 
                                    } 
                                    $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan deadline yang telah disesuaikan ke dalam variabel 
                                    $adjustedStartInsPaper = $adjustedStart; 
                                    $adjustedDeadlineInsPaper = $adjustedDeadline; 
            
                                    // Simpan ke dalam objek GPADry 
                                    $gpadrys->start = $adjustedStartInsPaper;
                                    $gpadrys->deadline = $adjustedDeadlineInsPaper;
								}

                            }
                            
                        }
                    }
                }
                $gpadrys->save();
            }
        }

        // Validasi input untuk memastikan tidak ada input yang kosong
        $request->validate([
            'id_wo' => 'required', // Pastikan work_order tidak kosong
        ]);
    
        // Ambil semua input yang dikirimkan dari formulir
        $inputs = $request->all();

        // Inisialisasi array untuk menyimpan data yang akan disimpan
        $mps2 = [];
        // dd($mps2);
    
        // Ambil tanggal dari header
        $tanggalHeaders = KapasitasProduksi::pluck('tanggal')->toArray();
        
        // Loop melalui input untuk menyimpan data ke dalam tabel mps2s
        foreach ($inputs as $key => $value) {
            // Periksa apakah kunci input berisi "jan_"
            if (strpos($key, 'jan_') !== false && $value !== null) {
                // Dapatkan hari dan bulan dari kunci input
                $dayMonth = substr($key, 4); // Menghapus "jan_" dari kunci input
                $day = substr($dayMonth, 0, 2); // Ambil 2 karakter pertama untuk hari
                $month = substr($dayMonth, 2); // Ambil sisa karakter untuk bulan
                
                // Buat tanggal dari hari dan bulan
                $tanggal = Carbon::createFromDate(null, $month, $day); // Tahun diabaikan untuk pembuatan objek Carbon
        
                // Simpan data ke dalam model Mps2
                Mps2::create([
                    'id_wo' => $inputs['id_wo'],
                    'line' => $inputs['line'], // Ambil nilai line dari input
                    'project' => $inputs['project'], // Ambil nilai project dari input
                    'kva' => $inputs['kva'], // Ambil nilai kva dari input
                    'qty_trafo' => $value, // Simpan nilai input sebagai qty_trafo
                    'deadline' => $tanggal, // Simpan tanggal sesuai dengan header sebagai deadline
                    'manhour_code' => $manhour_code, // Simpan nilai manhour_code yang sudah ditemukan
                ]);
            }
        }

        // Simpan semua data dalam satu operasi ke database
        Mps2::insert($mps2);
    
        // Redirect ke halaman yang sesuai dan beri pesan sukses
        return redirect()->route('mps2-index')->with('success', 'Data berhasil disimpan.');
    }
    
}