<?php

namespace App\Http\Controllers\planner;

use App\Models\planner\Wo;
use App\Models\planner\So;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Exports\WoExport;
use Excel;
use PDF;
use App\Exports\PdfExport;
use App\Models\planner\Bom;
use App\Models\produksi\StandardizeWork;

class WoController extends Controller
{
    public function index()
    {
        $dataWo = Wo::all();
        return view('planner.wo.index', compact('dataWo'));
    }

    public function create()
    {
        return view('planner.WO.create-wo',[
            'dataBom' =>Bom::all()
        ]);
    }

    public function getDataByIdFg($idFg)
    {
        // NARIK DATA BOM DAN STANDARDIZED PAKE ID_FG
        $databom = Bom::where('id_fg', $idFg)->first();
        $standardizeWork = StandardizeWork::where('id_fg', $idFg)->first();

        //jadiin array
        $data = [
            'kd_manhour' => $standardizeWork->kd_manhour ?? null,
            'id_boms' => $databom->id_bom ?? null,
            'qty_trafo' => $databom->qty_bom ?? null,
            'id_so' => $databom->id_so ?? null,
        ];

        return response()->json($data);
    }

    public function store(Request $request): RedirectResponse
    {
        $wo = new Wo();
        $wo->id_wo = $request->get('id_wo');
        $wo->start_date = $request->get('start_date');
        $wo->finish_date = $request->get('finish_date');
        $wo->qty_trafo = $request->get('qty_trafo');
        $wo->kva = $request->get('kva');
        $id_fg = $request->get('id_fg');
        $wo->id_fg = $id_fg;
        
        $bom = Bom::where('id_fg', $id_fg)->first();
        $standardizedWork = StandardizeWork::where('id_fg', $id_fg)->first();

        if ($bom && $standardizedWork) {
            $wo->id_boms = $bom->id_bom;
            $wo->qty_trafo = $bom->qty_bom;
            $wo->id_so = $bom->id_so;
            $wo->id_standardize_work = $standardizedWork->kd_manhour;
        }

        $wo->save();

        return redirect()->route('workorder-index');
    }

    public function edit(string $id_wo): View
    {
        $detailWo = Wo::where('id_wo', $id_wo)->first();

        $id_wo = session('idWo');
        return view('planner.wo.edit-wo', compact('detailWo'));
    }

    public function update(Request $request, $id_wo): RedirectResponse
    {   
        $detailWo = Wo::where('id_wo', $id_wo)->first();
        $this->validate($request, [
            'id_boms' => 'required|string',
            'id_wo' => 'required|string',
            'id_standardize_work' => 'required|string',
            'qty_trafo' => 'required|integer',
            'id_fg' => 'required|string',
            'kva' => 'required|integer',
            'id_so' => 'required|string',
            'start_date' => 'required|date',
            'finish_date'=> 'required|date',
        ]);

        $detailWo -> update([
            'id_boms' => $request->id_boms,
            'id_wo'=> $request->id_wo,
            'id_standardize_work'=> $request->id_standardize_work,
            'id_fg'=> $request->id_fg,
            'qty_trafo'=> $request->qty_trafo,
            'kva' => $request->kva,
            'id_so'=> $request->id_so,
            'start_date'=> $request->start_date,
            'finish_date'=> $request->finish_date,
        ]);

        return redirect()->route('workorder-index');
    }

    public function destroy($id_wo) : RedirectResponse
    {
        $dataWo = Wo::where('id_wo', $id_wo)
            ->first();
        
        $dataWo->delete();

        return redirect()->route('workorder-index')->with('success', 'Data berhasil dihapus');        
    }

    public function exportToExcel()
    {
        $dataWo = Wo::select('id', 'id_wo', 'id_boms', 'id_standardize_work', 'qty_trafo', 'id_so', 'start_date', 'finish_date')->get(); // Ambil data Wo dari database

        return Excel::download(new WoExport($dataWo), 'WO.xlsx');
    }

    public function exportToPdf()
    {
        $dataWo = Wo::select('id', 'id_wo', 'id_boms', 'id_standardize_work', 'qty_trafo', 'id_so', 'start_date', 'finish_date')->get(); // Ambil data Mps dari database
        $pdf = PDF::loadView('planner.wo.view', ['dataWo' => $dataWo]);
        return $pdf->download('WO.pdf');
    }
}