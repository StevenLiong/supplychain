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
        $keterangan = '';

        // Cari keterangan yang sesuai dengan nama_workcenter 'Finishing'
        foreach ($dataGpa as $gpa) {
            if ($gpa->nama_workcenter === 'Finishing') {
                $keterangan = $gpa->keterangan;
                break;
            }
        }
        return view('planner.gpa.detail-gpa-dry', compact('dataMps', 'dataGpa', 'keterangan'));
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
        ->select('id', 'id_wo', 'production_line', 'kva', 'qty_trafo', 'deadline', 'nama_workcenter', 'keterangan')
        ->get();
        // Menyimpan keterangan yang sesuai dengan workcenter "Finishing"
        $keteranganFinishing = $dataGpa->where('nama_workcenter', 'Finishing')->first()->keterangan ?? '';
        $pdf = PDF::loadView('planner.gpa.view-detail-gpa-dry', ['dataGpa' => $dataGpa, 'dataMps' => $dataMps, 'keteranganFinishing' => $keteranganFinishing,]);
        return $pdf->download('Detail GPA Dry Type.pdf');
    }
}