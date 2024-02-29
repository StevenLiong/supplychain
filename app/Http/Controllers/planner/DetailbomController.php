<?php
//GANTI KETERANGAN JADI READY STOCK
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
use App\Models\purchaser\pesanan;
use Illuminate\Support\Str;

class DetailbomController extends Controller
{
    public function index()
    {
        $detailBom = Detailbom::all();
        $dataBom = Bom::all();

        return view('planner.bom.index', compact('dataBom', 'detailBom'));
    }

    public function bomDetail(String $id_bom)
    {
        $dataBom = Bom::where('id_bom', $id_bom)->first();
        session(['idBom' => $id_bom]);

        $this->CekMaterial($id_bom);
        $this->updateStatusbom($id_bom); 

        $detailbom = Detailbom::with('bom')
            ->where('id_boms', $id_bom)
            ->orderBy('id', 'asc')
            ->get();
            
        $unsubmittedDetailBom = Detailbom::where('id_boms', $id_bom)
            ->where('submitted', false)
            ->orderBy('id_materialbom', 'asc')->get();

        $submittedDetailBom = Detailbom::where('id_boms', $id_bom)
            ->where('submitted', true)
            ->get();

        $statusAndKeterangan = $this->getStatusAndKeterangan($detailbom, $id_bom, $dataBom);
        $status = $statusAndKeterangan['status'];
        $keterangan = $statusAndKeterangan['keterangan'];

        // $this->emailReminder();
        // $this->emailReminder();

        // $this->sendEmailReminder($material);

        return view('planner.bom.detail-bom', [
            'dataBom' => $dataBom,
            'detailbom' => $detailbom,
            'id_bom' => $id_bom,
            'status' => $status,
            'keterangan' => $keterangan,
            'unsubmittedDetailBom' => $unsubmittedDetailBom,
            'submittedDetailBom' => $submittedDetailBom,
        ]);
    }
    
    public function formUpload($idBom)
    {
        $bom = Bom::find($idBom);

        return view('planner.bom.upload-bom', ['bom' => $bom]);
    }

    public function upload(Request $request){
        $idBom = session('idBom');

        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $file = $request->file('file');

        $import = new BomImport($idBom);

        Excel::import($import, $file);
        return redirect('/BOM/IndexBom');
    }

    public function addmaterial(Request $request, $id_bom)
    {
        $boms = Bom::all();
        return view('planner.bom.add-material', compact('id_bom', 'boms'));
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

        return redirect()->route('bom.detailbom', ['id_bom' => $id_bom]);
    }

    public function edit(string $id_materialbom, string $id_bom): View
    {
        $detailbomItem = Detailbom::where('id_materialbom', $id_materialbom)
            ->where('id_boms', $id_bom)
            ->first();

        $id_bom = session('idBom');
        return view('planner.bom.edit-material', compact('detailbomItem', 'id_bom'));
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
        return redirect()->route('bom.detailbom', ['id_bom' => $idBom]);
    }

    public function deleteMaterial($id_materialbom, $id_bom)
    {
        $detailBom = Detailbom::where('id_materialbom', $id_materialbom)
            ->where('id_boms', $id_bom)->first();

        $detailBom->delete();

        return redirect()->back();
    }

    public function CekMaterial($id_bom)
    {
        $detailboms = Detailbom::where('id_boms', $id_bom)->get();

        foreach ($detailboms as $detailbom) {
            if ($detailbom->submitted == 1) {
                continue;
            }

            $material = Material::where('kd_material', $detailbom->id_materialbom)->first();
            // dd($material);

            if ($material && (Str::startsWith($material->nama_material, 'Fixing Part') || Str::startsWith($material->nama_material, 'Tanki'))) {
                $detailbom->db_status = 1;
                $detailbom->keterangan = "Material Ready Stock";
            } else {
                if (!$material) {
                    $detailbom->db_status = 0;
                    $detailbom->keterangan = "Material tidak ditemukan";
                } else {
                    $usageMaterial = $detailbom->usage_material;
                    $materialQty = $material->jumlah - $material->booked;
    
                    if ($usageMaterial > $materialQty) {
                        $detailbom->db_status = 0;
                        $detailbom->keterangan = "Terdapat material kurang";
                    } else {
                        $detailbom->db_status = 1;
                        $detailbom->keterangan = "Material Ready Stock";
                    }
                }
            }

            // if (!$material) {
            //     $detailbom->db_status = 0;
            //     $detailbom->keterangan = "Material tidak ditemukan";
            // } else {
            //     $usageMaterial = $detailbom->usage_material;
            //     $materialQty = $material->booked;
            //     // $materialQty = $material->jumlah;

            //     if ($usageMaterial > $materialQty) {
            //         $detailbom->db_status = 0;
            //         $detailbom->keterangan = "Terdapat material kurang";
            //     } else {
            //         $detailbom->db_status = 1;
            //         $detailbom->keterangan = "Material BOM Sudah Cukup";
            //     }
            // }
            // ===============================================
            // if (!$material) {
            //     $detailbom->db_status = 0;
            //     $detailbom->keterangan = "Material tidak ditemukan";
            // } else {
            //     $usageMaterial = $detailbom->usage_material;
            //     $materialQty = $material->jumlah - $material->booked;
            //     // dd($materialQty);
            //     // $materialQty = $material->jumlah;
            //     if ($usageMaterial > $materialQty) {
            //         $detailbom->db_status = 0;
            //         $detailbom->keterangan = "Terdapat material kurang";
            //     } else {
            //         $detailbom->db_status = 1;
            //         $detailbom->keterangan = "Material BOM Sudah Cukup";
            //     }
            // }
            $detailbom->save();
        }

        $this->updateStatusbom($id_bom);

        return redirect()->back();
    }

    public function emailNotif($idBom)
    {
        $notifMaterial = Detailbom::where('id_boms', $idBom)
            ->where('db_status', 0)
            ->where('email_status', 0)
            ->get();

        if ($notifMaterial->count() > 0) {
            $subjekEmail = "Bill of Material Tertunda $idBom";

            $dataMaterial = $notifMaterial->map(function ($material) {
                return [
                    'id_boms' => $material->id_boms,
                    'id_materialbom' => $material->id_materialbom,
                    'nama_materialbom' => $material->nama_materialbom,
                    'usage_material' => $material->usage_material,
                ];
            });

            $stockInfo = Stock::where('item_code', $notifMaterial->first()->id_materialbom)->first();
            // dd($stockInfo);
            $pesananInfo = pesanan::where('kd_material', $notifMaterial->first()->id_materialbom)
            ->whereNotNull('total')
            ->first();
            // dd($pesananInfo);
            $materialInfo = Material::where('kd_material', $notifMaterial->first()->id_materialbom)->first();
            $alamatEmailPenerima = ['stevenliong83@gmail.com', 'steven.naga15@gmail.com'];
            Mail::to($alamatEmailPenerima)->send(new MaterialPendingNotification(
                $dataMaterial,
                $stockInfo,
                $subjekEmail,
                $idBom,
                $materialInfo,
                $pesananInfo
            ));

            $notifMaterial->each(function ($material) {
                $material->update(['email_status' => 1, 'last_kirim_email' => now()]);
            });
        }
    }

    public function getStatusAndKeterangan($detailbom, $id_bom, $dataBom)
    {
        $status = "Completed";
        $detailbomForIdBom = $detailbom->where('id_boms', $id_bom);
        $cekdataBom = $dataBom->where('id_bom', $id_bom);

        $countDbStatusZero = $detailbomForIdBom->where('db_status', 0)->count();
        $cekStatusBom = $cekdataBom->where('status_bom', 3)->count();
        // dd($cekStatusBom);

        $keterangan = "Semua Material Terpenuhi untuk Kode BOM $id_bom";

        if ($countDbStatusZero > 0) {
            $status = "Pending";
            $keterangan = "Terdapat Material Kurang";
        }

        if($cekStatusBom > 0){
            $status = "Approved";
            $keterangan = "Bill of Material Sudah Tersubmit";
        }

        return [
            'status' => $status,
            'keterangan' => $keterangan,
        ];
    }

    public function updateStatusbom($id_bom)
    {
        $idBom = session('idBom');

        $detailboms = Detailbom::where('id_boms', $idBom)->get();

        $statusBom = 2;

        if ($detailboms->contains('db_status', 0)) {
            $statusBom = 1;
        }
        if ($detailboms->contains('submitted', 1)) {
            $statusBom = 3;
        }

        $this->emailNotif($idBom);

        Bom::where('id_bom', $id_bom)->update(['status_bom' => $statusBom]);
    }

    public function submit(Request $request)
    {
        $idBom = $request->input('id_bom');
        $detailBoms = Detailbom::where('id_boms', $idBom)->get();

        foreach ($detailBoms as $detailBom) {
            if ($detailBom->db_status == 1 && $detailBom->submitted == 0) {
                $material = Material::where('kd_material', $detailBom->id_materialbom)->first();
                if ($material) {
                    $material->booked += $detailBom->usage_material;
                    $material->save();
                }
            }
        }

        Detailbom::where('id_boms', $idBom)->update(['submitted' => 1]);

        return redirect()->route('bom.detailbom', $idBom);
    }

    public function restoreMaterial(Request $request, $id_materialbom, $id_bom)
    {

        $detailBom = Detailbom::where('id_materialbom', $id_materialbom)->where('id_boms', $id_bom)->first();

        if ($detailBom->submitted == 1) {
            $material = Material::where('kd_material', $detailBom->id_materialbom)->first();

            if ($material) {
                $material->booked -= $detailBom->usage_material;
                $material->save();
            }
        }

        $detailBom->setAttribute('submitted', 0);
        $detailBom->save();

        return redirect()->back();
    }

    public function exportToExcel()
    {
        $dataBom = Detailbom::select('id_boms', 'nama_workcenter', 'id_materialbom', 'nama_materialbom', 'uom_material', 'usage_material', 'keterangan')->get();
        // $dataBom = Detailbom::all();
        // dd($dataBom);
        $id_boms = $dataBom->isNotEmpty() ? $dataBom->first()->id_boms : 'Kode Bom Tidak Ada';
        return Excel::download(new DetailBomExport($dataBom), "File Bill of Material $id_boms.xlsx");
    }

    public function exportToPdf()
    {
        $dataBom = Detailbom::select('id', 'id_boms', 'nama_workcenter', 'id_materialbom', 'nama_materialbom', 'uom_material', 'usage_material', 'keterangan')->get(); // Ambil data Mps dari database
        $id_boms = $dataBom->isNotEmpty() ? $dataBom->first()->id_boms : 'Kode Bom Tidak Ada';
        $pdf = PDF::loadView('planner.bom.pdf-view', ['dataBom' => $dataBom]);
        return $pdf->download("Bill of Material $id_boms.pdf");
    }
}