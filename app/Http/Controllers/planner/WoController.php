<?php

namespace App\Http\Controllers\planner;

use PDF;
use Excel;
use App\Exports\WoExport;
use App\Exports\PdfExport;
use App\Models\planner\Bom;
use App\Models\planner\So;
use App\Models\planner\Wo;
use Illuminate\Http\Request;
use App\Models\planner\Detailbom;
use Illuminate\Contracts\View\View;
use App\Models\produksi\DryCastResin;
use Illuminate\Http\RedirectResponse;
use App\Models\produksi\StandardizeWork;

class WoController extends Controller
{
    public function index()
    {
        // $dataWo = Wo::with('standardize_work')->get();
        $dataWo = Wo::all();
        // $workOrders = ModelWorkOrder::with('id_standardize_work')->get();
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
        $databom = Bom::where('id_fg', $idFg)        
        ->where('status_bom', 3)
        ->first();
        // dd($databom);
        $standardizeWork = StandardizeWork::where('id_fg', $idFg)->first();
        // dd($standardizeWork);

        //jadiin array
        $data = [
            'kd_manhour' => $standardizeWork->kd_manhour ?? null,
            'id_boms' => $databom->id_bom ?? null,
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
        
        $bom = Bom::where('id_fg', $id_fg)
        ->where('status_bom', 3)
        ->first();
        $standardizedWork = StandardizeWork::where('id_fg', $id_fg)->first();
        // dd($standardizedWork);

        if ($bom && $standardizedWork) {
            $wo->id_boms = $bom->id_bom;
            $wo->id_so = $bom->id_so;
            $wo->id_standardize_work = $standardizedWork->id;
        } else {
            return redirect()->back()->withInput()->withErrors(['error' => 'Terdapat Data yang Kosong']);
        }

        // dd($wo);
        $wo->save();

        return redirect()->route('workorder-index');
    }

    public function edit(string $id_wo): View
    {
        $detailWo = Wo::where('id_wo', $id_wo)->first();

        // Fetch additional data based on the selected id_fg
        $id_fg = $detailWo->id_fg;
        $dataBom = Bom::all();
        $databom = Bom::where('id_fg', $id_fg)
        ->where('status_bom', 3)
        ->first();
        $standardizeWork = StandardizeWork::where('id_fg', $id_fg)->first();

        $additionalData = [
            // 'id_standardize_work' => $standardizeWork->kd_manhour ?? null,
            'id_standardize_work' => $standardizeWork->id ?? null,
            'bom_code' => $databom->bom_code ?? null,
            'id_so' => $databom->id_so ?? null,
        ];

        return view('planner.wo.edit-wo', compact('detailWo', 'dataBom', 'additionalData'));
    }

    public function getDataWO($id_fg)
    {
        $dataBom = Bom::where('id_fg', $id_fg)
        ->where('status_bom', 3)
        ->first();
        $standardizedWork = StandardizeWork::where('id_fg', $id_fg)->first();

        $data = [
            'id_boms' => $dataBom->id_bom ?? '',
            'id_standardize_work' => $standardizedWork->kd_manhour ?? '',
            'id_so' => $dataBom->id_so ?? '',
        ];

        return response()->json($data);
    }

    public function update(Request $request, $id_wo): RedirectResponse
    {
        $this->validate($request, [
            'id_fg' => 'required|string',
            'qty_trafo' => 'required|integer',
            'kva' => 'required|integer',
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
            // 'id_boms' => 'required|string',
            // 'id_standardize_work' => 'required|string',
            // 'id_so' => 'required|string',

        ]);

        $detailWo = Wo::where('id_wo', $id_wo)->first();

        $id_fg = $request->id_fg;
        // dd($id_fg);
        $bom = Bom::where('id_fg', $id_fg)
        ->where('status_bom', 3)
        ->first();
        $standardizedWork = StandardizeWork::where('id_fg', $id_fg)->first();
        // dd($bom, $standardizedWork);

        // Fetch additional data based on the selected id_fg
        $databom = Bom::where('id_fg', $id_fg)->first();
        // dd($databom);

        // Update the Wo data based on the selected id_fg
        $detailWo->update([
            'id_boms' => $bom->id_bom,
            // 'id_standardize_work' => $standardizedWork->kd_manhour,
            'id_standardize_work' => $standardizedWork->id,
            // 'id_boms' => $request->id_boms,
            // 'id_standardize_work' => $request->id_standardize_work,
            // 'id_so' => $request->id_so,
            'id_fg' => $request->id_fg,
            'qty_trafo' => $request->qty_trafo,
            'kva' => $request->kva,
            'id_so' => $bom->id_so,
            'start_date' => $request->start_date,
            'finish_date' => $request->finish_date,
        ]);
        // dd($detailWo);

        // \Log::info('ID to Update:', $id_wo);


        return redirect()->route('workorder-index')->with('success', 'Data berhasil diupdate');
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