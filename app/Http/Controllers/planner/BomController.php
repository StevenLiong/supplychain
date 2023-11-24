<?php

namespace App\Http\Controllers\planner;

use App\Models\planner\So;
use App\Models\planner\Bom;
use App\Models\planner\Detailbom;
use Illuminate\Http\Request;
use App\Exports\BomDetailExport;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;

class BomController extends Controller
{
    public function index()
    {
        $dataBom = Bom::all(); // Mengambil semua data dari model 'Bom'
        $detailBom = Detailbom::all();

        return view('planner.bom.index', compact('dataBom', 'detailBom'));
    }

    //CREATE BOM
    public function create()
    {
        // return view('bom.create-bom');
        return view('planner.bom.create-bom');
    }

    //STORE DATA CREATE BOM
    public function store(Request $request): RedirectResponse
    {
        // Simpan BOM yang terkait
        $bom = new Bom();
        $bom->id_bom = $request->get('id_bom');
        $bom->qty_bom = $request->get('qty_bom');
        $bom->bom_status = "Aktif";
        // $bom->bom_status = $request->get('bom_status');
        $bom->uom_bom = $request->get('uom_bom');
        $bom->id_so = $request->get('id_so');
        $bom->id_fg = $request->get('id_fg');

        $bom->save();
    
        $idBom = $bom->id_bom;

        $so = new So();
        $so->kode_so = $request->get('id_so');
        $so->save();

        // Simpan idBom dalam sesi
        session(['idBom' => $idBom]);
    
        return redirect()->route('bom-upload-excel', ['idBom' => $idBom]);
    }
    
     // EDIT BOM INFO
     public function infoBom(string $id_bom) :View
     {
         $dataBom = Bom::where('id_bom', $id_bom)
             ->first();
 
         return view('planner.bom.edit-bominfo', compact('dataBom'));
     }
 
     // UPDATE BOM INFO
     public function updateBom(Request $request, $id_bom){
        $this->validate($request, [
            'qty_bom' => 'required|integer',
            'bom_status' => 'required|string',
            'uom_bom' => 'required|string',
        ]);
    
        $editBom = Bom::where('id_bom', $id_bom)->first();
    
        $editBom->update([
            'qty_bom' => $request->qty_bom,
            'bom_status' => $request->bom_status,
            'uom_bom' => $request->uom_bom,
        ]);
    
        return redirect()->route('bom-index');
    }
    

    //HAPUS BOM
    public function destroy($id_bom, $id_boms) : RedirectResponse
    {
        $dataBom = Bom::where('id_bom', $id_bom)
            ->first();

        if(!$dataBom){
            return redirect()->route('bom-index')->with('error', 'Data tidak ditemukan');
        }
        
        $id_bom = $dataBom->id_bom;

        Detailbom::where('id_boms', $id_bom)->delete();

        $dataBom->delete();

        return redirect()->route('bom-index')->with('success', 'Data berhasil dihapus');        
    }

}