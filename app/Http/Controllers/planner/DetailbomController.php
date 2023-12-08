<?php

namespace App\Http\Controllers\planner;

use App\Imports\BomImport;
use App\Models\planner\Bom;
use App\Models\planner\Detailbom;
use App\Models\planner\Stock;
use App\Models\planner\Material;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\MaterialPendingNotification;
use Illuminate\Support\Facades\Cache;

class DetailbomController extends Controller
{

    public function index()
    {
        $detailBom = Detailbom::all();
        // $statusAndKeterangan = $this->getStatusAndKeterangan($detailbom, $id_bom);
        // $status = $statusAndKeterangan['status'];
        // $keterangan = $statusAndKeterangan['keterangan'];

        return view('planner.bom.index', compact('dataBom', 'detailBom'));
    }

    public function bomDetail(String $id_bom)
    {
        $dataBom = Bom::where('id_bom', $id_bom)->first();
        session(['idBom' => $id_bom]);

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

        $statusAndKeterangan = $this->getStatusAndKeterangan($detailbom, $id_bom);
        $status = $statusAndKeterangan['status'];
        $keterangan = $statusAndKeterangan['keterangan'];

        // $this->CekMaterial($id_bom);
        // $this->updateStatusbom($id_bom); 

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
    
        // Cari Detailbom berdasarkan 'id_materialbom' dan 'id_bom'
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

        // dd([
        //     'CEKCEK' => $detailbomItem->getAttributes(),
        // ]);

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

            if (!$material) {
                $detailbom->db_status = 0;
                $detailbom->keterangan = "Material tidak ditemukan";
            } else {
                $usageMaterial = $detailbom->usage_material;
                $materialQty = $material->jumlah;

                if ($usageMaterial > $materialQty) {
                    $detailbom->db_status = 0;
                    $detailbom->keterangan = "Terdapat material kurang";
                } else {
                    $detailbom->db_status = 1;
                    $detailbom->keterangan = "Material BOM Sudah Cukup";
                }
            }
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
    
        // Periksa apakah ada material tertunda
        if ($notifMaterial->count() > 0) {
            // Anda dapat menyesuaikan konten email dan subjek sesuai kebutuhan
            $subjekEmail = "Notifikasi Material Tertunda";

            // Kumpulkan semua informasi dari $notifFg
            $dataMaterial = $notifMaterial->map(function ($material) {
                return [
                    'id_boms' => $material->id_boms,
                    'id_materialbom' => $material->id_materialbom,
                    'nama_materialbom' => $material->nama_materialbom,
                    'usage_material' => $material->usage_material,
                ];
            });

            // dd($notifMaterial);
    
            // Ambil informasi Stock berdasarkan item_code
            $stockInfo = Stock::where('item_code', $notifMaterial->first()->id_materialbom)->first();
            // dd($stockInfo);
            // Kirim email ke alamat yang ditentukan
            $alamatEmailPenerima = ['stevenliong83@gmail.com', 'steven.naga15@gmail.com'];
            Mail::to($alamatEmailPenerima)->send(new MaterialPendingNotification(
                $dataMaterial,
                $stockInfo,
                $subjekEmail,
                $idBom
            ));
    
            // Perbarui status email_status menjadi 1 untuk setiap data yang telah dikirimkan
            $notifMaterial->each(function ($material) {
                $material->update(['email_status' => 1]);
            });
        }
    }
    


    public function getStatusAndKeterangan($detailbom, $id_bom)
    {
        $status = "Completed";
        $detailbomForIdBom = $detailbom->where('id_boms', $id_bom);

        $countDbStatusZero = $detailbomForIdBom->where('db_status', 0)->count();

        $keterangan = "Semua Material Terpenuhi untuk Kode BOM $id_bom";

        if ($countDbStatusZero > 0) {
            $status = "Pending";
            $keterangan = "Terdapat Material Kurang";
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
        
        // Perbarui nilai submitted pada semua id_materialbom terkait
        Detailbom::where('id_boms', $idBom)->update(['submitted' => 1]);

        return redirect()->route('bom.detailbom', $idBom);
    }

    public function restoreMaterial(Request $request, $id_materialbom, $id_bom) {
        // Validate the request if needed
        
        // Fetch the record from the database
        $detailBom = Detailbom::where('id_materialbom', $id_materialbom)->where('id_boms', $id_bom)->first();

        if ($detailBom->submitted == 1) {
            $material = Material::where('kd_material', $detailBom->id_materialbom)->first();

            if ($material) {
                $material->jumlah += $detailBom->usage_material;
                $material->save();
            }
        }
        $detailBom->setAttribute('submitted', 0);
        $detailBom->save();

        return redirect()->back();
    }
}
