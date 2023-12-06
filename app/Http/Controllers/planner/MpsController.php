<?php

namespace App\Http\Controllers\planner;
use PDF;
use App\Exports\MpsExport;
use App\Exports\PdfExport;
use App\Models\planner\Wo;
use App\Models\planner\Mps;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\produksi\DryCastResin;
use Illuminate\Http\RedirectResponse;

class MpsController extends Controller
{
    public function index()
    {
        $dataMps = Mps::all();
        return view('planner.mps.index', compact('dataMps'));
    }

    public function upload()
    {
        $dataWo = Wo::all(); // Mengambil nilai 'id_wo' dari tabel Wo
        return view('planner.MPS.upload-mps', ['dataWo' => $dataWo]);
    }

    public function store(Request $request): RedirectResponse
    {
        // $dataWo = Wo::where('id_wo', $request->get('id_wo'))->first();
        // session(['idWo' => $id_wo]);
        // $dryCastResin = DryCastResin::where('id_wo', $request->get('id_wo'))->first();
    
        // if($dryCastResin) {
        //     $manHourCode = $dryCastResin->man_hour_code; // Ambil Man Hour Code dari Dry Cast Resin
        //     // Kemudian isi field Man Hour Code di form
        //     return view('planner.mps.index', compact('dataMps'))->with('manHourCode', $manHourCode);
        // }
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

        if($request->get('jenis') === 'Dry Type') {
            return redirect()->route('gpa-indexgpadry'); // Redirect ke indexgpadry jika jenis adalah 'Dry Type'
        }
        else($request->get('jenis') === 'Oil Trafo'); {
            return redirect()->route('gpa-indexgpaoil'); // Redirect ke indexgpaoil jika jenis adalah 'Oil Type'
        }
    
        // return redirect()->route('mps-index'); // Jika jenis bukan 'Dry Type', redirect ke halaman mps-index biasa
    }

    public function getTotalHour($id)
    {
        $totalHour = DryCastResin::where('total_hour', $id)->get();

        return response()->json($totalHour);
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