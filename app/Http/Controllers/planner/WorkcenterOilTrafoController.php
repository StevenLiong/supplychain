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

    public function wcoildetail(String $nama_workcenter): View
    {
        // Ambil data WorkcenterDryType berdasarkan nama_workcenter yang diberikan
        $dataWorkcenter = WorkcenterOilTrafo::where('nama_workcenter', $nama_workcenter)->first();
        $dataGpa = GPAOil::all();
        // dd($dataGpa);

        // Inisialisasi array untuk menyimpan id_wo dan deadlineWc
        $deadlines = [];
        
        // Cek nama_workcenter
        if ($nama_workcenter === 'Insulation Paper') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc1,
                    'deadlineWc' => $item->deadline_wc1
                ];
            }
        } elseif ($nama_workcenter === 'Supply Material Paper & Coil') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc2,
                    'deadlineWc' => $item->deadline_wc2
                ];
            }
        } elseif ($nama_workcenter === 'Core & Fixing Parts') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc3,
                    'deadlineWc' => $item->deadline_wc3
                ];
            }
        } elseif ($nama_workcenter === 'Supply Stacking Core (Produksi)') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc4,
                    'deadlineWc' => $item->deadline_wc4
                ];
            }
        } elseif ($nama_workcenter === 'LV Windling') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc5,
                    'deadlineWc' => $item->deadline_wc5
                ];
            }
        } elseif ($nama_workcenter === 'HV Windling') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc6,
                    'deadlineWc' => $item->deadline_wc6
                ];
            }
        } elseif ($nama_workcenter === 'Core Coil Assembly') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc7,
                    'deadlineWc' => $item->deadline_wc7
                ];
            }
        } elseif ($nama_workcenter === 'Supply Material Connection') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc8,
                    'deadlineWc' => $item->deadline_wc8
                ];
            }
        } elseif ($nama_workcenter === 'Connection') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc9,
                    'deadlineWc' => $item->deadline_wc9
                ];
            }
        } elseif ($nama_workcenter === 'Supply Tangki') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc10,
                    'deadlineWc' => $item->deadline_wc10
                ];
            }
        } elseif ($nama_workcenter === 'Supply Material Final Assembly & Finishing') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc11,
                    'deadlineWc' => $item->deadline_wc11
                ];
            }
        } elseif ($nama_workcenter === 'Oven') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc12,
                    'deadlineWc' => $item->deadline_wc12
                ];
            }
        } elseif ($nama_workcenter === 'Final Assembly') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc13,
                    'deadlineWc' => $item->deadline_wc13
                ];
            }
        } elseif ($nama_workcenter === 'Finishing') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc14,
                    'deadlineWc' => $item->deadline_wc14
                ];
            }
        } elseif ($nama_workcenter === 'Quality Control') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc15,
                    'deadlineWc' => $item->deadline_wc15
                ];
            }
        } elseif ($nama_workcenter === 'Quality Control Transfer ke Gudang') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc16,
                    'deadlineWc' => $item->deadline_wc16
                ];
            }
        }

        // dd($deadlines);

        return view('planner.WC.detailworkcenterdrytype', compact('dataWorkcenter','dataGpa', 'deadlines'));
    }

    public function exportToPDF(String $nama_workcenter)
    {
        $dataWorkcenter = WorkcenterOilTrafo::where('nama_workcenter', $nama_workcenter)->first();
        $dataGpa = GPAOil::all();
         // Inisialisasi array untuk menyimpan id_wo dan deadlineWc
         $deadlines = [];
        
         // Cek nama_workcenter
        if ($nama_workcenter === 'Insulation Paper') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc1,
                    'deadlineWc' => $item->deadline_wc1
                ];
            }
        } elseif ($nama_workcenter === 'Supply Material Paper & Coil') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc2,
                    'deadlineWc' => $item->deadline_wc2
                ];
            }
        } elseif ($nama_workcenter === 'Core & Fixing Parts') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc3,
                    'deadlineWc' => $item->deadline_wc3
                ];
            }
        } elseif ($nama_workcenter === 'Supply Stacking Core (Produksi)') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc4,
                    'deadlineWc' => $item->deadline_wc4
                ];
            }
        } elseif ($nama_workcenter === 'LV Windling') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc5,
                    'deadlineWc' => $item->deadline_wc5
                ];
            }
        } elseif ($nama_workcenter === 'HV Windling') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc6,
                    'deadlineWc' => $item->deadline_wc6
                ];
            }
        } elseif ($nama_workcenter === 'Core Coil Assembly') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc7,
                    'deadlineWc' => $item->deadline_wc7
                ];
            }
        } elseif ($nama_workcenter === 'Supply Material Connection') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc8,
                    'deadlineWc' => $item->deadline_wc8
                ];
            }
        } elseif ($nama_workcenter === 'Connection') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc9,
                    'deadlineWc' => $item->deadline_wc9
                ];
            }
        } elseif ($nama_workcenter === 'Supply Tangki') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc10,
                    'deadlineWc' => $item->deadline_wc10
                ];
            }
        } elseif ($nama_workcenter === 'Supply Material Final Assembly & Finishing') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc11,
                    'deadlineWc' => $item->deadline_wc11
                ];
            }
        } elseif ($nama_workcenter === 'Oven') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc12,
                    'deadlineWc' => $item->deadline_wc12
                ];
            }
        } elseif ($nama_workcenter === 'Final Assembly') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc13,
                    'deadlineWc' => $item->deadline_wc13
                ];
            }
        } elseif ($nama_workcenter === 'Finishing') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc14,
                    'deadlineWc' => $item->deadline_wc14
                ];
            }
        } elseif ($nama_workcenter === 'Quality Control') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc15,
                    'deadlineWc' => $item->deadline_wc15
                ];
            }
        } elseif ($nama_workcenter === 'Quality Control Transfer ke Gudang') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc16,
                    'deadlineWc' => $item->deadline_wc16
                ];
            }
        }

        $filename = 'Detail Workcenter ' . ($nama_workcenter) . ' Oil Trafo' . '.pdf';

        $pdf = PDF::loadView('planner.WC.exportpdfoil', compact('dataWorkcenter', 'dataGpa', 'deadlines'));

        // Jika ingin men-download PDF langsung
        return $pdf->download($filename);
        
        // Jika ingin menampilkan PDF dalam browser
        // return $pdf->stream('export.pdf');
    }
}