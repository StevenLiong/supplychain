<?php

namespace App\Http\Controllers\planner;

use App\Imports\BomImport;
use App\Models\planner\Bom;
use App\Models\planner\Detailbom;
use App\Models\planner\Material;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class DetailbomController extends Controller
{

    public function index()
    {
        $detailBom = Detailbom::all();

        return view('planner.bom.index', compact('dataBom', 'detailBom'));
    }

    public function bomDetail(String $id_bom)
    {
        $dataBom = Bom::where('id_bom', $id_bom)->first(); // Ubah query untuk mengambil BOM yang sesuai
        session(['idBom' => $id_bom]);

        $detailbom = Detailbom::with('bom')
            ->where('id_boms', $id_bom)
            ->orderBy('id_boms')
            ->get();

        $unsubmittedDetailBom = Detailbom::where('id_boms', $id_bom)
        ->where('submitted', false)
        ->get();

        $submittedDetailBom = Detailbom::where('id_boms', $id_bom)
        ->where('submitted', true)
        ->get();

        // Menghitung status dan keterangan
        $statusAndKeterangan = $this->getStatusAndKeterangan($detailbom, $id_bom);
        $status = $statusAndKeterangan['status'];
        $keterangan = $statusAndKeterangan['keterangan'];

        $this->CekMaterial($id_bom);

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
        // Dapatkan data Bom berdasarkan idBom
        $bom = Bom::find($idBom);

        return view('planner.bom.upload-bom', ['bom' => $bom]);
    }

    public function upload(Request $request){
        // Dapatkan idBom dari sesi
        $idBom = session('idBom');

        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        // Ambil file yang diunggah dari request
        $file = $request->file('file');

        // Buat instance BomImport dengan menyediakan idBom
        $import = new BomImport($idBom);

        // Import data dari file Excel
        Excel::import($import, $file);
            return redirect('/BOM/IndexBom')->with('success','Data Berhasil Diimport!');
    }

    public function addmaterial(Request $request, $id_bom)
    {
        $boms = Bom::all();
        return view('planner.bom.add-material', compact('id_bom', 'boms'));
    }

    // Storematerial
    public function storematerial(Request $request) : RedirectResponse
    {
        $material = new Detailbom();
        $material->id_boms = $request->get('id_boms');
        $material->nama_workcenter = $request->get('nama_workcenter');
        $material->id_materialbom = $request->get('id_materialbom');
        $material->nama_materialbom = $request->get('nama_materialbom');
        $material->uom_material = $request->get('uom_material');
        $material->qty_trafo = $request->get('qty_trafo');
        $material->qty_material = $request->get('qty_material');
        $material->tolerance = $request->get('tolerance');
        $usagematerial = $request->qty_trafo * $request->qty_material;
        $material->usage_material = $usagematerial;
        
        // dd($request->all());
        $material->save();

        $id_bom = request('id_boms');
        
        return redirect()->route('bom.detailbom', ['id_bom' => $id_bom]);
    }

    public function edit(string $id_materialbom, string $id_bom): View
    {
        // Cari Detailbom berdasarkan 'id_materialbom' dan 'id_bom'
        $detailbomItem = Detailbom::where('id_materialbom', $id_materialbom)
            ->where('id_boms', $id_bom)
            ->first();

        $id_bom = session('idBom');
        return view('bom.edit-material', compact('detailbomItem', 'id_bom'));
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
            'tolerance' => 'required|integer',
        ]);

        // Cari Detailbom berdasarkan 'id_materialbom' dan 'id_bom'
        $detailbomItem = Detailbom::where('id_materialbom', $id_materialbom)
            ->where('id_boms', $id_bom)
            ->first();

        $usagematerial = $request->qty_trafo * $request->qty_material;

        $detailbomItem->update([
            'nama_workcenter' => $request->nama_workcenter,
            'id_materialbom' => $request->id_materialbom,
            'nama_materialbom' => $request->nama_materialbom,
            'uom_material' => $request->uom_material,
            'qty_trafo' => $request->qty_trafo,
            'qty_material' => $request->qty_material,
            'tolerance' => $request->tolerance,
            'usage_material' => $usagematerial, // Assign the calculated total to the 'Total' column
        ]);

        return redirect()->route('bom.detailbom', ['id_bom' =>$idBom]);
    }
    
    public function deleteMaterial($id_materialbom, $id_bom)
    {
        // dd($id_materialbom);
        // $detailBom = Detailbom::find($id_materialbom);
        $detailBom = Detailbom::where('id_materialbom', $id_materialbom) ->first();
        // dd($detailBom);
    
        if (!$detailBom) {
            return redirect()->back()->with('error', 'Detail BOM tidak ditemukan.');
        }
    
        Detailbom::where('id_materialbom', $id_materialbom) -> delete();
        $detailBom->delete();
    
        return redirect()->back()->with('success', 'Material berhasil dihapus.');
    }

    public function CekMaterial($id_bom)
    {
        $detailboms = Detailbom::where('id_boms', $id_bom)->get();

        foreach ($detailboms as $detailbom) {
            // Cek apakah sudah submitted, jika sudah, lanjut ke iterasi berikutnya
            if ($detailbom->submitted == 1) {
                continue;
            }

            $material = Material::where('kd_material', $detailbom->id_materialbom)->first();

            if (!$material) {
                // Jika material tidak ditemukan
                $detailbom->db_status = 0; // Not Submitted
                $detailbom->keterangan = "Material tidak ditemukan";
            } else {
                $usageMaterial = $detailbom->usage_material;
                $materialQty = $material->jumlah;

                if ($usageMaterial > $materialQty) {
                    // Jika usage material lebih besar daripada jumlah material
                    $detailbom->db_status = 0; // Pending
                    $detailbom->keterangan = "Terdapat material kurang";
                } else {
                    // Jika usage material cukup
                    $detailbom->db_status = 1; // Completed
                    $detailbom->keterangan = "Material BOM Sudah Cukup";
                }
            }
            $detailbom->save();
        }

        $this->updateStatusbom($id_bom);

        return redirect()->back()->with('success', 'Status detail BOM diperbarui.');
    }


    public function getStatusAndKeterangan($detailbom, $id_bom)
    {
        // Ini untuk setting dan mengecek nilai db_status
        $status = "Completed"; // Default status "Completed"
        $detailbomForIdBom = $detailbom->where('id_boms', $id_bom); // Filter detailbom by id_bom

        // Hitung jumlah db_status = 0
        $countDbStatusZero = $detailbomForIdBom->where('db_status', 0)->count();

        // Inisialisasi keterangan
        $keterangan = "Semua Material Terpenuhi untuk Kode BOM $id_bom";

        // Set status dan keterangan berdasarkan jumlah db_status = 0
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

        // Ambil semua detail BOM berdasarkan id_bom
        $detailboms = Detailbom::where('id_boms', $idBom)->get();

        // Default status_bom
        $statusBom = 1;

        // Cek apakah ada detail BOM dengan db_status = 0
        if ($detailboms->contains('db_status', 0)) {
            $statusBom = 0;
        }

        // Update status_bom pada tabel boms
        Bom::where('id_bom', $id_bom)->update(['status_bom' => $statusBom]);
    }

    public function submit(Request $request)
    {
        $idBom = $request->get('id_bom');
        $detailBoms = $request->get('id_boms', []);

        // Cek apakah ada detail BOM dengan status "Pending"
        $pendingDetailBom = collect($detailBoms)->first(function ($detailBom) {
            return $detailBom['db_status'] == 0;
        });

        // Jika ada detail BOM dengan status "Pending", kembalikan response dengan pesan error
        if ($pendingDetailBom) {
            return redirect()->back()->with('error', 'Tidak bisa submit, masih terdapat material yang belum mencukupi.');
        }

        // Inisialisasi array untuk menyimpan id_materialbom yang sudah di-submit
        $submittedIds = [];

        foreach ($detailBoms as $idMaterialBom => $detailBom) {
        // Perbarui status 'submitted' menjadi true pada Detailbom
            Detailbom::where('id_materialbom', $idMaterialBom)->update(['submitted' => 1]);
            $submittedIds[] = $idMaterialBom;

            // Lanjutkan dengan proses pengurangan stok
            $material = Material::where('kd_material', $idMaterialBom)->first();
            if ($material) {
                $material->jumlah -= $detailBom['usage_material'];
                $material->save();
            }
        }

        // Jika masih ada id_materialbom yang belum di-submit, set status 'submitted' menjadi true
        Detailbom::whereNotIn('id_materialbom', $submittedIds)->update(['submitted' => 1]);

        return redirect()->route('bom.detailbom', $idBom)->with('success', 'BOM berhasil disubmit.');
    }

    public function restoreMaterial($id_materialbom, $id_bom): RedirectResponse
    {
        $detailBom = Detailbom::where('id_materialbom', $id_materialbom) ->first();
        // dd($detailBom);

        // Pemeriksaan apakah detail BOM ditemukan
        if (!$detailBom) {
            return redirect()->back()->with('error', 'Detail BOM tidak ditemukan.');
        }

        // Pemeriksaan apakah submitted bernilai 1
        if ($detailBom->submitted == 1) {
            // Tambahkan kembali ke stok
            $material = Material::where('kd_material', $detailBom->id_materialbom)->first();

            // Pemeriksaan apakah material ditemukan
            if ($material) {
                $material->jumlah += $detailBom->usage_material;
                $material->save();
            }
        }

        // Lakukan restore
        $detailBom->setAttribute('submitted', 0);
        $detailBom->save();

        return redirect()->back()->with('success', 'Material berhasil direstore.');

    }

}