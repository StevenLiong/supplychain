<?php

namespace App\Http\Controllers\planner;

use PDF;
use Excel;
use App\Exports\WoExport;
use App\Exports\PdfExport;
use App\Models\planner\Bom;
use App\Models\planner\Wo;
use App\Models\planner\Mps;
use Illuminate\Http\Request;
use App\Models\planner\GPADry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
        $databom = Bom::where('id_fg', $idFg)        
            ->where('status_bom', 3)
            ->first();
    
        $standardizeWork = StandardizeWork::where('id_fg', $idFg)->first();
    
        if ($standardizeWork) {
            switch (true) {
                case !is_null($standardizeWork->id_dry_cast_resin):
                    $relatedTable = 'dry_cast_resins';
                    break;
                case !is_null($standardizeWork->id_dry_non_resin):
                    $relatedTable = 'dry_non_resins';
                    break;
                case !is_null($standardizeWork->id_ct):
                    $relatedTable = 'cts';
                    break;
                case !is_null($standardizeWork->id_vt):
                    $relatedTable = 'vts';
                    break;
                case !is_null($standardizeWork->id_repair):
                    $relatedTable = 'repairs';
                    break;
                default:
                    $relatedTable = null;
            }
        
            switch ($relatedTable) {
                case 'dry_cast_resins':
                    $dataTable = 'dry_cast_resin';
                    break;
                case 'dry_non_resins':
                    $dataTable = 'dry_non_resin';
                    break;
                case 'cts':
                    $dataTable = 'ct';
                    break;
                case 'vts':
                    $dataTable = 'vt';
                    break;
                case 'repairs':
                    $dataTable = 'repair';
                    break;
                default:
                    $dataTable = null;
            }
        }
        
        $data = [
            'kd_manhour' => $standardizeWork->kd_manhour ?? null,
            'id_boms' => $databom->id_bom ?? null,
            'id_so' => $databom->id_so ?? null,
            'kva' => $standardizeWork->$dataTable->ukuran_kapasitas ?? null,
            'keterangan' => $standardizeWork->$dataTable->keterangan ?? null,
        ];
    
        return response()->json($data);
    }

    public function store(Request $request): RedirectResponse
    {
        $wo = new Wo();
        $wo->id_wo = $request->get('id_wo');
        $id_wo = $request->get('id_wo');
        $wo->start_date = $request->get('start_date');
        $wo->finish_date = $request->get('finish_date');
        $wo->qty_trafo = $request->get('qty_trafo');
        $wo->kva = $request->get('kva');
        $id_fg = $request->get('id_fg');
        $wo->id_fg = $id_fg;

        $cekWo = Wo::where('id_wo', $id_wo)->exists();
        if ($cekWo) {
            return redirect()->back()->withInput()->withErrors(['error' => 'ID WO sudah terdaftar']);
        }
        
        $bom = Bom::where('id_fg', $id_fg)
        ->where('status_bom', 3)
        ->first();
        $standardizeWork = StandardizeWork::where('id_fg', $id_fg)->first();

        if ($bom && $standardizeWork) {
            $wo->id_boms = $bom->id_bom;
            $wo->id_so = $bom->id_so;
            $wo->id_standardize_work = $standardizeWork->id;

            switch (true) {
                case !is_null($standardizeWork->id_dry_cast_resin):
                    $relatedTable = 'dry_cast_resins';
                    break;
                case !is_null($standardizeWork->id_dry_non_resin):
                    $relatedTable = 'dry_non_resins';
                    break;
                case !is_null($standardizeWork->id_ct):
                    $relatedTable = 'cts';
                    break;
                case !is_null($standardizeWork->id_vt):
                    $relatedTable = 'vts';
                    break;
                case !is_null($standardizeWork->id_repair):
                    $relatedTable = 'repairs';
                    break;
                default:
                    $relatedTable = null;
            }
            switch ($relatedTable) {
                case 'dry_cast_resins':
                    $dataTable = 'dry_cast_resin';
                    break;
                case 'dry_non_resins':
                    $dataTable = 'dry_non_resin';
                    break;
                case 'cts':
                    $dataTable = 'ct';
                    break;
                case 'vts':
                    $dataTable = 'vt';
                    break;
                case 'repairs':
                    $dataTable = 'repair';
                    break;
                default:
                    $dataTable = null;
            }
            $wo->kva = $standardizeWork->$dataTable->ukuran_kapasitas;
            $wo->keterangan = $standardizeWork->$dataTable->keterangan;
            // dd($wo->kva);
        } else {
            return redirect()->back()->withInput()->withErrors(['error' => 'Terdapat Data yang Kosong']);
        }
        $wo->save();
        return redirect()->route('workorder-index');
    }

    public function edit(string $id_wo): View
    {
        $detailWo = Wo::where('id_wo', $id_wo)->first();

        $id_fg = $detailWo->id_fg;
        $dataBom = Bom::all();
        $databom = Bom::where('id_fg', $id_fg)
        ->where('status_bom', 3)
        ->first();
        $standardizeWork = StandardizeWork::where('id_fg', $id_fg)->first();

        if ($standardizeWork) {
            switch (true) {
                case !is_null($standardizeWork->id_dry_cast_resin):
                    $relatedTable = 'dry_cast_resins';
                    break;
                case !is_null($standardizeWork->id_dry_non_resin):
                    $relatedTable = 'dry_non_resins';
                    break;
                case !is_null($standardizeWork->id_ct):
                    $relatedTable = 'cts';
                    break;
                case !is_null($standardizeWork->id_vt):
                    $relatedTable = 'vts';
                    break;
                case !is_null($standardizeWork->id_repair):
                    $relatedTable = 'repairs';
                    break;
                default:
                    $relatedTable = null;
            }
        
            switch ($relatedTable) {
                case 'dry_cast_resins':
                    $dataTable = 'dry_cast_resin';
                    break;
                case 'dry_non_resins':
                    $dataTable = 'dry_non_resin';
                    break;
                case 'cts':
                    $dataTable = 'ct';
                    break;
                case 'vts':
                    $dataTable = 'vt';
                    break;
                case 'repairs':
                    $dataTable = 'repair';
                    break;
                default:
                    $dataTable = null;
            }
        }

        $additionalData = [
            // 'id_standardize_work' => $standardizeWork->kd_manhour ?? null,
            'id_standardize_work' => $standardizeWork->id ?? null,
            'bom_code' => $databom->bom_code ?? null,
            'id_so' => $databom->id_so ?? null,
            'kva' => $standardizeWork->$dataTable->ukuran_kapasitas ?? null,
            'keterangan' =>$standardizeWork->$dataTable->keterangan ?? null,
        ];

        return view('planner.wo.edit-wo', compact('detailWo', 'dataBom', 'additionalData'));
    }

    public function getDataWO($id_fg)
    {
        $dataBom = Bom::where('id_fg', $id_fg)
        ->where('status_bom', 3)
        ->first();
        $standardizeWork = StandardizeWork::where('id_fg', $id_fg)->first();

        if ($standardizeWork) {
            switch (true) {
                case !is_null($standardizeWork->id_dry_cast_resin):
                    $relatedTable = 'dry_cast_resins';
                    break;
                case !is_null($standardizeWork->id_dry_non_resin):
                    $relatedTable = 'dry_non_resins';
                    break;
                case !is_null($standardizeWork->id_ct):
                    $relatedTable = 'cts';
                    break;
                case !is_null($standardizeWork->id_vt):
                    $relatedTable = 'vts';
                    break;
                case !is_null($standardizeWork->id_repair):
                    $relatedTable = 'repairs';
                    break;
                default:
                    $relatedTable = null;
            }
        
            switch ($relatedTable) {
                case 'dry_cast_resins':
                    $dataTable = 'dry_cast_resin';
                    break;
                case 'dry_non_resins':
                    $dataTable = 'dry_non_resin';
                    break;
                case 'cts':
                    $dataTable = 'ct';
                    break;
                case 'vts':
                    $dataTable = 'vt';
                    break;
                case 'repairs':
                    $dataTable = 'repair';
                    break;
                default:
                    $dataTable = null;
            }
        }

        $data = [
            'id_boms' => $dataBom->id_bom ?? null,
            'id_standardize_work' => $standardizeWork->kd_manhour ?? null,
            'id_so' => $dataBom->id_so ?? null,
            'kva' => $standardizeWork->$dataTable->ukuran_kapasitas ?? null,
            'keterangan' => $standardizeWork->$dataTable->keterangan ?? null,

        ];

        return response()->json($data);
    }

    public function update(Request $request, $id_wo): RedirectResponse
    {
        $this->validate($request, [
            'id_fg' => 'required|string',
            'qty_trafo' => 'required|integer',
            // 'kva' => 'required|integer',
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
        ]);

        $detailWo = Wo::where('id_wo', $id_wo)->first();

        $id_fg = $request->id_fg;
        $bom = Bom::where('id_fg', $id_fg)
        ->where('status_bom', 3)
        ->first();
        $standardizeWork = StandardizeWork::where('id_fg', $id_fg)->first();

        if ($standardizeWork) {
            switch (true) {
                case !is_null($standardizeWork->id_dry_cast_resin):
                    $relatedTable = 'dry_cast_resins';
                    break;
                case !is_null($standardizeWork->id_dry_non_resin):
                    $relatedTable = 'dry_non_resins';
                    break;
                case !is_null($standardizeWork->id_ct):
                    $relatedTable = 'cts';
                    break;
                case !is_null($standardizeWork->id_vt):
                    $relatedTable = 'vts';
                    break;
                case !is_null($standardizeWork->id_repair):
                    $relatedTable = 'repairs';
                    break;
                default:
                    $relatedTable = null;
            }
        
            switch ($relatedTable) {
                case 'dry_cast_resins':
                    $dataTable = 'dry_cast_resin';
                    break;
                case 'dry_non_resins':
                    $dataTable = 'dry_non_resin';
                    break;
                case 'cts':
                    $dataTable = 'ct';
                    break;
                case 'vts':
                    $dataTable = 'vt';
                    break;
                case 'repairs':
                    $dataTable = 'repair';
                    break;
                default:
                    $dataTable = null;
            }
        }

        $detailWo->update([
            'id_boms' => $bom->id_bom,
            'id_standardize_work' => $standardizeWork->id,
            'id_fg' => $request->id_fg,
            'qty_trafo' => $request->qty_trafo,
            'kva' => $standardizeWork->$dataTable->ukuran_kapasitas,
            'keterangan' => $standardizeWork->$dataTable->keterangan,
            'id_so' => $bom->id_so,
            'start_date' => $request->start_date,
            'finish_date' => $request->finish_date,
        ]);
        return redirect()->route('workorder-index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id): RedirectResponse
    {
        $dataWo = Wo::where('id', $id)->first();
        $dataMps = Mps::where('id_wo', $id)->first();
        $gpaDry = GPADry::where('id_wo', $id)->get();
        foreach ($gpaDry as $gpa) {
            $gpa->delete();
        }
        if ($dataMps) {
            $dataMps->delete();
        }
        if ($dataWo) {
            $dataWo->delete();
        }
        return redirect()->route('workorder-index')->with('success', 'Data berhasil dihapus');
    }


    public function exportToExcel()
    {
        $dataWo = Wo::select('id_wo', 'id_boms', 'id_fg','kva' ,'qty_trafo', 'id_so', 'start_date', 'finish_date', 'keterangan', 'id_standardize_work')->get();
        // $manhour = $dataWo->standardize_work->kd_manhour;
        $id_wo = $dataWo->isNotEmpty() ? $dataWo->first()->id_wo : 'Kode WO Tidak Ada';
        return Excel::download(new WoExport($dataWo), "File Work Order $id_wo .xlsx");
        // return Excel::download(new WoExport, 'Work Order.xlsx');
    }

    public function exportToPdf()
    {
        $dataWo = Wo::select('id', 'id_wo', 'id_boms', 'id_standardize_work', 'qty_trafo', 'id_so', 'start_date', 'finish_date', 'keterangan', 'kva')->get();
        $id_wo = $dataWo->isNotEmpty() ? $dataWo->first()->id_wo : 'Kode WO Tidak Ada';
        $pdf = PDF::loadView('planner.wo.view', ['dataWo' => $dataWo]);
        return $pdf->download("Work Order $id_wo .pdf");
    }
}