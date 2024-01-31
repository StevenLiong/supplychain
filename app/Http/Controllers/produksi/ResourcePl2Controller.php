<?php

namespace App\Http\Controllers\produksi;

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

            $periode = $request->session()->get('periode', 1);
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
            //FILTER PL
            // $filteredMpsPL2 = $mps->where('production_line', 'PL2');

            // //QTY PL
            // $qtyPL2 =  $filteredMpsPL2->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
            // dd($qtyPL2);
            $woPL2 = Mps::where('production_line', 'PL2')->pluck('id_wo');

            $jumlahtotalHourCoil_Making_HV = Mps::where('production_line', 'PL2')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.oil_standard'])
            ->whereIn('id_wo', $woPL2)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->oil_standard->hour_coil_hv * $item->qty_trafo;
            });

            $jumlahtotalHourCoil_Making_LV = Mps::where('production_line', 'PL2')
                // ->where('kva', $ukuran_kapasitas)
                ->whereBetween('deadline', $deadlineDate)
                ->with(['wo.standardize_work.oil_standard'])
                ->whereIn('id_wo', $woPL2)
                ->get()
                ->sum(function ($item) {
                    //ambil hour dulu baru dikali qty
                    $hourCoilLV = $item->wo->standardize_work->oil_standard->hour_coil_lv;
                    $hourPotongLeadwire = $item->wo->standardize_work->oil_standard->hour_potong_leadwire;
                    $hourPotongIsolasi = $item->wo->standardize_work->oil_standard->hour_potong_isolasi;
                    //dikali qty
                    return ($hourCoilLV + $hourPotongLeadwire + $hourPotongIsolasi) * $item->qty_trafo;
                });

            $jumlahtotalHourMould_Casting = Mps::where('production_line', 'PL2')->where('kva', $ukuran_kapasitas)
                ->with(['wo.standardize_work.oil_standard'])
                ->whereIn('id_wo', $woPL2)
                ->get()
                ->sum(function ($item) {
                    return $item->wo->standardize_work->oil_standard->totalHour_MouldCasting * $item->qty_trafo;
                });

            $jumlahtotalHourCore_Assembly = Mps::where('production_line', 'PL2')
                // ->where('kva', $ukuran_kapasitas)
                ->whereBetween('deadline', $deadlineDate)
                ->with(['wo.standardize_work.oil_standard'])
                ->whereIn('id_wo', $woPL2)
                ->get()
                ->sum(function ($item) {
                    return $item->wo->standardize_work->oil_standard->totalHour_CoreCoilAssembly * $item->qty_trafo;
                });


            switch ($periode) {
                case 1:
                    $kebutuhanMPCoil_Making_HV = $jumlahtotalHourCoil_Making_HV / (173  * 0.93);
                    $kebutuhanMPCoil_Making_LV = $jumlahtotalHourCoil_Making_LV / (173  * 0.93);
                    $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (173  * 0.93);
                    $kebutuhanMPCore_Assembly = $jumlahtotalHourCore_Assembly / (173  * 0.93);
                    break;
                case 2:
                    $kebutuhanMPCoil_Making_HV = $jumlahtotalHourCoil_Making_HV / (40  * 0.93);
                    $kebutuhanMPCoil_Making_LV = $jumlahtotalHourCoil_Making_LV / (40  * 0.93);
                    $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (40  * 0.93);
                    $kebutuhanMPCore_Assembly = $jumlahtotalHourCore_Assembly / (40  * 0.93);
                    break;
                case 3:
                    $kebutuhanMPCoil_Making_HV = $jumlahtotalHourCoil_Making_HV / (40  * 0.93);
                    $kebutuhanMPCoil_Making_LV = $jumlahtotalHourCoil_Making_LV / (40  * 0.93);
                    $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (40  * 0.93);
                    $kebutuhanMPCore_Assembly = $jumlahtotalHourCore_Assembly / (40  * 0.93);
                    break;
                case 4:
                    $kebutuhanMPCoil_Making_HV = $jumlahtotalHourCoil_Making_HV / (173  * 0.93);
                    $kebutuhanMPCoil_Making_LV = $jumlahtotalHourCoil_Making_LV / (173  * 0.93);
                    $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (173  * 0.93);
                    $kebutuhanMPCore_Assembly = $jumlahtotalHourCore_Assembly / (173  * 0.93);
                    break;
            }



            $selisihMPCoil_Making_HV = $kebutuhanMPCoil_Making_HV - $totalManPower;
            $selisihMPCoil_Making_LV = $kebutuhanMPCoil_Making_LV - $totalManPower;
            $selisihMPMould_Casting = $kebutuhanMPMould_Casting - $totalManPower;
            $selisihMPCore_Assembly = $kebutuhanMPCore_Assembly - $totalManPower;

            if ($kebutuhanMPCoil_Making_HV != 0) {
                $presentaseKurangMPCoil_Making_HV = ($selisihMPCoil_Making_HV / $kebutuhanMPCoil_Making_HV) * 100;
            } else {
                $presentaseKurangMPCoil_Making_HV = 0;
            }
            if ($kebutuhanMPCoil_Making_LV != 0) {
                $presentaseKurangMPCoil_Making_LV = ($selisihMPCoil_Making_LV / $kebutuhanMPCoil_Making_LV) * 100;
            } else {
                $presentaseKurangMPCoil_Making_LV = 0;
            }
            if ($kebutuhanMPMould_Casting != 0) {
                $presentaseKurangMPMould_Casting = ($selisihMPMould_Casting / $kebutuhanMPMould_Casting) * 100;
            } else {
                $presentaseKurangMPMould_Casting = 0;
            }
            if ($kebutuhanMPCore_Assembly != 0) {
                $presentaseKurangMPCore_Assembly = ($selisihMPCore_Assembly / $kebutuhanMPCore_Assembly) * 100;
            } else {
                $presentaseKurangMPCore_Assembly = 0;
            }

            $ketersediaanMPCoil_Making_HV = $kebutuhanMPCoil_Making_HV - ($kebutuhanMPCoil_Making_HV * $presentaseKurangMPCoil_Making_HV) / 100;
            $ketersediaanMPCoil_Making_LV = $kebutuhanMPCoil_Making_LV - ($kebutuhanMPCoil_Making_LV * $presentaseKurangMPCoil_Making_LV) / 100;
            $ketersediaanMPMould_Casting = $kebutuhanMPMould_Casting - ($kebutuhanMPMould_Casting * $presentaseKurangMPMould_Casting) / 100;
            $ketersediaanMPCore_Assembly = $kebutuhanMPCore_Assembly - ($kebutuhanMPCore_Assembly * $presentaseKurangMPCore_Assembly) / 100;

            if ($kebutuhanMPCoil_Making_HV <= $ketersediaanMPCoil_Making_HV) {
                $selisihMPCoil_Making_HV = 0;
                $ketersediaanMPCoil_Making_HV = $kebutuhanMPCoil_Making_HV;
            }
            if ($kebutuhanMPCoil_Making_LV <= $ketersediaanMPCoil_Making_LV) {
                $selisihMPCoil_Making_LV = 0;
                $ketersediaanMPCoil_Making_LV = $kebutuhanMPCoil_Making_LV;
            }
            if ($kebutuhanMPMould_Casting <= $ketersediaanMPMould_Casting) {
                $selisihMPMould_Casting = 0;
                $ketersediaanMPMould_Casting = $kebutuhanMPMould_Casting;
            }
            if ($kebutuhanMPCore_Assembly <= $ketersediaanMPCore_Assembly) {
                $selisihMPCore_Assembly = 0;
                $ketersediaanMPCore_Assembly = $kebutuhanMPCore_Assembly;
            }

            $wc_Coil_Making_HV =  'Coil Making HV';
            $wc_Coil_Making_LV =  'Coil Making LV';
            $wc_Mould_Casting =  'Mould & Casting';
            $wc_Core_Assembly =  'Core & Assembly';

            $data = [
                'jumlahtotalHourCoil_Making_LV' => $jumlahtotalHourCoil_Making_LV,
                'jumlahtotalHourCoil_Making_HV' => $jumlahtotalHourCoil_Making_HV,
                'jumlahtotalHourMould_Casting' => $jumlahtotalHourMould_Casting,
                'jumlahtotalHourCore_Assembly' => $jumlahtotalHourCore_Assembly,
                'selisihMPCoil_Making_HV' => $selisihMPCoil_Making_HV,
                'selisihMPCoil_Making_LV' => $selisihMPCoil_Making_LV,
                'selisihMPMould_Casting' => $selisihMPMould_Casting,
                'selisihMPCore_Assembly' => $selisihMPCore_Assembly,
                'totalManPower;' => $totalManPower,
                'kebutuhanMPCoil_Making_HV' => $kebutuhanMPCoil_Making_HV,
                'kebutuhanMPCoil_Making_LV' => $kebutuhanMPCoil_Making_LV,
                'kebutuhanMPMould_Casting' => $kebutuhanMPMould_Casting,
                'kebutuhanMPCore_Assembly' => $kebutuhanMPCore_Assembly,
                'wc_Coil_Making_HV' => $wc_Coil_Making_HV,
                'wc_Coil_Making_LV' => $wc_Coil_Making_LV,
                'wc_Mould_Casting' => $wc_Mould_Casting,
                'wc_Core_Assembly' => $wc_Core_Assembly,
                'ketersediaanMPCoil_Making_HV' => $ketersediaanMPCoil_Making_HV,
                'ketersediaanMPCoil_Making_LV' => $ketersediaanMPCoil_Making_LV,
                'ketersediaanMPMould_Casting' => $ketersediaanMPMould_Casting,
                'ketersediaanMPCore_Assembly' => $ketersediaanMPCore_Assembly,
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
