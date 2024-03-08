<?php
namespace App\Http\Controllers\planner;

use PDF;
use App\Exports\DetailBomExport;
use App\Imports\BomImport;
use App\Models\planner\Bom;
use App\Models\planner\Detailbom;
use App\Models\planner\Stock;
use App\Models\planner\Material;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\MaterialPendingNotification;
use App\Models\planner\Bomv2;
use App\Models\planner\Detailbomv2;
use App\Models\planner\Warehouse;
use App\Models\planner\Workcenter;
use App\Models\purchaser\pesanan;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;

class DetailbomControllerV2 extends Controller
{
    public function index()
    {
        $detailBom = Detailbomv2::all();
        $dataBom = Bomv2::all();

        return view('planner.bom_v2.index', compact('dataBom', 'detailBom'));
    }

    public function bomDetail(String $id_bom)
    {
        $dataBom = Bomv2::where('id_bom', $id_bom)->first();
        session(['idBom' => $id_bom]);

        // $this->CekMaterial($id_bom);
        // $this->updateStatusbom($id_bom);
        // $detailbom = Detailbomv2::all(); 

        $detailbom = Detailbomv2::with('bom')
            ->where('id_boms', $id_bom)
            ->orderBy('id', 'asc')
            ->get();
        // $bom = $detailbom->bom;
        // dd($detailbom);
            
        // $unsubmittedDetailBom = Detailbom::where('id_boms', $id_bom)
        //     ->where('submitted', false)
        //     ->orderBy('id_materialbom', 'asc')->get();

        // $submittedDetailBom = Detailbom::where('id_boms', $id_bom)
        //     ->where('submitted', true)
        //     ->get();

        // $statusAndKeterangan = $this->getStatusAndKeterangan($detailbom, $id_bom, $dataBom);
        // $status = $statusAndKeterangan['status'];
        // $keterangan = $statusAndKeterangan['keterangan'];

        return view('planner.bom_v2.detail-bom', [
            'dataBom' => $dataBom,
            'detailbom' => $detailbom,
            'id_bom' => $id_bom,
            // 'status' => $status,
            // 'keterangan' => $keterangan,
            // 'unsubmittedDetailBom' => $unsubmittedDetailBom,
            // 'submittedDetailBom' => $submittedDetailBom,
        ]);
    }
    
    public function formUpload()
    {
        return view('planner.bom_v2.upload-bom');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();

        $get_idboms = $worksheet->getCell('F5')->getValue(); //get_idboms mengambil seluruh value
        $id_boms = strtok($get_idboms, ' ');
        // dd($id_boms);

        $pattern = '/\((.*?)\)/';
        preg_match($pattern, $get_idboms, $matches);

        $bom = new Bom();

        if (isset($matches[1])) {
            $id_so = $matches[1]; 
            $bom->id_so = $id_so;
            // dd($id_so);
        } else {
            dd("Tidak ada id_so");
        }

        // Menyimpan data BOM
        $bom = new Bomv2();
        $bom->id_bom = $id_boms;
        $bom->id_so = $id_so;
        $bom->deskripsi = $get_idboms;
        $bom->save();

        $id_warehouse = null;
        $workcenter = null;

        for ($row = 10; $row <= 100; $row++) {
            // Memeriksa apakah ada nilai baru untuk id_warehouse dan workcenter
            $current_id_warehouse = $worksheet->getCell("B$row")->getValue();
            $current_workcenter = $worksheet->getCell("D$row")->getValue();

            if ($current_id_warehouse != '') {
                $id_warehouse = $current_id_warehouse;
            }
            if ($current_workcenter != '') {
                $workcenter = $current_workcenter;
            }

            // Jika tidak ada id_warehouse atau workcenter baru, lanjut ke baris berikutnya
            if ($id_warehouse === null || $workcenter === null) {
                continue;
            }

            // Mengambil nilai dari kolom id_material dan kolom lainnya
            $id_material = $worksheet->getCell("B$row")->getValue();
            if ($id_material == '') {
                // Jika tidak ada id_material baru, lanjut ke baris berikutnya
                continue;
            }

            // Mengambil nilai dari kolom lainnya
            $nama_material = $worksheet->getCell("H$row")->getValue();
            $second_material_name = $worksheet->getCell("L$row")->getValue();
            $uom = $worksheet->getCell("Q$row")->getValue();
            $comparison = $worksheet->getCell("V$row")->getValue();
            $composite = $worksheet->getCell("X$row")->getValue();
            $tolerance = $worksheet->getCell("AB$row")->getValue();

            // Menyimpan nilai id_warehouse dan workcenter
            $detailBom = new Detailbomv2();
            $detailBom->id_warehouse1 = $id_warehouse;
            $detailBom->nama_workcenter = $workcenter;

            // Menyimpan detail BOM untuk setiap material
            $detailBom->id_materialbom = $id_material;
            $detailBom->nama_materialbom = $nama_material;
            $detailBom->second_material_name = $second_material_name;
            $detailBom->uom_material = $uom;
            $detailBom->comparison = $comparison;
            $detailBom->composite = $composite;
            $detailBom->tolerance = $tolerance;
            // $detailBom->id_boms = $bom->id;
            $detailBom->id_boms = $bom->id_bom;
            $detailBom->save();
        }
        $this->updateData();
        return redirect('/BOM_V2/IndexBom');
    }

    public function updateData()
    {
        $uniqueWorkcenters = Detailbomv2::distinct()->pluck('nama_workcenter');
        // dd($uniqueWorkcenters);

        foreach ($uniqueWorkcenters as $workcenter) {
            // dd($workcenter);
            $id_warehouse = Detailbomv2::where('nama_workcenter', $workcenter)->first()->id_warehouse1;
            // dd($id_warehouse);

            Detailbomv2::where('nama_workcenter', $workcenter)->update(['id_warehouse1' => $id_warehouse]);
        }
        Detailbomv2::whereColumn('id_warehouse1', 'id_materialbom')->delete();
    }

    public function addmaterial(Request $request, $id_bom)
    {
        $boms = Bomv2::all();
        return view('planner.bom_v2.add-material', compact('id_bom', 'boms'));
    }

    // Storematerial
    public function storematerial(Request $request): RedirectResponse
    {
        $material = new Detailbom();

        $material->id_boms = $request->get('id_boms');
        $material->nama_workcenter = $request->get('nama_workcenter');
        $material->id_materialbom = $request->get('id_materialbom');
        $material->nama_materialbom = $request->get('nama_materialbom');
        $material->uom_material = $request->get('uom_material');
        $material->qty_trafo = $request->get('qty_trafo');
        $material->qty_material = $request->get('qty_material');

        $tolerance = (strtolower($request->uom_material) === 'kg') ? 0.025 : 0;

        $usagematerial = ($request->qty_trafo * $request->qty_material) * (1 + $tolerance);

        $material->tolerance = $tolerance;
        $material->usage_material = $usagematerial;

        $material->save();

        $id_bom = $request->get('id_boms');

        return redirect()->route('bom_v2.detailbom', ['id_bom' => $id_bom]);
    }

    public function edit(string $id_materialbom, string $id_bom): View
    {
        $detailbomItem = Detailbom::where('id_materialbom', $id_materialbom)
            ->where('id_boms', $id_bom)
            ->first();

        $id_bom = session('idBom');
        return view('planner.bom_v2.edit-material', compact('detailbomItem', 'id_bom'));
    }

    public function update(Request $request, $id_materialbom, $id_bom): RedirectResponse
    {
        $idBom = session('idBom');

        $this->validate($request, [
            'nama_workcenter' => 'required|string',
            'id_materialbom' => 'required|string',
            'nama_materialbom' => 'required|string',
            'uom_material' => 'required|string',
            'qty_trafo' => 'required|integer',
            'qty_material' => 'required|integer',
        ]);
    
        $detailbomItem = Detailbom::where('id_materialbom', $id_materialbom)
            ->where('id_boms', $id_bom)
            ->first();
    
        // Sebelum pembaruan, simpan nilai asli
        $detailbomItem->syncOriginal();
        $tolerance = (strtolower($request->uom_material) === 'kg') ? 0.025 : 0;

        $usagematerial = ($request->qty_trafo * $request->qty_material) * (1 + $tolerance);

        $detailbomItem->update([
            'nama_workcenter' => $request->nama_workcenter,
            'id_materialbom' => $request->id_materialbom,
            'nama_materialbom' => $request->nama_materialbom,
            'uom_material' => $request->uom_material,
            'qty_trafo' => $request->qty_trafo,
            'qty_material' => $request->qty_material,
            'tolerance' => $tolerance,
            'usage_material' => $usagematerial,
            'email_status' => 0,
        ]);
        return redirect()->route('bom_v2.detailbom', ['id_bom' => $idBom]);
    }

    public function deleteMaterial($id_materialbom, $id_bom)
    {
        $detailBom = Detailbom::where('id_materialbom', $id_materialbom)
            ->where('id_boms', $id_bom)->first();

        $detailBom->delete();

        return redirect()->back();
    }

    // public function CekMaterial($id_bom)
    // {
    //     $detailboms = Detailbom::where('id_boms', $id_bom)->get();

    //     foreach ($detailboms as $detailbom) {
    //         if ($detailbom->submitted == 1) {
    //             continue;
    //         }

    //         $material = Material::where('kd_material', $detailbom->id_materialbom)->first();
    //         // dd($material);

    //         if ($material && (Str::startsWith($material->nama_material, 'Fixing Part') || Str::startsWith($material->nama_material, 'Tanki'))) {
    //             $detailbom->db_status = 1;
    //             $detailbom->keterangan = "Material Ready Stock";
    //         } else {
    //             if (!$material) {
    //                 $detailbom->db_status = 0;
    //                 $detailbom->keterangan = "Material tidak ditemukan";
    //             } else {
    //                 $usageMaterial = $detailbom->usage_material;
    //                 $materialQty = $material->jumlah - $material->booked;
    
    //                 if ($usageMaterial > $materialQty) {
    //                     $detailbom->db_status = 0;
    //                     $detailbom->keterangan = "Terdapat material kurang";
    //                 } else {
    //                     $detailbom->db_status = 1;
    //                     $detailbom->keterangan = "Material Ready Stock";
    //                 }
    //             }
    //         }
    //         $detailbom->save();
    //     }

    //     $this->updateStatusbom($id_bom);

    //     return redirect()->back();
    // }

    // public function emailNotif($idBom)
    // {
    //     $notifMaterial = Detailbom::where('id_boms', $idBom)
    //         ->where('db_status', 0)
    //         ->where('email_status', 0)
    //         ->get();

    //     if ($notifMaterial->count() > 0) {
    //         $subjekEmail = "Bill of Material Tertunda $idBom";

    //         $dataMaterial = $notifMaterial->map(function ($material) {
    //             return [
    //                 'id_boms' => $material->id_boms,
    //                 'id_materialbom' => $material->id_materialbom,
    //                 'nama_materialbom' => $material->nama_materialbom,
    //                 'usage_material' => $material->usage_material,
    //             ];
    //         });

    //         $stockInfo = Stock::where('item_code', $notifMaterial->first()->id_materialbom)->first();
    //         // dd($stockInfo);
    //         $pesananInfo = pesanan::where('kd_material', $notifMaterial->first()->id_materialbom)
    //         ->whereNotNull('total')
    //         ->first();
    //         // dd($pesananInfo);
    //         $materialInfo = Material::where('kd_material', $notifMaterial->first()->id_materialbom)->first();
    //         $alamatEmailPenerima = ['stevenliong83@gmail.com', 'steven.naga15@gmail.com'];
    //         Mail::to($alamatEmailPenerima)->send(new MaterialPendingNotification(
    //             $dataMaterial,
    //             $stockInfo,
    //             $subjekEmail,
    //             $idBom,
    //             $materialInfo,
    //             $pesananInfo
    //         ));

    //         $notifMaterial->each(function ($material) {
    //             $material->update(['email_status' => 1, 'last_kirim_email' => now()]);
    //         });
    //     }
    // }

    // public function getStatusAndKeterangan($detailbom, $id_bom, $dataBom)
    // {
    //     $status = "Completed";
    //     $detailbomForIdBom = $detailbom->where('id_boms', $id_bom);
    //     $cekdataBom = $dataBom->where('id_bom', $id_bom);

    //     $countDbStatusZero = $detailbomForIdBom->where('db_status', 0)->count();
    //     $cekStatusBom = $cekdataBom->where('status_bom', 3)->count();
    //     // dd($cekStatusBom);

    //     $keterangan = "Semua Material Terpenuhi untuk Kode BOM $id_bom";

    //     if ($countDbStatusZero > 0) {
    //         $status = "Pending";
    //         $keterangan = "Terdapat Material Kurang";
    //     }

    //     if($cekStatusBom > 0){
    //         $status = "Approved";
    //         $keterangan = "Bill of Material Sudah Tersubmit";
    //     }

    //     return [
    //         'status' => $status,
    //         'keterangan' => $keterangan,
    //     ];
    // }

    // public function updateStatusbom($id_bom)
    // {
    //     $idBom = session('idBom');

    //     $detailboms = Detailbom::where('id_boms', $idBom)->get();

    //     $statusBom = 2;

    //     if ($detailboms->contains('db_status', 0)) {
    //         $statusBom = 1;
    //     }
    //     if ($detailboms->contains('submitted', 1)) {
    //         $statusBom = 3;
    //     }

    //     $this->emailNotif($idBom);

    //     Bom::where('id_bom', $id_bom)->update(['status_bom' => $statusBom]);
    // }

    // public function submit(Request $request)
    // {
    //     $idBom = $request->input('id_bom');
    //     $detailBoms = Detailbom::where('id_boms', $idBom)->get();

    //     foreach ($detailBoms as $detailBom) {
    //         if ($detailBom->db_status == 1 && $detailBom->submitted == 0) {
    //             $material = Material::where('kd_material', $detailBom->id_materialbom)->first();
    //             if ($material) {
    //                 $material->booked += $detailBom->usage_material;
    //                 $material->save();
    //             }
    //         }
    //     }

    //     Detailbom::where('id_boms', $idBom)->update(['submitted' => 1]);

    //     return redirect()->route('bom_v2.detailbom', $idBom);
    // }

    // public function restoreMaterial(Request $request, $id_materialbom, $id_bom)
    // {

    //     $detailBom = Detailbom::where('id_materialbom', $id_materialbom)->where('id_boms', $id_bom)->first();

    //     if ($detailBom->submitted == 1) {
    //         $material = Material::where('kd_material', $detailBom->id_materialbom)->first();

    //         if ($material) {
    //             $material->booked -= $detailBom->usage_material;
    //             $material->save();
    //         }
    //     }

    //     $detailBom->setAttribute('submitted', 0);
    //     $detailBom->save();

    //     return redirect()->back();
    // }

    // public function exportToExcel()
    // {
    //     $dataBom = Detailbom::select('id_boms', 'nama_workcenter', 'id_materialbom', 'nama_materialbom', 'uom_material', 'usage_material', 'keterangan')->get();
    //     // $dataBom = Detailbom::all();
    //     // dd($dataBom);
    //     $id_boms = $dataBom->isNotEmpty() ? $dataBom->first()->id_boms : 'Kode Bom Tidak Ada';
    //     return Excel::download(new DetailBomExport($dataBom), "File Bill of Material $id_boms.xlsx");
    // }

    // public function exportToPdf()
    // {
    //     $dataBom = Detailbom::select('id', 'id_boms', 'nama_workcenter', 'id_materialbom', 'nama_materialbom', 'uom_material', 'usage_material', 'keterangan')->get(); // Ambil data Mps dari database
    //     $id_boms = $dataBom->isNotEmpty() ? $dataBom->first()->id_boms : 'Kode Bom Tidak Ada';
    //     $pdf = PDF::loadView('planner.bom.pdf-view', ['dataBom' => $dataBom]);
    //     return $pdf->download("Bill of Material $id_boms.pdf");
    // }
}