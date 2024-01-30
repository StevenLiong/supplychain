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
use Maatwebsite\Excel\Facades\Excel;
use App\Models\produksi\DryCastResin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\planner\KapasitasProduksi;
use App\Models\planner\WorkcenterDryType;
use App\Models\planner\WorkcenterOilTrafo;
use Database\Seeders\WorkcenterOilTrafoSeeder;

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
        $mps->save();
        if ($request->get('production_line') === 'Drytype') {
            $kapasitasProduksi = KapasitasProduksi::where('tanggal', $mps->deadline)->latest()->first();

            if ($kapasitasProduksi) {
                // $newKapasitasProduksi = new KapasitasProduksi();
                $kapasitasProduksi->tanggal = $mps->deadline;
                $kapasitasProduksi->Drytype = $kapasitasProduksi->Drytype - $wo->qty_trafo;
                $kapasitasProduksi->PL2;
                $kapasitasProduksi->PL3;
                $kapasitasProduksi->save();
            }
            // Ambil data workcenter_dry_types
            $workcenterDryTypes = WorkcenterDryType::all();
            $drycastresins = DryCastResin::where('kd_manhour', $wo->id)->get();
            // dd($drycastresins);

            foreach ($workcenterDryTypes as $workcenterDryType) {
                foreach ($drycastresins as $drycastresin) {
                    $gpadrys = new GPADry();
                    // $gpadrys->id_wo = $request->get('id_wo');
                    $gpadrys->id_wo = $wo->id;
                    $gpadrys->project = $request->get('project');
                    $gpadrys->production_line = $request->get('production_line');
                    $gpadrys->kva = $mps->kva;
                    $gpadrys->jenis = $request->get('jenis');
                    $gpadrys->qty_trafo = $mps->qty_trafo;
                    $adjustedDeadline = $request->get('deadline');
                    // dd($adjustedDeadline); 
                    $gpadrys->nama_workcenter = $workcenterDryType->nama_workcenter;

                    $lv_windling = $drycastresin->hour_coil_lv + $drycastresin->hour_potong_leadwire + $drycastresin->hour_potong_isolasi;
                    $hv_windling = $drycastresin->hour_coil_hv;
                    $moulding = $drycastresin->hour_hv_moulding + $drycastresin->hour_lv_moulding + $drycastresin->hour_hv_casting + $drycastresin->hour_hv_demoulding + $drycastresin->hour_lv_bobbin + $drycastresin->hour_touch_up;
                    $susun_core = $drycastresin->hour_type_susun_core + $drycastresin->hour_potong_isolasi_fiber;
                    $connection_finalassembly = $drycastresin->hour_others;
                    $finishing = $drycastresin->hour_wiring + $drycastresin->hour_instal_housing + $drycastresin->hour_bongkar_housing + $drycastresin->hour_pembuatan_cu_link + $drycastresin->hour_accesories;
                    $hoursInDay = 8;
                    $daysToSubtractLV = $lv_windling / $hoursInDay;
                    $daysToSubtractHV = $hv_windling / $hoursInDay;
                    $daysToSubtractMoulding = $moulding / $hoursInDay;
                    $daysToSubtractSusunCore = $susun_core / $hoursInDay;
                    $daysToSubtractConnectionFinalassembly = $connection_finalassembly / $hoursInDay;
                    $daysToSubtractFinishing = $finishing / $hoursInDay;
                    if ($gpadrys->kva >= 800 && $gpadrys->kva <= 1600) {
                        if($workcenterDryType->nama_workcenter === 'Quality Control Transfer Gudang'){
                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadline);
                            $daysToSubtract = 2; // Jumlah hari yang akan dikurangkan
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
                            $daysToSubtract = 3; // Jumlah hari yang akan dikurangkan
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
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineFinishing = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineFinishing);
                                $daysToSubtract = 3; // Jumlah hari yang akan dikurangkan
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
                            }
                            elseif($daysToSubtractFinishing > 0){
                                $adjustedDeadlineFinishing = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineFinishing);
                                $daysToSubtract = 3 + $daysToSubtractFinishing; // Jumlah hari yang akan dikurangkan
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
                            }
                        }
                        elseif($workcenterDryType->nama_workcenter === 'Connection & Final Assembly'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineConnectionFinalassembly = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineConnectionFinalassembly);
                                $daysToSubtract = 4 + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                            }
                            elseif($daysToSubtractFinishing > 0){
                                $adjustedDeadlineConnectFinal = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineConnectFinal);
                                $daysToSubtract = 7 + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                            }
                        }
                        elseif($workcenterDryType->nama_workcenter === 'Supply Material Connection & Final Assembly'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineSupplyConnectFinal = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyConnectFinal);
                                $daysToSubtract = 5 + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                            elseif($daysToSubtractFinishing > 0){
                                $adjustedDeadlineSupplyConnectFinal = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyConnectFinal);
                                $daysToSubtract = 8 + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                            }
                        }
                        elseif($workcenterDryType->nama_workcenter === 'Susun Core'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineSusunCore = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSusunCore);
                                $daysToSubtract = 6 + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                            elseif($daysToSubtractFinishing > 0){
                                $adjustedDeadlineSusunCore = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSusunCore);
                                $daysToSubtract = 8 + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                        }
                        elseif($workcenterDryType->nama_workcenter === 'Moulding'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineMoulding = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineMoulding);
                                $daysToSubtract = 7 + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
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
                            elseif($daysToSubtractFinishing > 0){
                                $adjustedDeadlineMoulding = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineMoulding);
                                $daysToSubtract = 5 + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
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
                        }
                        elseif($workcenterDryType->nama_workcenter === 'Supply Fixing Parts & Core'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineSupplyFixingCore = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyFixingCore);
                                $daysToSubtract = 9 + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                            elseif($daysToSubtractFinishing > 0){
                                $adjustedDeadlineSupplyFixingCore = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyFixingCore);
                                $daysToSubtract = 9 + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                        }
                        elseif($workcenterDryType->nama_workcenter === 'Core'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineCore = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineCore);
                                $daysToSubtract = 11 + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                            elseif($daysToSubtractFinishing > 0){
                                $adjustedDeadlineCore = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineCore);
                                $daysToSubtract = 12 + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                        }
                        elseif($workcenterDryType->nama_workcenter === 'HV Windling'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineHV = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineHV);
                                $daysToSubtract = 13 + $daysToSubtractHV; // Jumlah hari yang akan dikurangkan
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
                            elseif($daysToSubtractFinishing > 0){
                                $adjustedDeadlineHV = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineHV);
                                $daysToSubtract = 11 + $daysToSubtractHV; // Jumlah hari yang akan dikurangkan
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
                        }
                        elseif($workcenterDryType->nama_workcenter === 'LV Windling'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineLV = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineLV);
                                $daysToSubtract = 17 + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                            elseif($daysToSubtractFinishing > 0){
                                $adjustedDeadlineLV = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineLV);
                                $daysToSubtract = 14 + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                        }
                        elseif($workcenterDryType->nama_workcenter === 'Supply Material Moulding'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineSupplyMoulding = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyMoulding);
                                $daysToSubtract = 8 + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
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
                            elseif($daysToSubtractFinishing > 0){
                                $adjustedDeadlineSupplyMoulding = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyMoulding);
                                $daysToSubtract = 6 + $daysToSubtractMoulding; // Jumlah hari yang akan dikurangkan
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
                            }
                        }
                        elseif($workcenterDryType->nama_workcenter === 'Supply Material Insulation & Coil'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineSupplyInsulationCoil = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyInsulationCoil);
                                $daysToSubtract = 19 + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                            elseif($daysToSubtractFinishing > 0){
                                $adjustedDeadlineSupplyInsulationCoil = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyInsulationCoil);
                                $daysToSubtract = 15 + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                        }
                        elseif($workcenterDryType->nama_workcenter === 'Insulation Paper'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineInsPaper = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineInsPaper);
                                $daysToSubtract = 22 + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                            elseif($daysToSubtractFinishing > 0){
                                $adjustedDeadlineInsPaper = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineInsPaper);
                                $daysToSubtract = 18 + $daysToSubtractLV; // Jumlah hari yang akan dikurangkan
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
                            }
                        }
                    }
                    elseif($gpadrys->kva >= 2000 && $gpadrys->kva <= 4000){
                        if($workcenterDryType->nama_workcenter === 'Quality Control Transfer Gudang'){
                            $adjustedDeadlineTimestamp = strtotime($adjustedDeadline);
                            $daysToSubtract = 2; // Jumlah hari yang akan dikurangkan
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
                            $daysToSubtract = 3; // Jumlah hari yang akan dikurangkan
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
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineFinishing = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineFinishing);
                                $daysToSubtract = 3; // Jumlah hari yang akan dikurangkan
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
                            }
                            // elseif($daysToSubtractFinishing > 0){
                            //     $adjustedDeadlineFinishing = $request->get('deadline');
                            //     $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineFinishing);
                            //     $daysToSubtract = 3 + $daysToSubtractFinishing; // Jumlah hari yang akan dikurangkan
                            //     $countWorkDays = 0;
                            //     while ($daysToSubtract > 0) {
                            //         $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                            //         $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
        
                            //         // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                            //         if ($currentDay < 6) {
                            //             $daysToSubtract--; // Kurangi hari jika bukan hari libur
                            //             $countWorkDays++;
                            //         }
                            //     }
        
                            //     $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                
                            //     // Simpan deadline yang telah disesuaikan ke dalam variabel
                            //     $adjustedDeadlineFinishing = $adjustedDeadline;
        
                            //     // Simpan ke dalam objek GPADry
                            //     $gpadrys->deadline = $adjustedDeadlineFinishing;
                            // }
                        }
                        elseif($workcenterDryType->nama_workcenter === 'Connection & Final Assembly'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineConnectionFinalassembly = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineConnectionFinalassembly);
                                $daysToSubtract = 4 + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                            }
                            elseif($daysToSubtractFinishing > 0){
                                $adjustedDeadlineConnectFinal = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineConnectFinal);
                                $daysToSubtract = 7 + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                            }
                        }
                        elseif($workcenterDryType->nama_workcenter === 'Connection & Final Assembly'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineConnectionFinalassembly = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineConnectionFinalassembly);
                                $daysToSubtract = 4 + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                            }
                            // elseif($daysToSubtractFinishing > 0){
                            //     $adjustedDeadlineConnectFinal = $request->get('deadline');
                            //     $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineConnectFinal);
                            //     $daysToSubtract = 7 + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
                            //     $countWorkDays = 0;
                            //     while ($daysToSubtract > 0) {
                            //         $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                            //         $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
        
                            //         // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                            //         if ($currentDay < 6) {
                            //             $daysToSubtract--; // Kurangi hari jika bukan hari libur
                            //             $countWorkDays++;
                            //         }
                            //     }
        
                            //     $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                
                            //     // Simpan deadline yang telah disesuaikan ke dalam variabel
                            //     $adjustedDeadlineConnectionFinalassembly = $adjustedDeadline;
        
                            //     // Simpan ke dalam objek GPADry
                            //     $gpadrys->deadline = $adjustedDeadlineConnectionFinalassembly;
                            // }
                        }
                        elseif($workcenterDryType->nama_workcenter === 'Supply Material Connection & Final Assembly'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineSupplyConnectFinal = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyConnectFinal);
                                $daysToSubtract = 5 + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
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
                            // elseif($daysToSubtractFinishing > 0){
                            //     $adjustedDeadlineSupplyConnectFinal = $request->get('deadline');
                            //     $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSupplyConnectFinal);
                            //     $daysToSubtract = 8 + $daysToSubtractConnectionFinalassembly; // Jumlah hari yang akan dikurangkan
                            //     $countWorkDays = 0;
                            //     while ($daysToSubtract > 0) {
                            //         $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                            //         $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
        
                            //         // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                            //         if ($currentDay < 6) {
                            //             $daysToSubtract--; // Kurangi hari jika bukan hari libur
                            //             $countWorkDays++;
                            //         }
                            //     }
        
                            //     $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                
                            //     // Simpan deadline yang telah disesuaikan ke dalam variabel
                            //     $adjustedDeadlineSupplyConnectFinal = $adjustedDeadline;
        
                            //     // Simpan ke dalam objek GPADry
                            //     $gpadrys->deadline = $adjustedDeadlineSupplyConnectFinal;
                            // }
                        }
                        elseif($workcenterDryType->nama_workcenter === 'Susun Core'){
                            if($daysToSubtractFinishing == 0){
                                $adjustedDeadlineSusunCore = $request->get('deadline');
                                $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSusunCore);
                                $daysToSubtract = 6 + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
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
                            // elseif($daysToSubtractFinishing > 0){
                            //     $adjustedDeadlineSusunCore = $request->get('deadline');
                            //     $adjustedDeadlineTimestamp = strtotime($adjustedDeadlineSusunCore);
                            //     $daysToSubtract = 8 + $daysToSubtractSusunCore; // Jumlah hari yang akan dikurangkan
                            //     $countWorkDays = 0;
                            //     while ($daysToSubtract > 0) {
                            //         $adjustedDeadlineTimestamp -= 24 * 60 * 60; // Kurangi satu hari
                            //         $currentDay = date('N', $adjustedDeadlineTimestamp); // Mendapatkan hari dalam format ISO (1 untuk Senin, 7 untuk Minggu)
        
                            //         // Cek apakah hari saat ini bukan Sabtu atau Minggu (1 = Senin, 6 = Sabtu, 7 = Minggu)
                            //         if ($currentDay < 6) {
                            //             $daysToSubtract--; // Kurangi hari jika bukan hari libur
                            //             $countWorkDays++;
                            //         }
                            //     }
        
                            //     $adjustedDeadline = date('Y-m-d', $adjustedDeadlineTimestamp);
                                
                            //     // Simpan deadline yang telah disesuaikan ke dalam variabel
                            //     $adjustedDeadlineSusunCore = $adjustedDeadline;
        
                            //     // Simpan ke dalam objek GPADry
                            //     $gpadrys->deadline = $adjustedDeadlineSusunCore;
                            // }
                        }
                    }
                }
                // dd($gpadrys);
                $gpadrys->save();
            }
            return redirect()->route('gpa-indexgpadry');  
        }
        elseif ($request->get('production_line') === 'PL2') {
            $kapasitasProduksi = KapasitasProduksi::where('tanggal', $mps->deadline)->latest()->first();

            if ($kapasitasProduksi) {
                // $newKapasitasProduksi = new KapasitasProduksi();
                $kapasitasProduksi->tanggal = $mps->deadline;
                $kapasitasProduksi->Drytype;
                $kapasitasProduksi->PL2 = $kapasitasProduksi->PL2 - $wo->qty_trafo;
                $kapasitasProduksi->PL3;
                $kapasitasProduksi->save();
            }
            return redirect()->route('gpa-indexgpaoil');
        }
        elseif ($request->get('production_line') === 'PL3') {
            $kapasitasProduksi = KapasitasProduksi::where('tanggal', $mps->deadline)->latest()->first();

            if ($kapasitasProduksi) {
                // $newKapasitasProduksi = new KapasitasProduksi();
                $kapasitasProduksi->tanggal = $mps->deadline;
                $kapasitasProduksi->Drytype;
                $kapasitasProduksi->PL2;
                $kapasitasProduksi->PL3 = $kapasitasProduksi->PL3 - $wo->qty_trafo;
                $kapasitasProduksi->save();
            }
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
        $dataMps = Mps::select('id', 'id_wo', 'project', 'production_line', 'kva', 'jenis', 'qty_trafo', 'deadline')->get(); // Ambil data Mps dari database

        return Excel::download(new MpsExport($dataMps), 'MPS.xlsx');
    }

    public function exportToPdf()
    {
        $dataMps = Mps::select('id', 'id_wo', 'project', 'production_line', 'kva', 'jenis', 'qty_trafo', 'deadline')->get(); // Ambil data Mps dari database
        $pdf = PDF::loadView('planner.mps.view', ['dataMps' => $dataMps]);
        return $pdf->download('MPS.pdf');
    }
}