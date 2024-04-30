<?php

namespace App\Http\Controllers\planner;

use App\Models\planner\So;
use App\Models\planner\Bom;
use App\Models\planner\Detailbom;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\planner\Bomv2;
use App\Models\planner\Detailbomv2;
use Illuminate\Http\RedirectResponse;

class BomControllerV2 extends Controller
{

    public function dashboard()
    {
        return view('planner.dashboard.index');
    }
    
    public function index()
    {
        $dataBom = Bomv2::all();
        $detailBom = Detailbomv2::all();

        return view('planner.bom_v2.index', compact('dataBom', 'detailBom'));
    }

    // //CREATE BOM
    // public function create()
    // {
    //     return view('planner.bom_v2.create-bom');
    // }

    // //STORE DATA CREATE BOM
    // public function store(Request $request): RedirectResponse
    // {
    //     $id_so = $request->get('id_so');

    //     $bom = new Bom();
    //     $bom->id_bom = $request->get('id_bom');
    //     $id_bom = $request->get('id_bom');
    //     $bom->qty_bom = $request->get('qty_bom');
    //     $bom->bom_status = "Aktif";
    //     // $bom->bom_status = $request->get('bom_status');
    //     $bom->uom_bom = $request->get('uom_bom');
    //     // $bom->id_so = $request->get('id_so');
    //     $bom->id_so = $id_so;
    //     $bom->id_fg = $request->get('id_fg');

    //     $cekBom = Bom::where('id_bom', $id_bom)->exists();
    //     if ($cekBom) {
    //         return redirect()->back()->withInput()->withErrors(['error' => 'ID Bill of Material sudah terdaftar']);
    //     }

    //     $bom->save();
    
    //     $idBom = $bom->id_bom;

    //     $cekSO = So::where('kode_so', $id_so)->first();

    //     if (!$cekSO) {
    //         $so = new So();
    //         $so->kode_so = $id_so;
    //         $so->save();
    //     }

    //     session(['idBom' => $idBom]);
    
    //     return redirect()->route('bom_v2-upload-excel', ['idBom' => $idBom]);
    // }
    
    //  // EDIT BOM INFO
    //  public function infoBom(string $id_bom) :View
    //  {
    //      $dataBom = Bom::where('id_bom', $id_bom)
    //          ->first();
 
    //      return view('planner.bom_v2.edit-bominfo', compact('dataBom'));
    //  }
 
    //  // UPDATE BOM INFO
    //  public function updateBom(Request $request, $id_bom){
    //     $this->validate($request, [
    //         'qty_bom' => 'required|integer',
    //         'bom_status' => 'required|string',
    //         'uom_bom' => 'required|string',
    //     ]);
    
    //     $editBom = Bom::where('id_bom', $id_bom)->first();
    
    //     $editBom->update([
    //         'qty_bom' => $request->qty_bom,
    //         'bom_status' => $request->bom_status,
    //         'uom_bom' => $request->uom_bom,
    //     ]);
    
    //     return redirect()->route('bom_v2-index');
    // }
    
    //HAPUS BOM
    public function destroy($id_bom) : RedirectResponse
    {
        $dataBom = Bomv2::where('id_bom', $id_bom)
            ->first();
        
        $id_bom = $dataBom->id_bom;

        Detailbomv2::where('id_boms', $id_bom)->delete();

        $dataBom->delete();

        return redirect()->route('bom_v2-index')->with('success', 'Data berhasil dihapus');        
    }

}