<?php

namespace App\Http\Controllers\planner;

use PDF;
use App\Exports\MpsExport;
use App\Models\planner\Mps;
use App\Models\planner\Mps2;
use Illuminate\Http\Request;
use App\Models\planner\GPADry;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\planner\WorkcenterDryType;

class GPADryController extends Controller
{
    public function index()
    {
        $dataMps = Mps2::all();
        return view('planner.gpa.indexgpadry', compact('dataMps'));
    }

    public function gpaDryDetail(String $id_wo):View
    {
        $dataMps = Mps2::where('id_wo', $id_wo)->first();
        $dataGpa = GPADry::where('id_wo', $id_wo)->get();
    
        return view('planner.gpa.detail-gpa-dry', compact('dataMps', 'dataGpa'));
    }

    public function exportToExcel()
    {
        $dataMps = Mps::select('id', 'id_wo', 'project', 'production_line', 'kva', 'jenis', 'qty_trafo', 'deadline')->get(); // Ambil data Mps dari database

        return Excel::download(new MpsExport($dataMps), 'GPA.xlsx');
    }

    public function exportToPdf()
    {
        $dataMps = Mps2::select('id', 'id_wo', 'production_line', 'kva', 'qty_trafo', 'deadline')->where('production_line', 'Dry')->get(); // Ambil data Mps dari database
        $pdf = PDF::loadView('planner.gpa.view', ['dataMps' => $dataMps]);
        return $pdf->download('GPA Dry Type.pdf');
    }

    public function exportToPdfDetail(Request $request, $id_wo)
    {
        $dataMps = Mps2::where('id_wo', $id_wo)
        ->select('deadline')
        ->get();
        // dd($dataMps);
        $dataGpa = GPADry::where('id_wo', $id_wo)
        ->select('id', 'id_wo', 'production_line', 'kva', 'qty_trafo', 'start', 'nama_workcenter', 'keterangan')
        ->get();
        // Menyimpan keterangan yang sesuai dengan workcenter "Finishing"
        $keteranganFinishing = $dataGpa->where('nama_workcenter', 'Finishing')->first()->keterangan ?? '';
        $pdf = PDF::loadView('planner.gpa.view-detail-gpa-dry', ['dataGpa' => $dataGpa, 'dataMps' => $dataMps, 'keteranganFinishing' => $keteranganFinishing,]);
        return $pdf->download('Detail GPA Dry Type.pdf');
    }
}