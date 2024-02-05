<?php

namespace App\Http\Controllers\planner;

use App\Exports\MpsExport;
use PDF;
use App\Models\planner\Mps;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\planner\GPAOil;
use App\Models\planner\WorkcenterOilTrafo;
use Maatwebsite\Excel\Facades\Excel;

class GPAOilController extends Controller
{
    public function index()
    {
        $dataMps = Mps::all();
        return view('planner.gpa.indexgpaoil', compact('dataMps'));
    }

    public function gpaOilDetail(String $id_wo):View
    {
        $dataMps = Mps::where('id_wo', $id_wo)->first();
        $dataGpa = GPAOil::where('id_wo', $id_wo)->get();
        // dd($dataWorkcenter);
        return view('planner.gpa.detail-gpa-oil', compact('dataMps', 'dataGpa'));
    }

    public function exportToExcel()
    {
        $dataMps = Mps::select('id', 'id_wo', 'project', 'production_line', 'kva', 'jenis', 'qty_trafo', 'lead_time', 'deadline')->get(); // Ambil data Mps dari database

        return Excel::download(new MpsExport($dataMps), 'GPA.xlsx');
    }

    public function exportToPdf()
    {
        $dataMps = Mps::select('id', 'id_wo', 'production_line', 'kva', 'qty_trafo', 'deadline')->where('jenis', 'Oil Trafo')->get(); // Ambil data Mps dari database
        $pdf = PDF::loadView('planner.gpa.viewGPAoil', ['dataMps' => $dataMps]);
        return $pdf->download('GPA Oil Trafo.pdf');
    }

    public function exportToPdfDetail()
    {
        $dataMps = Mps::select('id', 'id_wo', 'production_line', 'kva', 'qty_trafo', 'deadline')->get(); // Ambil data Mps dari database
        $pdf = PDF::loadView('planner.gpa.view-detail-gpa-dry', ['dataMps' => $dataMps]);
        return $pdf->download('Detail GPA Oil Trafo.pdf');
    }
}