<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Models\planner\Mps;
use App\Models\planner\Mps2;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\ProductionLine;
use Illuminate\Http\Request;

class ResourceWorkloadController extends Controller
{
    function Workload(Request $request)
    {
        $PL = ProductionLine::all();
        $title1 = ' Work Load';
        $mps = Mps2::all();
        $kapasitas = Kapasitas::all();
        $periode = $request->post('periodeWorkload', null);

        if ($periode === null || !in_array($periode, [1, 2, 3, 4])) {
            // Mengambil nilai dari local storage jika ada
            $storedValue = $request->session()->get('selectedPeriodeWorkload');
            $periode = ($storedValue && in_array($storedValue, [1, 2, 3, 4])) ? $storedValue : 1;
        }
        switch ($periode) {
            case 1:
                // $periodeLabel = 'Bulan Sekarang';
                $deadlineDate = [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ];
                break;

            case 2:
                // $periodeLabel = 'Minggu Sekarang';
                $deadlineDate = [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ];
                break;

            case 3:
                // $periodeLabel = 'Minggu Depan';
                $deadlineDate = [
                    now()->startOfWeek()->addWeek(),
                    now()->endOfWeek()->addWeek()
                ];
                break;

            case 4:
                // $periodeLabel = 'Bulan Depan';
                $deadlineDate = [
                    now()->addMonth()->startOfMonth(),
                    now()->addMonth()->endOfMonth()
                ];
                break;
        }
        $request->session()->put('selectedPeriodeWorkload', $periode);

        $data = [
            'title1' => $title1,
            'mps' => $mps,
            'kapasitas' => $kapasitas,
            'PL' => $PL,
            'deadlineDate' => $deadlineDate,
        ];

        return view('produksi.resource_work_planning.work-load', ['data' => $data]);
        // return view('produksi.resource_work_planning.work-load', compact('periodeLabel'), ['data' => $data]);
    }
}
