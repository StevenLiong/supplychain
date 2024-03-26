<?php

namespace App\Http\Controllers\produksi\ResourceWorkPlanning;

use App\Http\Controllers\Controller;
use App\Models\planner\Mps;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\ManPower;
use App\Models\produksi\OilStandard;
use App\Models\produksi\ProductionLine;
use Illuminate\Http\Request;

class ResourcePl2Controller extends Controller
{
    function pl2Rekomendasi()
    {
        $title1 = 'PL 2 - Rekomendasi';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.PL2.rekomendasi', ['data' => $data]);
    }

    function pl2Kebutuhan(Request $request)
    {
        $totalManPower = ManPower::count();
        $title1 = 'PL 2 - Kebutuhan';
        $PL = ProductionLine::all();
        $kapasitas = Kapasitas::all();
        $mps = Mps::where('production_line', 'PL2')->get();
        $oilStandard = OilStandard::all();
        $ukuran_kapasitas = Kapasitas::value('ukuran_kapasitas');

        $periode = $request->post('periodePL2', null);
        if ($periode === null || !in_array($periode, [1, 2, 3, 4])) {
            // Mengambil nilai dari local storage jika ada
            $storedValue = $request->session()->get('selectedPeriodePL2');
            $periode = ($storedValue && in_array($storedValue, [1, 2, 3, 4])) ? $storedValue : 1;
        }

        switch ($periode) {
            case 1:
                $deadlineDate = [
                    now()->startOfMonth(),
                    now()->endOfMonth(),
                ];
                break;

            case 2:
                $deadlineDate = [
                    now()->startOfWeek(),
                    now()->endOfWeek(),
                ];
                break;

            case 3:
                $deadlineDate = [
                    now()->startOfWeek()->addWeek(),
                    now()->endOfWeek()->addWeek(),
                ];
                break;

            case 4:
                $deadlineDate = [
                    now()->addMonth()->startOfMonth(),
                    now()->addMonth()->endOfMonth(),
                ];
                break;
        }

        $request->session()->put('selectedPeriodePL2', $periode);

        //FILTER PL
        $filteredMpsPL2 = $mps->where('production_line', 'PL2');

        // //QTY PL
        $qtyPL2 =  $filteredMpsPL2->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
        // dd($qtyPL2);

        $woPL2 = Mps::where('production_line', 'PL2')->pluck('id_wo');

        $jumlahtotalHourCoil_Making = Mps::where('production_line', 'PL2')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.oil_standard'])
            ->whereIn('id_wo', $woPL2)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->oil_standard->totalHour_coil_making * $item->qty_trafo;
            });

        // dd($woPL2);
        $jumlahtotalHour_CoreCoilAssembly = Mps::where('production_line', 'PL2')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.oil_standard'])
            ->whereIn('id_wo', $woPL2)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->oil_standard->totalHour_CoreCoilAssembly * $item->qty_trafo;
            });

        $jumlahtotalHour_Conect = Mps::where('production_line', 'PL2')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.oil_standard'])
            ->whereIn('id_wo', $woPL2)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->oil_standard->totalHour_Conect * $item->qty_trafo;
            });

        $jumlahtotalHour_FinalAssembly = Mps::where('production_line', 'PL2')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.oil_standard'])
            ->whereIn('id_wo', $woPL2)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->oil_standard->totalHour_FinalAssembly * $item->qty_trafo;
            });

        switch ($periode) {
            case 1:
                $kebutuhanMPCoil_Making = $jumlahtotalHourCoil_Making / (173  * 0.93);
                $kebutuhanMPCoreCoilAssembly = $jumlahtotalHour_CoreCoilAssembly / (173  * 0.93);
                $kebutuhanMPConect = $jumlahtotalHour_Conect / (173  * 0.93);
                $kebutuhanMPFinal_Assembly = $jumlahtotalHour_FinalAssembly / (173  * 0.93);
                break;
            case 2:
                $kebutuhanMPCoil_Making = $jumlahtotalHourCoil_Making / (40  * 0.93);
                $kebutuhanMPCoreCoilAssembly = $jumlahtotalHour_CoreCoilAssembly / (40  * 0.93);
                $kebutuhanMPConect = $jumlahtotalHour_Conect / (40  * 0.93);
                $kebutuhanMPFinal_Assembly = $jumlahtotalHour_FinalAssembly / (40  * 0.93);
                break;
            case 3:
                $kebutuhanMPCoil_Making = $jumlahtotalHourCoil_Making / (40  * 0.93);
                $kebutuhanMPCoreCoilAssembly = $jumlahtotalHour_CoreCoilAssembly / (40  * 0.93);
                $kebutuhanMPConect = $jumlahtotalHour_Conect / (40  * 0.93);
                $kebutuhanMPFinal_Assembly = $jumlahtotalHour_FinalAssembly / (40  * 0.93);
                break;
            case 4:
                $kebutuhanMPCoil_Making = $jumlahtotalHourCoil_Making / (173  * 0.93);
                $kebutuhanMPCoreCoilAssembly = $jumlahtotalHour_CoreCoilAssembly / (173  * 0.93);
                $kebutuhanMPConect = $jumlahtotalHour_Conect / (173  * 0.93);
                $kebutuhanMPFinal_Assembly = $jumlahtotalHour_FinalAssembly / (173  * 0.93);
                break;
        }



        $selisihMPCoil_Making = $kebutuhanMPCoil_Making - $totalManPower;
        $selisihMPCoreCoilAssembly = $kebutuhanMPCoreCoilAssembly - $totalManPower;
        $selisihMPConect = $kebutuhanMPConect - $totalManPower;
        $selisihMPFinal_Assembly = $kebutuhanMPFinal_Assembly - $totalManPower;

        if ($kebutuhanMPCoil_Making != 0) {
            $presentaseKurangMPCoil_Making = ($selisihMPCoil_Making / $kebutuhanMPCoil_Making) * 100;
        } else {
            $presentaseKurangMPCoil_Making = 0;
        }
        if ($kebutuhanMPCoreCoilAssembly != 0) {
            $presentaseKurangMPCoreCoilAssembly = ($selisihMPCoreCoilAssembly / $kebutuhanMPCoreCoilAssembly) * 100;
        } else {
            $presentaseKurangMPCoreCoilAssembly = 0;
        }
        if ($kebutuhanMPConect != 0) {
            $presentaseKurangMPConect = ($selisihMPConect / $kebutuhanMPConect) * 100;
        } else {
            $presentaseKurangMPConect = 0;
        }
        if ($kebutuhanMPFinal_Assembly != 0) {
            $presentaseKurangMPFinal_Assembly = ($selisihMPFinal_Assembly / $kebutuhanMPFinal_Assembly) * 100;
        } else {
            $presentaseKurangMPFinal_Assembly = 0;
        }

        $ketersediaanMPCoil_Making = $kebutuhanMPCoil_Making - ($kebutuhanMPCoil_Making * $presentaseKurangMPCoil_Making) / 100;
        $ketersediaanMPCoreCoilAssembly = $kebutuhanMPCoreCoilAssembly - ($kebutuhanMPCoreCoilAssembly * $presentaseKurangMPCoreCoilAssembly) / 100;
        $ketersediaanMPConect = $kebutuhanMPConect - ($kebutuhanMPConect * $presentaseKurangMPConect) / 100;
        $ketersediaanMPFinal_Assembly = $kebutuhanMPFinal_Assembly - ($kebutuhanMPFinal_Assembly * $presentaseKurangMPFinal_Assembly) / 100;

        if ($kebutuhanMPCoil_Making <= $ketersediaanMPCoil_Making) {
            $selisihMPCoil_Making = 0;
            $ketersediaanMPCoil_Making = $kebutuhanMPCoil_Making;
        }
        if ($kebutuhanMPCoreCoilAssembly <= $ketersediaanMPCoreCoilAssembly) {
            $selisihMPCoreCoilAssembly = 0;
            $ketersediaanMPCoreCoilAssembly = $kebutuhanMPCoreCoilAssembly;
        }
        if ($kebutuhanMPConect <= $ketersediaanMPConect) {
            $selisihMPConect = 0;
            $ketersediaanMPConect = $kebutuhanMPConect;
        }
        if ($kebutuhanMPFinal_Assembly <= $ketersediaanMPFinal_Assembly) {
            $selisihMPFinal_Assembly = 0;
            $ketersediaanMPFinal_Assembly = $kebutuhanMPFinal_Assembly;
        }

        $wc_Coil_Making =  'Coil Making ';
        $wc_CCA =  'CCA';
        $wc_Conect =  'Conect';
        $wc_Final_Assembly =  'Final Assembly';

        $data = [
            'jumlahtotalHourCoil_Making' => $jumlahtotalHourCoil_Making,
            'jumlahtotalHour_CoreCoilAssembly' => $jumlahtotalHour_CoreCoilAssembly,
            'jumlahtotalHour_Conect' => $jumlahtotalHour_Conect,
            'jumlahtotalHour_FinalAssembly' => $jumlahtotalHour_FinalAssembly,
            'selisihMPCoil_Making' => $selisihMPCoil_Making,
            'selisihMPCoreCoilAssembly' => $selisihMPCoreCoilAssembly,
            'selisihMPConect' => $selisihMPConect,
            'selisihMPFinal_Assembly' => $selisihMPFinal_Assembly,
            'totalManPower;' => $totalManPower,
            'kebutuhanMPCoil_Making' => $kebutuhanMPCoil_Making,
            'kebutuhanMPCoreCoilAssembly' => $kebutuhanMPCoreCoilAssembly,
            'kebutuhanMPConect' => $kebutuhanMPConect,
            'kebutuhanMPFinal_Assembly' => $kebutuhanMPFinal_Assembly,
            'wc_Coil_Making' => $wc_Coil_Making,
            'wc_CCA' => $wc_CCA,
            'wc_Conect' => $wc_Conect,
            'wc_Final_Assembly' => $wc_Final_Assembly,
            'ketersediaanMPCoil_Making' => $ketersediaanMPCoil_Making,
            'ketersediaanMPCoreCoilAssembly' => $ketersediaanMPCoreCoilAssembly,
            'ketersediaanMPConect' => $ketersediaanMPConect,
            'ketersediaanMPFinal_Assembly' => $ketersediaanMPFinal_Assembly,
            'title1' => $title1,
            'mps' => $mps,
            'kapasitas' => $kapasitas,
            'PL' => $PL,
            'deadlineDate' => $deadlineDate,
            'oilStandard' => $oilStandard,
        ];
        return view('produksi.resource_work_planning.PL2.kebutuhan', ['data' => $data]);
    }
}
