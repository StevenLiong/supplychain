<?php

namespace App\Http\Controllers\planner;

use PDF;
use App\Exports\MpsExport;
use App\Models\planner\Mps;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\planner\GPADry;
use App\Models\planner\WorkcenterDryType;
use Maatwebsite\Excel\Facades\Excel;

class GPADryController extends Controller
{
    public function index()
    {
        $dataMps = Mps::all();
        return view('planner.gpa.indexgpadry', compact('dataMps'));
    }

    public function gpaDryDetail(String $id_wo):View
    {
        $dataMps = Mps::where('id_wo', $id_wo)->first();
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
        $dataMps = Mps::select('id', 'id_wo', 'production_line', 'kva', 'qty_trafo', 'deadline')->where('jenis', 'Dry Type')->get(); // Ambil data Mps dari database
        $pdf = PDF::loadView('planner.gpa.view', ['dataMps' => $dataMps]);
        return $pdf->download('GPA Dry Type.pdf');
    }

    public function exportToPdfDetail(Request $request, $id_wo)
    {
        $dataMps = MPS::where('id_wo', $id_wo)
        ->select('deadline')
        ->get();
        $dataGpa = GPADry::where('id_wo', $id_wo)
        ->select('id', 'id_wo', 'production_line', 'kva', 'qty_trafo', 'deadline', 'nama_workcenter')
        ->get();
        $pdf = PDF::loadView('planner.gpa.view-detail-gpa-dry', ['dataGpa' => $dataGpa, 'dataMps' => $dataMps]);
        return $pdf->download('Detail GPA Dry Type.pdf');
    }
}