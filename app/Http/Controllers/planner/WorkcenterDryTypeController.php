<?php

namespace App\Http\Controllers\planner;

use PDF;
use App\Models\planner\Mps;
use Illuminate\Http\Request;
use App\Models\planner\GPADry;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\planner\WorkcenterDryType;

class WorkcenterDryTypeController extends Controller
{
    public function index()
    {
        $dataWorkcenter = WorkcenterDryType::select('nama_workcenter')->get();
        return view('planner.WC.indexworkcenterdrytype', compact('dataWorkcenter'));
    }

    public function wcdrytypedetail(String $nama_workcenter): View
    {
        // Ambil data WorkcenterDryType berdasarkan nama_workcenter yang diberikan
        $dataWorkcenter = WorkcenterDryType::where('nama_workcenter', $nama_workcenter)->first();
        $dataGpa = GPADry::all();
        // dd($dataGpa);

        // Inisialisasi array untuk menyimpan id_wo dan deadlineWc
        $deadlines = [];
        
        // Cek nama_workcenter
        if ($nama_workcenter === 'Bill Of Material') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc1,
                    'deadlineWc' => $item->deadline_wc1
                ];
            }
        } elseif ($nama_workcenter === 'Insulation Paper') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc2,
                    'deadlineWc' => $item->deadline_wc2
                ];
            }
        } elseif ($nama_workcenter === 'Supply Material Insulation & Coil') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc3,
                    'deadlineWc' => $item->deadline_wc3
                ];
            }
        } elseif ($nama_workcenter === 'Supply Material Moulding') {
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
        } elseif ($nama_workcenter === 'Core') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc7,
                    'deadlineWc' => $item->deadline_wc7
                ];
            }
        } elseif ($nama_workcenter === 'Supply Fixing Parts & Core') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc8,
                    'deadlineWc' => $item->deadline_wc8
                ];
            }
        } elseif ($nama_workcenter === 'Moulding') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc9,
                    'deadlineWc' => $item->deadline_wc9
                ];
            }
        } elseif ($nama_workcenter === 'Susun Core') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc10,
                    'deadlineWc' => $item->deadline_wc10
                ];
            }
        } elseif ($nama_workcenter === 'Supply Material Connection & Final Assembly') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc11,
                    'deadlineWc' => $item->deadline_wc11
                ];
            }
        } elseif ($nama_workcenter === 'Connection & Final Assembly') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc12,
                    'deadlineWc' => $item->deadline_wc12
                ];
            }
        } elseif ($nama_workcenter === 'Finishing') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc13,
                    'deadlineWc' => $item->deadline_wc13
                ];
            }
        } elseif ($nama_workcenter === 'Quality Control') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc14,
                    'deadlineWc' => $item->deadline_wc14
                ];
            }
        } elseif ($nama_workcenter === 'Quality Control Transfer Gudang') {
            foreach ($dataGpa as $item) {
                $deadlines[] = [
                    'id_wo' => $item->id_wo,
                    'startWc' => $item->start_wc15,
                    'deadlineWc' => $item->deadline_wc15
                ];
            }
        }

        // dd($deadlines);

        return view('planner.WC.detailworkcenterdrytype', compact('dataWorkcenter','dataGpa', 'deadlines'));
    }

    public function exportToPDF(String $nama_workcenter)
    {
        $dataWorkcenter = WorkcenterDryType::where('nama_workcenter', $nama_workcenter)->first();
        $dataGpa = GPADry::all();
         // Inisialisasi array untuk menyimpan id_wo dan deadlineWc
         $deadlines = [];
        
         // Cek nama_workcenter
         if ($nama_workcenter === 'Bill Of Material') {
             foreach ($dataGpa as $item) {
                 $deadlines[] = [
                     'id_wo' => $item->id_wo,
                     'startWc' => $item->start_wc1,
                     'deadlineWc' => $item->deadline_wc1
                 ];
             }
         } elseif ($nama_workcenter === 'Insulation Paper') {
             foreach ($dataGpa as $item) {
                 $deadlines[] = [
                     'id_wo' => $item->id_wo,
                     'startWc' => $item->start_wc2,
                     'deadlineWc' => $item->deadline_wc2
                 ];
             }
         } elseif ($nama_workcenter === 'Supply Material Insulation & Coil') {
             foreach ($dataGpa as $item) {
                 $deadlines[] = [
                     'id_wo' => $item->id_wo,
                     'startWc' => $item->start_wc3,
                     'deadlineWc' => $item->deadline_wc3
                 ];
             }
         } elseif ($nama_workcenter === 'Supply Material Moulding') {
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
         } elseif ($nama_workcenter === 'Core') {
             foreach ($dataGpa as $item) {
                 $deadlines[] = [
                     'id_wo' => $item->id_wo,
                     'startWc' => $item->start_wc7,
                     'deadlineWc' => $item->deadline_wc7
                 ];
             }
         } elseif ($nama_workcenter === 'Supply Fixing Parts & Core') {
             foreach ($dataGpa as $item) {
                 $deadlines[] = [
                     'id_wo' => $item->id_wo,
                     'startWc' => $item->start_wc8,
                     'deadlineWc' => $item->deadline_wc8
                 ];
             }
         } elseif ($nama_workcenter === 'Moulding') {
             foreach ($dataGpa as $item) {
                 $deadlines[] = [
                     'id_wo' => $item->id_wo,
                     'startWc' => $item->start_wc9,
                     'deadlineWc' => $item->deadline_wc9
                 ];
             }
         } elseif ($nama_workcenter === 'Susun Core') {
             foreach ($dataGpa as $item) {
                 $deadlines[] = [
                     'id_wo' => $item->id_wo,
                     'startWc' => $item->start_wc10,
                     'deadlineWc' => $item->deadline_wc10
                 ];
             }
         } elseif ($nama_workcenter === 'Supply Material Connection & Final Assembly') {
             foreach ($dataGpa as $item) {
                 $deadlines[] = [
                     'id_wo' => $item->id_wo,
                     'startWc' => $item->start_wc11,
                     'deadlineWc' => $item->deadline_wc11
                 ];
             }
         } elseif ($nama_workcenter === 'Connection & Final Assembly') {
             foreach ($dataGpa as $item) {
                 $deadlines[] = [
                     'id_wo' => $item->id_wo,
                     'startWc' => $item->start_wc12,
                     'deadlineWc' => $item->deadline_wc12
                 ];
             }
         } elseif ($nama_workcenter === 'Finishing') {
             foreach ($dataGpa as $item) {
                 $deadlines[] = [
                     'id_wo' => $item->id_wo,
                     'startWc' => $item->start_wc13,
                     'deadlineWc' => $item->deadline_wc13
                 ];
             }
         } elseif ($nama_workcenter === 'Quality Control') {
             foreach ($dataGpa as $item) {
                 $deadlines[] = [
                     'id_wo' => $item->id_wo,
                     'startWc' => $item->start_wc14,
                     'deadlineWc' => $item->deadline_wc14
                 ];
             }
         } elseif ($nama_workcenter === 'Quality Control Transfer Gudang') {
             foreach ($dataGpa as $item) {
                 $deadlines[] = [
                     'id_wo' => $item->id_wo,
                     'startWc' => $item->start_wc15,
                     'deadlineWc' => $item->deadline_wc15
                 ];
             }
         }

        $filename = 'Detail Workcenter ' . ($nama_workcenter) . ' Dry Type' . '.pdf';

        $pdf = PDF::loadView('planner.WC.exportpdfdry', compact('dataWorkcenter', 'dataGpa', 'deadlines'));

        // Jika ingin men-download PDF langsung
        return $pdf->download($filename);
        
        // Jika ingin menampilkan PDF dalam browser
        // return $pdf->stream('export.pdf');
    }
}