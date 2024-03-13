<?php

namespace App\Http\Controllers\planner;
use PDF;
use App\Exports\MpsExport;
use App\Exports\PdfExport;
use App\Models\planner\Wo;
use App\Models\planner\Mps;
use Illuminate\Http\Request;
use App\Models\planner\GPADry;
use App\Models\planner\GPAOil;
use App\Models\planner\Holiday;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\produksi\DryCastResin;
use Illuminate\Http\RedirectResponse;
use App\Models\produksi\StandardizeWork;
use Illuminate\Support\Facades\Redirect;
use App\Models\planner\KapasitasProduksi;
use App\Models\planner\WorkcenterDryType;
use App\Models\planner\WorkcenterOilTrafo;
use App\Models\planner\LeadtimeNofinishings;
use App\Models\planner\LeadtimeWithfinishings;
use Database\Seeders\WorkcenterOilTrafoSeeder;
use App\Models\planner\LeadtimeNofinishingfans;
use App\Models\planner\LeadtimeWithfinishingoltcs;

class MpsController extends Controller
{
    public function index()
    {
        $dataMps = Mps::all();
        return view('planner.mps.index', compact('dataMps'));
    }

    public function upload()
    {
        $dataWo = Wo::all(); // Mengambil nilai 'id_wo' dari tabel Wo
        return view('planner.MPS.upload-mps', ['dataWo' => $dataWo]);
    }

    public function getDataByIdWo($idWo)
    {
        // NARIK DATA WO 
        $datawo = Wo::where('id_wo', $idWo)->first();

        //jadiin array
        $data = [
            'qty_trafo' => $datawo->qty_trafo ?? null,
            'kva' => $datawo->kva ?? null,
        ];

        return response()->json($data);
    }

    public function getCapacityByDate(Request $request)
    {
        $selectedDate = $request->input('selected_date');
        $selectedProductionLine = $request->input('production_line');
        
        // Gunakan dynamic property untuk mengakses kolom sesuai dengan nama variabel
        $capacity = KapasitasProduksi::where('tanggal', $selectedDate)->value($selectedProductionLine);

        return response()->json(['capacity' => $capacity]);
    }

    public function store(Request $request)
    {
        //$dataWo = Wo::where('id_wo', $request->get('id_wo'))->first();
        // $dataWo = Wo::all();
        // session(['idWo' => $id_wo]);
        // $dryCastResin = DryCastResin::where('id_wo', $request->get('id_wo'))->first();
    
        // if($dryCastResin) {
        //     $manHourCode = $dryCastResin->man_hour_code; // Ambil Man Hour Code dari Dry Cast Resin
        //     // Kemudian isi field Man Hour Code di form
        //     return view('planner.mps.index', compact('dataMps'))->with('manHourCode', $manHourCode);
        // }
        $mps = new Mps();
        $id_wo = $request->get('id_wo');
        $mps->id_wo = $id_wo;
        
        $wo = Wo::where('id_wo', $id_wo)->first();
        if ($wo) {
            $mps->id_wo = $wo->id;
            // $wo->qty_trafo = $bom->qty_bom;
            $mps->qty_trafo = $wo->qty_trafo;
            $mps->kva = $wo->kva;
        }
        $mps->kd_manhour = $wo->id_standardize_work;
        $mps->project = $request->get('project');
        $mps->production_line = $request->get('production_line');
        $mps->jenis = $request->get('jenis');
        $mps->deadline = $request->get('deadline');
        
        // ! Kondisi untuk kapasitas Produksi Drytype, PL2, PL3
        $kapasitasProduksi = KapasitasProduksi::where('tanggal', $mps->deadline)->latest()->first();
        if ($kapasitasProduksi && $request->get('production_line') === 'Drytype'){
            if ($wo->qty_trafo > $kapasitasProduksi->Drytype || $kapasitasProduksi->Drytype == 0){
                return redirect()->back()->withInput()->withErrors(['error' => 'Kapasitas Dry Type Overload']);
            }
            else if ($wo->qty_trafo <= $kapasitasProduksi->Drytype){
                $qtyTrafo = $wo->qty_trafo;
                $kapasitasProduksi->tanggal = $mps->deadline;
                $kapasitasProduksi->Drytype -= $qtyTrafo;
                $kapasitasProduksi->PL2;
                $kapasitasProduksi->PL3;
                $kapasitasProduksi->save();
            }
        }
        else if ($kapasitasProduksi && $request->get('production_line') === 'PL2') {
            if ($wo->qty_trafo > $kapasitasProduksi->PL2 || $kapasitasProduksi->PL2 == 0){
                return redirect()->back()->withInput()->withErrors(['error' => 'Kapasitas PL2 Overload']);
            }
            else if ($wo->qty_trafo <= $kapasitasProduksi->PL2){
                $qtyTrafo = $wo->qty_trafo;
                $kapasitasProduksi->tanggal = $mps->deadline;
                $kapasitasProduksi->Drytype;
                $kapasitasProduksi->PL2 -= $qtyTrafo;
                $kapasitasProduksi->PL3;
                $kapasitasProduksi->save();
            }
        }
        else if ($kapasitasProduksi && $request->get('production_line') === 'PL3'){
            if ($wo->qty_trafo > $kapasitasProduksi->PL3 || $kapasitasProduksi->PL3 == 0){
                return redirect()->back()->withInput()->withErrors(['error' => 'Kapasitas PL3 Overload']);
            }
            else if ($wo->qty_trafo <= $kapasitasProduksi->PL3){
                $qtyTrafo = $wo->qty_trafo;
                $kapasitasProduksi->tanggal = $mps->deadline;
                $kapasitasProduksi->Drytype;
                $kapasitasProduksi->PL2;
                $kapasitasProduksi->PL3 -= $qtyTrafo;
                $kapasitasProduksi->save();
            }
        }

        $mps->save();
        
        // ? Breakdown GPA & Work Center
        if ($request->get('production_line') === 'Drytype') {
            $workcenterDryTypes = WorkcenterDryType::all();
            $drycastresin = $wo->standardize_work->dry_cast_resin;
            $leadTimeNoFinishings = LeadtimeNofinishings::all();
            $leadTimeNoFinishingFans = LeadtimeNofinishingfans::all();
            $leadTimeWithFinishings = LeadtimeWithfinishings::all();
            $leadTimeWithFinishingOltcs = LeadtimeWithfinishingoltcs::all();
            $holidays = Holiday::pluck('date')->toArray();
            // dd($leadTimeWithFinishingOltcs->id);

            foreach ($workcenterDryTypes as $workcenterDryType) {
                foreach ($drycastresin as $drycastresins) {
                    // dd($drycastresin);
                    $gpadrys = new GPADry();
                    $gpadrys->id_wo = $wo->id;  
                    $gpadrys->project = $request->get('project');
                    $gpadrys->production_line = $request->get('production_line');
                    $gpadrys->kva = $mps->kva;
                    $gpadrys->jenis = $request->get('jenis');
                    $gpadrys->qty_trafo = $mps->qty_trafo;
                    $adjustedStart = $request->get('deadline');
                    $adjustedDeadline = $request->get('deadline');
                    $gpadrys->nama_workcenter = $workcenterDryType->nama_workcenter;
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
                    // dd($drycastresin->accesories);
                    // dd($daysToSubtractFinishing);
                    // dd($daysToSubtractFinishing > 0);
                    // dd($daysToSubtractFinishingOltc);
                    // dd($drycastresin->accesories == "FAN");
                    // dd($daysToSubtractFinishingOltc > 0);
                    // dd($drycastresin->others === "FINISHING,LEM SPACER BLOCK/AIR GAP" && $drycastresin->accesories === "FAN,OLTC");
                    // dd($gpadrys->kva >= 250 && $gpadrys->kva <= 4000 && $leadTimeWithFinishingOltcs->kva == 800);
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
                                    $daysToSubtract2 = $leadtimenofinishing->jeda_QCTransfer;
                                    $countWorkDays2 = 0;

                                    while ($daysToSubtract2 > 0) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                                        $currentDay2 = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
        
                                        // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                                        if ($currentDay2 < 6) {
                                            $daysToSubtract2--; // Kurangi hari jika bukan hari libur
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

                                    $adjustedDeadlineFinishing = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineFinishing);
                                    $daysToSubtract = $leadtimenofinishing->jeda_QC + $daysToSubtractQcTesting; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedStartFinishing = $adjustedStart;
                                    $adjustedDeadlineFinishing = $adjustedDeadline;
            
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
                                    $daysToSubtract = $leadtimenofinishing->jeda_finishing + $daysToSubtractFinishing; // Jumlah hari yang akan dikurangkan
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
                                    $daysToSubtract = $leadtimenofinishing->jeda_supmatconfa + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                                    $daysToSubtract = $leadtimenofinishing->jeda_supmatconfa + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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

                                    $adjustedDeadlineSupplyFixingCore = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyFixingCore);
                                    $daysToSubtract = $leadtimenofinishing->jeda_mould + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedStartSupplyFixingCore = $adjustedStart;
                                    $adjustedDeadlineSupplyFixingCore = $adjustedDeadline;
            
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

                                    $adjustedDeadlineCore = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineCore);
                                    $daysToSubtract = $leadtimenofinishing->jeda_supfixcore + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedStartCore = $adjustedStart;
                                    $adjustedDeadlineCore = $adjustedDeadline;
            
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
                                    $daysToSubtract = $leadtimenofinishing->jeda_core + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedStartHV = $adjustedStart;
                                    $adjustedDeadlineHV = $adjustedDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->start = $adjustedStartHV;
                                    $gpadrys->deadline = $adjustedDeadlineHV;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'LV Windling'){
                                    $adjustedDeadlineLV = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineLV);
                                    $daysToSubtract = $leadtimenofinishing->jeda_lv + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineLV = $adjustedDeadline; 
            
                                    // Simpan ke dalam objek GPADry 
                                    $gpadrys->deadline = $adjustedDeadlineLV; 
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Material Moulding'){
                                    $adjustedDeadlineSupplyMoulding = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyMoulding);
                                    $daysToSubtract = $leadtimenofinishing->jeda_supmatmould + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineSupplyMoulding= $adjustedDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->deadline = $adjustedDeadlineSupplyMoulding;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Material Insulation & Coil'){
                                    $adjustedDeadlineSupplyInsulationCoil = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyInsulationCoil);
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
                                    $adjustedDeadlineSupplyInsulationCoil = $adjustedDeadline; 
            
                                    // Simpan ke dalam objek GPADry 
                                    $gpadrys->deadline = $adjustedDeadlineSupplyInsulationCoil;
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Insulation Paper'){
                                    $adjustedDeadlineInsPaper = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineInsPaper);
                                    $daysToSubtract = $leadtimenofinishing->jeda_inspaper + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineInsPaper = $adjustedDeadline; 
            
                                    // Simpan ke dalam objek GPADry 
                                    $gpadrys->deadline = $adjustedDeadlineInsPaper;
                                }
                            }
                        }
                    }

                    else if($daysToSubtractFinishing > 0){
                        // ! Menginisiasi breakdown GPA jika tidak menggunakan finishing tetapi menggunakan FAN
                        if($drycastresin->accesories == "FAN" && $drycastresin->wiring === null){
                            foreach ($leadTimeNoFinishingFans as $leadtimenofinishingfan){
                                    if ($gpadrys->kva >= 800 && $gpadrys->kva <= 1600 && $leadtimenofinishingfan->kva == 800) {
                                        if($workcenterDryType->nama_workcenter === 'Quality Control Transfer Gudang'){
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadline);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_QCTransfer; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineQCTransfer = $adjustedDeadline;
                
                                            // Simpan ke dalam objek GPADry
                                            $gpadrys->deadline = $adjustedDeadlineQCTransfer;
                                        }
                                        elseif($workcenterDryType->nama_workcenter === 'Quality Control'){
                                            $adjustedDeadlineQCTransfer = $request->get('deadline');
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineQCTransfer);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_QC + $daysToSubtractQcTesting; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineQC = $adjustedDeadline;
                
                                            // Simpan ke dalam objek GPADry
                                            $gpadrys->deadline = $adjustedDeadlineQC;
                                        }
                                        elseif($workcenterDryType->nama_workcenter === 'Finishing'){
                                            $adjustedDeadlineFinishing = $request->get('deadline');
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineFinishing);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_finishing + $daysToSubtractFinishing; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineFinishing = $adjustedDeadline;
                    
                                            // Simpan ke dalam objek GPADry
                                            $gpadrys->deadline = $adjustedDeadlineFinishing;
        
                                            // Menyimpan kalimat keterangan
                                            $gpadrys->keterangan = 'Final Menggunakan FAN';
                                        }
                                        elseif($workcenterDryType->nama_workcenter === 'Connection & Final Assembly'){
                                            $adjustedDeadlineConnectionFinalassemblyFan = $request->get('deadline');
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineConnectionFinalassemblyFan);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_confa + $daysToSubtractConnectionFinalassemblyFan; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineConnectionFinalassemblyFan = $adjustedDeadline;
                    
                                            // Simpan ke dalam objek GPADry
                                            $gpadrys->deadline = $adjustedDeadlineConnectionFinalassemblyFan;
                                        }
                                        elseif($workcenterDryType->nama_workcenter === 'Supply Material Connection & Final Assembly'){
                                            $adjustedDeadlineSupplyConnectFinal = $request->get('deadline');
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyConnectFinal);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_supmatconfa + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineConnectFinal = $adjustedDeadline;
                    
                                            // Simpan ke dalam objek GPADry
                                            $gpadrys->deadline = $adjustedDeadlineConnectFinal;
                                        }
                                        elseif($workcenterDryType->nama_workcenter === 'Susun Core'){
                                            $adjustedDeadlineSusunCore = $request->get('deadline');
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSusunCore);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_susuncore + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineMoulding = $request->get('deadline');
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineMoulding);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_mould + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineMoulding = $adjustedDeadline;
                    
                                            // Simpan ke dalam objek GPADry
                                            $gpadrys->deadline = $adjustedDeadlineMoulding;
                                        }
                                        elseif($workcenterDryType->nama_workcenter === 'Supply Fixing Parts & Core'){
                                            $adjustedDeadlineSupplyFixingCore = $request->get('deadline');
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyFixingCore);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_supfixcore + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineSupplyFixingCore = $adjustedDeadline;
                    
                                            // Simpan ke dalam objek GPADry
                                            $gpadrys->deadline = $adjustedDeadlineSupplyFixingCore;
                                        }
                                        elseif($workcenterDryType->nama_workcenter === 'Core'){
                                            $adjustedDeadlineCore = $request->get('deadline');
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineCore);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_core + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineCore = $adjustedDeadline;
                    
                                            // Simpan ke dalam objek GPADry
                                            $gpadrys->deadline = $adjustedDeadlineCore;
                                        }
                                        elseif($workcenterDryType->nama_workcenter === 'HV Windling'){
                                            $adjustedDeadlineHV = $request->get('deadline');
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineHV);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_hv + $daysToSubtractHV; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineHV = $adjustedDeadline;
                    
                                            // Simpan ke dalam objek GPADry
                                            $gpadrys->deadline = $adjustedDeadlineHV;
                                        }
                                        elseif($workcenterDryType->nama_workcenter === 'LV Windling'){
                                            $adjustedDeadlineLV = $request->get('deadline');
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineLV);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_lv + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineLV = $adjustedDeadline; 
                    
                                            // Simpan ke dalam objek GPADry 
                                            $gpadrys->deadline = $adjustedDeadlineLV; 
                                        }
                                        elseif($workcenterDryType->nama_workcenter === 'Supply Material Moulding'){
                                            $adjustedDeadlineSupplyMoulding = $request->get('deadline');
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyMoulding);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_supmatmould + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineSupplyMoulding= $adjustedDeadline;
                    
                                            // Simpan ke dalam objek GPADry
                                            $gpadrys->deadline = $adjustedDeadlineSupplyMoulding;
                                        }
                                        elseif($workcenterDryType->nama_workcenter === 'Supply Material Insulation & Coil'){
                                            $adjustedDeadlineSupplyInsulationCoil = $request->get('deadline');
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyInsulationCoil);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_supmatinscoil + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineSupplyInsulationCoil = $adjustedDeadline; 
                    
                                            // Simpan ke dalam objek GPADry 
                                            $gpadrys->deadline = $adjustedDeadlineSupplyInsulationCoil;
                                        }
                                        elseif($workcenterDryType->nama_workcenter === 'Insulation Paper'){
                                            $adjustedDeadlineInsPaper = $request->get('deadline');
                                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineInsPaper);
                                            $daysToSubtract = $leadtimenofinishingfan->jeda_inspaper + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                                            $adjustedDeadlineInsPaper = $adjustedDeadline; 
                    
                                            // Simpan ke dalam objek GPADry 
                                            $gpadrys->deadline = $adjustedDeadlineInsPaper;
                                        }
                                    }
                            }
                        }
                        // ! Menginisiasi breakdown GPA jika Menggunakan finishing Fan
                        else if($drycastresin->wiring === "COMPLETE" && $drycastresin->others === "FINISHING"){
                            foreach($leadTimeWithFinishings as $leadtimewithfinishing){
                                if ($gpadrys->kva >= 800 && $gpadrys->kva <= 1600 && $leadtimewithfinishing->kva == 800) {
                                    if($workcenterDryType->nama_workcenter === 'Quality Control Transfer Gudang'){
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadline);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_QCTransfer; // Jumlah hari yang akan dikurangkan
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
                                        $adjustedDeadlineQCTransfer = $adjustedDeadline;
            
                                        // Simpan ke dalam objek GPADry
                                        $gpadrys->deadline = $adjustedDeadlineQCTransfer;
                                        // dd($adjustedDeadlineQCTransfer);

                                        // Menyimpan kalimat keterangan
                                        // $gpadrys->keterangan = 'Finishing tidak menggunakan OLTC';
                                    }
                                    elseif($workcenterDryType->nama_workcenter === 'Quality Control'){
                                        $adjustedDeadlineQCTransfer = $request->get('deadline');
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineQCTransfer);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_QC + $daysToSubtractQcTesting; // Jumlah hari yang akan dikurangkan
                                        // dd($daysToSubtract);
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
                                        $adjustedDeadlineQC = $adjustedDeadline;
            
                                        // Simpan ke dalam objek GPADry
                                        $gpadrys->deadline = $adjustedDeadlineQC;

                                        // Menyimpan kalimat keterangan
                                        // $gpadrys->keterangan = 'Finishing tidak menggunakan OLTC';
                                    }
                                    elseif($workcenterDryType->nama_workcenter === 'Finishing'){
                                        $adjustedDeadlineFinishing = $request->get('deadline');
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineFinishing);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_finishing + $daysToSubtractFinishing; // Jumlah hari yang akan dikurangkan
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
                                        $adjustedDeadlineFinishing = $adjustedDeadline;
                
                                        // Simpan ke dalam objek GPADry
                                        $gpadrys->deadline = $adjustedDeadlineFinishing;

                                        // Menyimpan kalimat keterangan
                                        $gpadrys->keterangan = 'Finishing menggunakan FAN';
                                    }
                                    elseif($workcenterDryType->nama_workcenter === 'Connection & Final Assembly'){
                                        $adjustedDeadlineConnectFinal = $request->get('deadline');
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineConnectFinal);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_confa + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                                        $adjustedDeadlineConnectionFinalassembly = $adjustedDeadline;
                
                                        // Simpan ke dalam objek GPADry
                                        $gpadrys->deadline = $adjustedDeadlineConnectionFinalassembly;

                                        // Menyimpan kalimat keterangan
                                        // $gpadrys->keterangan = 'Finishing tidak menggunakan OLTC';
                                    }
                                    elseif($workcenterDryType->nama_workcenter === 'Supply Material Connection & Final Assembly'){
                                        $adjustedDeadlineSupplyConnectFinal = $request->get('deadline');
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyConnectFinal);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_supmatconfa + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                                        $adjustedDeadlineSupplyConnectFinal = $adjustedDeadline;
                
                                        // Simpan ke dalam objek GPADry
                                        $gpadrys->deadline = $adjustedDeadlineSupplyConnectFinal;

                                        // Menyimpan kalimat keterangan
                                        // $gpadrys->keterangan = 'Finishing tidak menggunakan OLTC';
                                    }
                                    elseif($workcenterDryType->nama_workcenter === 'Susun Core'){
                                        $adjustedDeadlineSusunCore = $request->get('deadline');
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSusunCore);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_susuncore + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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

                                        // Menyimpan kalimat keterangan
                                        // $gpadrys->keterangan = 'Finishing tidak menggunakan OLTC';
                                    }
                                    elseif($workcenterDryType->nama_workcenter === 'Moulding'){
                                        $adjustedDeadlineMoulding = $request->get('deadline');
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineMoulding);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_mould + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
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
                                        $adjustedDeadlineMoulding = $adjustedDeadline;
                
                                        // Simpan ke dalam objek GPADry
                                        $gpadrys->deadline = $adjustedDeadlineMoulding;

                                        // Menyimpan kalimat keterangan
                                        // $gpadrys->keterangan = 'Finishing tidak menggunakan OLTC';
                                    }
                                    elseif($workcenterDryType->nama_workcenter === 'Supply Fixing Parts & Core'){
                                        $adjustedDeadlineSupplyFixingCore = $request->get('deadline');
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyFixingCore);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_supfixcore + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                                        $adjustedDeadlineSupplyFixingCore = $adjustedDeadline;
                
                                        // Simpan ke dalam objek GPADry
                                        $gpadrys->deadline = $adjustedDeadlineSupplyFixingCore;

                                        // Menyimpan kalimat keterangan
                                        // $gpadrys->keterangan = 'Finishing tidak menggunakan OLTC';
                                    }
                                    elseif($workcenterDryType->nama_workcenter === 'Core'){
                                        $adjustedDeadlineCore = $request->get('deadline');
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineCore);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_core + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                                        $adjustedDeadlineCore = $adjustedDeadline;
                
                                        // Simpan ke dalam objek GPADry
                                        $gpadrys->deadline = $adjustedDeadlineCore;

                                        // Menyimpan kalimat keterangan
                                        // $gpadrys->keterangan = 'Finishing tidak menggunakan OLTC';
                                    }
                                    elseif($workcenterDryType->nama_workcenter === 'HV Windling'){
                                        $adjustedDeadlineHV = $request->get('deadline');
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineHV);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_hv + $daysToSubtractHV; // Jumlah hari yang akan dikurangkan
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
                                        $adjustedDeadlineHV = $adjustedDeadline;
                
                                        // Simpan ke dalam objek GPADry
                                        $gpadrys->deadline = $adjustedDeadlineHV;

                                        // Menyimpan kalimat keterangan
                                        // $gpadrys->keterangan = 'Finishing tidak menggunakan OLTC';
                                    }
                                    elseif($workcenterDryType->nama_workcenter === 'LV Windling'){
                                        $adjustedDeadlineLV = $request->get('deadline');
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineLV);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_lv + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                                        $adjustedDeadlineLV = $adjustedDeadline; 
                
                                        // Simpan ke dalam objek GPADry 
                                        $gpadrys->deadline = $adjustedDeadlineLV;

                                        // Menyimpan kalimat keterangan
                                        // $gpadrys->keterangan = 'Finishing tidak menggunakan OLTC';
                                    }
                                    elseif($workcenterDryType->nama_workcenter === 'Supply Material Moulding'){
                                        $adjustedDeadlineSupplyMoulding = $request->get('deadline');
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyMoulding);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_supmatmould + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
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
                                        $adjustedDeadlineSupplyMoulding = $adjustedDeadline;
                
                                        // Simpan ke dalam objek GPADry
                                        $gpadrys->deadline = $adjustedDeadlineSupplyMoulding;

                                        // Menyimpan kalimat keterangan
                                        // $gpadrys->keterangan = 'Finishing tidak menggunakan OLTC';
                                    }
                                    elseif($workcenterDryType->nama_workcenter === 'Supply Material Insulation & Coil'){
                                        $adjustedDeadlineSupplyInsulationCoil = $request->get('deadline');
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyInsulationCoil);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_supmatinscoil + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                                        $adjustedDeadlineSupplyInsulationCoil = $adjustedDeadline; 
                
                                        // Simpan ke dalam objek GPADry 
                                        $gpadrys->deadline = $adjustedDeadlineSupplyInsulationCoil;

                                        // Menyimpan kalimat keterangan
                                        // $gpadrys->keterangan = 'Finishing tidak menggunakan OLTC';
                                    }
                                    elseif($workcenterDryType->nama_workcenter === 'Insulation Paper'){
                                        $adjustedDeadlineInsPaper = $request->get('deadline');
                                        $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineInsPaper);
                                        $daysToSubtract = $leadtimewithfinishing->jeda_inspaper + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                                        $adjustedDeadlineSupplyInsPaper = $adjustedDeadline; 
                
                                        // Simpan ke dalam objek GPADry 
                                        $gpadrys->deadline = $adjustedDeadlineSupplyInsPaper;

                                        // Menyimpan kalimat keterangan
                                        // $gpadrys->keterangan = 'Finishing tidak menggunakan OLTC';
                                    }
                                }
                            }
                        }
                    }
                    
                    // ! Menginisiasi breakdown GPA jika menggunakan finishing
                    else if ($daysToSubtractFinishingOltc > 0){
                        foreach($leadTimeWithFinishingOltcs as $leadtimewithfinishingoltc){
                            if($gpadrys->kva >= 250 && $gpadrys->kva <= 4000){
                                if($workcenterDryType->nama_workcenter === 'Quality Control Transfer Gudang'){
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadline);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_QCTransfer; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineQCTransfer = $adjustedDeadline;
        
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->deadline = $adjustedDeadlineQCTransfer;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Quality Control'){
                                    $adjustedDeadlineQCTransfer = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineQCTransfer);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_QC + $daysToSubtractQcTesting; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineQC = $adjustedDeadline;
        
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->deadline = $adjustedDeadlineQC;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Finishing'){
                                    $adjustedDeadlineFinishing = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineFinishing);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_finishing + $daysToSubtractFinishingOltc; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineFinishing = $adjustedDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->deadline = $adjustedDeadlineFinishing;

                                    // Menyimpan kalimat keterangan
                                    $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Connection & Final Assembly'){
                                    $adjustedDeadlineConnectFinal = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineConnectFinal);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_confa + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineConnectionFinalassembly = $adjustedDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->deadline = $adjustedDeadlineConnectionFinalassembly;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Material Connection & Final Assembly'){
                                    $adjustedDeadlineSupplyConnectFinal = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyConnectFinal);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_supmatconfa + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineSupplyConnectFinal = $adjustedDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->deadline = $adjustedDeadlineSupplyConnectFinal;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Susun Core'){
                                    $adjustedDeadlineSusunCore = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSusunCore);
                                    $daysToSubtract = 20 + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                                    $isHoliday = Holiday::where('date', $adjustedDeadlineSusunCore)->exists();
                                    // dd($isHoliday);
                                    if ($isHoliday) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari lagi jika tanggal adalah hari libur
                                        
                                    }
                                    
                                    $adjustednewDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->deadline = $adjustednewDeadline;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Moulding'){
                                    $adjustedDeadlineMoulding = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineMoulding);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_mould + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineMoulding = $adjustedDeadline;
                                    $isHoliday = Holiday::where('date', $adjustedDeadlineMoulding)->exists();
                                    // dd($isHoliday);
                                    if ($isHoliday) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari lagi jika tanggal adalah hari libur
                                        
                                    }
                                    
                                    $adjustednewDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->deadline = $adjustednewDeadline;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Fixing Parts & Core'){
                                    $adjustedDeadlineSupplyFixingCore = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyFixingCore);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_supfixcore + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineSupplyFixingCore = $adjustedDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->deadline = $adjustedDeadlineSupplyFixingCore;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Core'){
                                    $adjustedDeadlineCore = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineCore);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_core + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineCore = $adjustedDeadline;
                                    $isHoliday = Holiday::where('date', $adjustedDeadlineCore)->exists();
                                    // dd($isHoliday);
                                    if ($isHoliday) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari lagi jika tanggal adalah hari libur
                                        $adjustednewDeadline1 = date('Y-m-d', $adjustedDeadlineTimestamp);
                                        $isHoliday1 = Holiday::where('date', $adjustednewDeadline1)->exists();
                                        if($isHoliday1){
                                            $adjustedDeadlineTimestamp -= 24 * 60 * 60;
                                        }
                                    }
                                    
                                    $adjustednewDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->deadline = $adjustednewDeadline;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'HV Windling'){
                                    $adjustedDeadlineHV = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineHV);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_hv + $daysToSubtractHV; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineHV = $adjustedDeadline;
            
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->deadline = $adjustedDeadlineHV;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'LV Windling'){
                                    $adjustedDeadlineLV = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineLV);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_lv + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineLV = $adjustedDeadline; 
            
                                    // Simpan ke dalam objek GPADry 
                                    $gpadrys->deadline = $adjustedDeadlineLV;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Material Moulding'){
                                    $adjustedDeadlineSupplyMoulding = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyMoulding);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_supmatmould + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineSupplyMoulding = $adjustedDeadline;
                                    $isHoliday = Holiday::where('date', $adjustedDeadlineSupplyMoulding)->exists();
                                    // dd($isHoliday);
                                    if ($isHoliday) {
                                        $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari lagi jika tanggal adalah hari libur
                                        $adjustednewDeadline1 = date('Y-m-d', $adjustedDeadlineTimestamp);
                                        $isHoliday1 = Holiday::where('date', $adjustednewDeadline1)->exists();
                                        if($isHoliday1){
                                            $adjustedDeadlineTimestamp -= 24 * 60 * 60;
                                        }
                                    }
                                    
                                    $adjustednewDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                    
                                    
                                    // Simpan ke dalam objek GPADry
                                    $gpadrys->deadline = $adjustednewDeadline;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Supply Material Insulation & Coil'){
                                    $adjustedDeadlineSupplyInsulationCoil = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyInsulationCoil);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_supmatinscoil + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineSupplyInsulationCoil = $adjustedDeadline; 
            
                                    // Simpan ke dalam objek GPADry 
                                    $gpadrys->deadline = $adjustedDeadlineSupplyInsulationCoil;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                                elseif($workcenterDryType->nama_workcenter === 'Insulation Paper'){
                                    $adjustedDeadlineInsPaper = $request->get('deadline');
                                    $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineInsPaper);
                                    $daysToSubtract = $leadtimewithfinishingoltc->jeda_inspaper + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                                    $adjustedDeadlineSupplyInsPaper = $adjustedDeadline; 
            
                                    // Simpan ke dalam objek GPADry 
                                    $gpadrys->deadline = $adjustedDeadlineSupplyInsPaper;

                                    // Menyimpan kalimat keterangan
                                    // $gpadrys->keterangan = 'Finishing menggunakan OLTC';
                                }
                            }
                            
                        }
                    }
                }
                $gpadrys->save();
            }
            return redirect()->route('gpa-indexgpadry');  
        }
        else if($request->get('production_line') === 'PL2') {
            return redirect()->route('gpa-indexgpaoil');
        }
        else if($request->get('production_line') === 'PL3') {
            return redirect()->route('gpa-indexgpaoil');
        }
        return redirect()->route('mps-index'); // Jika jenis bukan 'Dry Type', redirect ke halaman mps-index biasa
    }

    public function getTotalHour($id)
    {
        $totalHour = DryCastResin::where('total_hour', $id)->get();

        return response()->json($totalHour);
    }

    public function exportToExcel()
    {
        $mps = Mps::with('wo')->get();

        $id_wo = $mps->first()->wo->id_wo;

        $dataMps = Mps::all();

        return Excel::download(new MpsExport($dataMps, $id_wo), 'MPS.xlsx');
    }

    public function exportToPdf()
    {
        $dataMps = Mps::select('id', 'id_wo', 'project', 'production_line', 'kva', 'jenis', 'qty_trafo', 'deadline')->get(); // Ambil data Mps dari database
        $pdf = PDF::loadView('planner.mps.view', ['dataMps' => $dataMps]);
        return $pdf->download('MPS.pdf');
    }
}