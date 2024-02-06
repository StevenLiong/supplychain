<?php

namespace App\Http\Controllers\planner;

use PDF;
use App\Models\planner\Mps;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\planner\GPAOil;
use App\Models\planner\WorkcenterOilTrafo;

class WorkcenterOilTrafoController extends Controller
{
    public function index()
    {
        $dataWorkcenter = WorkcenterOilTrafo::select('nama_workcenter')->get();
        return view('planner.WC.indexworkcenteroil', compact('dataWorkcenter'));
    }

    public function wcoildetail(String $nama_workcenter):View
    {
        $dataWorkcenter = WorkcenterOilTrafo::where('nama_workcenter', $nama_workcenter)->first();
        $dataGpa = GPAOil::where('nama_workcenter', $nama_workcenter)->get();
        return view('planner.WC.detailworkcenteroil', compact('dataWorkcenter', 'dataGpa'));
    }

    public function exportToPDF(String $nama_workcenter)
    {
        $dataWorkcenter = WorkcenterOilTrafo::where('nama_workcenter', $nama_workcenter)->first();
        $dataGpa = GPAOil::where('nama_workcenter', $nama_workcenter)->get();

        $filename = 'Detail Workcenter ' . ($nama_workcenter) . ' Oil Trafo' . '.pdf';

        $pdf = PDF::loadView('planner.WC.exportpdfoil', compact('dataWorkcenter', 'dataGpa'));

        // Jika ingin men-download PDF langsung
        return $pdf->download($filename);
        
        // Jika ingin menampilkan PDF dalam browser
        // return $pdf->stream('export.pdf');
    }
}