<?php

namespace App\Http\Controllers\planner;
use App\Exports\MpsExport;
use Excel;
use PDF;
use App\Models\planner\Mps;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Exports\PdfExport;

class MpsController extends Controller
{
    public function index()
    {
        $dataMps = Mps::all();
        return view('planner.mps.index', compact('dataMps'));
    }

    public function upload()
    {
        return view('planner.MPS.upload-mps');
    }

    public function store(Request $request): RedirectResponse
    {
        $mps = new Mps();
        $mps->id_wo = $request->get('id_wo');
        $mps->project = $request->get('project');
        $mps->production_line = $request->get('production_line');
        $mps->kva = $request->get('kva');
        $mps->jenis = $request->get('jenis');
        $mps->qty_trafo = $request->get('qty_trafo');
        $mps->lead_time = $request->get('lead_time');
        $mps->deadline = $request->get('deadline');

        $mps->save();

        return redirect()->route('mps-index');
    }

    public function exportToExcel()
    {
        $dataMps = Mps::select('id', 'id_wo', 'project', 'production_line', 'kva', 'jenis', 'qty_trafo', 'lead_time', 'deadline')->get(); // Ambil data Mps dari database

        return Excel::download(new MpsExport($dataMps), 'MPS.xlsx');
    }

    public function exportToPdf()
    {
        $dataMps = Mps::select('id', 'id_wo', 'project', 'production_line', 'kva', 'jenis', 'qty_trafo', 'lead_time', 'deadline')->get(); // Ambil data Mps dari database
        $pdf = PDF::loadView('planner.mps.view', ['dataMps' => $dataMps]);
        return $pdf->download('MPS.pdf');
    }

}