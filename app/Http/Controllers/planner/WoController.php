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
            'dataSo' => So::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {   
        $wo = new Wo();
        $wo-> id_wo = $request->get('id_wo');
        $wo->id_so = $request->get('id_so');
        $wo->id_boms = $request->get('id_boms');
        $wo->id_manhour = $request->get('id_manhour');
        $wo->start_date = $request->get('start_date');
        $wo->finish_date = $request->get('finish_date');
        $wo->qty_trafo = $request->get('qty_trafo');
        // dd($request->all());

        $wo->save();

        // $idBom = $wo->id_bom;

        // // Simpan idBom dalam sesi
        // session(['idBom' => $idBom]);

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
            'id_manhour' => 'required|string',
            'qty_trafo' => 'required|integer',
            'id_so' => 'required|string',
            'start_date' => 'required|date',
            'finish_date'=> 'required|date',
        ]);

        $detailWo -> update([
            'id_boms' => $request->id_boms,
            'id_wo'=> $request->id_wo,
            'id_manhour'=> $request->id_manhour,
            'qty_trafo'=> $request->qty_trafo,
            'id_so'=> $request->id_so,
            'start_date'=> $request->start_date,
            'finish_date'=> $request->finish_date,
        ]);

        return redirect()->route('workorder-index');
    }

    public function exportToExcel()
    {
        $dataWo = Wo::select('id', 'id_wo', 'id_boms', 'id_manhour', 'qty_trafo', 'id_so', 'start_date', 'finish_date')->get(); // Ambil data Wo dari database

        return Excel::download(new WoExport($dataWo), 'WO.xlsx');
    }

    public function exportToPdf()
    {
        $dataWo = Wo::select('id', 'id_wo', 'id_boms', 'id_manhour', 'qty_trafo', 'id_so', 'start_date', 'finish_date')->get(); // Ambil data Mps dari database
        $pdf = PDF::loadView('planner.wo.view', ['dataWo' => $dataWo]);
        return $pdf->download('WO.pdf');
}
}
