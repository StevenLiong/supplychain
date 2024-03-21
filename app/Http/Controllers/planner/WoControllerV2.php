<?php

namespace App\Http\Controllers\planner;

use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WoExport;
use App\Imports\WoImport;
use App\Models\planner\Bom;
use App\Models\planner\Wo;
use App\Models\planner\Mps;
use Illuminate\Http\Request;
use App\Models\planner\GPADry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\produksi\StandardizeWork;
use PhpOffice\PhpSpreadsheet\IOFactory;

class WoControllerV2 extends Controller
{
    public function index()
    {
        $dataWo = Wo::all();
        return view('planner.wo_v2.index', compact('dataWo'));
    }

    public function formUpload()
    {
        return view('planner.WO_v2.upload-wo');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();

        // $get_idboms = $worksheet->getCell('F5')->getValue(); //get_idboms mengambil seluruh value

        for ($row = 4; $row <= 1000; $row++) {
            $id_wo = $worksheet->getCell("B$row")->getValue();
            $wo_begin = $worksheet->getCell("C$row")->getFormattedValue();
            $wo_end = $worksheet->getCell("D$row")->getFormattedValue();
            $bom = $worksheet->getCell("N$row")->getValue();
            $id_fg = $worksheet->getCell("O$row")->getValue();
            $qty = $worksheet->getCell("P$row")->getValue();
    
            $existing_wo = Wo::where('id_wo', $id_wo)->first();
    
            if (!$existing_wo && $id_wo !== null) {
                $wo = new Wo();
                $wo->id_wo = $id_wo;
                $wo->start_date = $wo_begin;
                $wo->finish_date = $wo_end;
                $wo->id_fg = $id_fg;
                $wo->qty_trafo = $qty;
                $wo->id_boms = $bom;
                $wo->save();
            }
        }
        return redirect('/WorkOrderV2/IndexWorkOrder');
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

        return view('planner.wo.edit-wo', compact('detailWo', 'dataBom', 'additionalData'));
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

        $detailWo->update([
            'id_boms' => $bom->id_bom,
            'id_standardize_work' => $standardizeWork->id,
            'id_fg' => $request->id_fg,
            'qty_trafo' => $request->qty_trafo,
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
        return redirect()->route('workorder_v2-index')->with('success', 'Data berhasil dihapus');
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