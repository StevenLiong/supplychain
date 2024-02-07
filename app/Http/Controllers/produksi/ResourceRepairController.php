<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Models\planner\Mps;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\ManPower;
use App\Models\produksi\ProductionLine;
use App\Models\produksi\Repair;
use Illuminate\Http\Request;

class ResourceRepairController extends Controller
{
    function repairRekomendasi()
    {
        $title1 = 'Repair - Rekomendasi';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.REPAIR.rekomendasi', ['data' => $data]);
    }

    function repairKebutuhan(Request $request)
    {
        $title1 = 'Repair - Kebutuhan';
        $totalManPower = ManPower::count();
        $PL = ProductionLine::all();
        $kapasitas = Kapasitas::all();
        $mps = Mps::where('production_line', 'REPAIR')->get();
        $repair = Repair::all();
        $ukuran_kapasitas = Kapasitas::value('ukuran_kapasitas');

        $periode = $request->post('periodeRepair', null);

        if ($periode === null || !in_array($periode, [1, 2, 3, 4])) {
            // Mengambil nilai dari local storage jika ada
            $storedValue = $request->session()->get('selectedPeriodeRepair');
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

        $request->session()->put('selectedPeriodeRepair', $periode);

        //FILTER PL
        $filteredMpsRepair = $mps->where('production_line', 'REPAIR');

        // //QTY PL
        $qtyRepair =  $filteredMpsRepair->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
        // dd($qtyRepair);

        $woRepair = Mps::where('production_line', 'REPAIR')->pluck('id_wo');

        $jumlahtotalHour_untangking = Mps::where('production_line', 'REPAIR')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.repair'])
            ->whereIn('id_wo', $woRepair)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->repair->totalHour_untangking * $item->qty_trafo;
            });

        // // dd($woRepair);
        $jumlahtotalHour_bongkar = Mps::where('production_line', 'REPAIR')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.repair'])
            ->whereIn('id_wo', $woRepair)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->repair->totalHour_bongkar * $item->qty_trafo;
            });

        $jumlahtotalHourCoil_Making = Mps::where('production_line', 'REPAIR')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.repair'])
            ->whereIn('id_wo', $woRepair)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->repair->totalHour_coil_making * $item->qty_trafo;
            });
        $jumlahtotalHour_CoreAssembly = Mps::where('production_line', 'REPAIR')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.repair'])
            ->whereIn('id_wo', $woRepair)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->repair->totalHour_CoreAssembly * $item->qty_trafo;
            });
        $jumlahtotalHour_ConectAssembly = Mps::where('production_line', 'REPAIR')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.repair'])
            ->whereIn('id_wo', $woRepair)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->repair->totalHour_ConectAssembly * $item->qty_trafo;
            });
        $jumlahtotalHour_FinalAssembly = Mps::where('production_line', 'REPAIR')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.repair'])
            ->whereIn('id_wo', $woRepair)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->repair->totalHour_FinalAssembly * $item->qty_trafo;
            });

        $jumlahtotalHour_SpecialFinalAssembly = Mps::where('production_line', 'REPAIR')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.repair'])
            ->whereIn('id_wo', $woRepair)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->repair->totalHour_SpecialFinalAssembly * $item->qty_trafo;
            });
        $jumlahtotalHour_Finishing = Mps::where('production_line', 'REPAIR')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.repair'])
            ->whereIn('id_wo', $woRepair)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->repair->totalHour_Finishing * $item->qty_trafo;
            });
        $jumlahtotalHour_cabelbox = Mps::where('production_line', 'REPAIR')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.repair'])
            ->whereIn('id_wo', $woRepair)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->repair->totalHour_cabelbox * $item->qty_trafo;
            });
        $jumlahtotalHour_wiring_controlbox = Mps::where('production_line', 'REPAIR')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.repair'])
            ->whereIn('id_wo', $woRepair)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->repair->totalHour_wiring_controlbox * $item->qty_trafo;
            });

        // dd($woRepair);
        $jumlahtotalHour_copper_link = Mps::where('production_line', 'REPAIR')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.repair'])
            ->whereIn('id_wo', $woRepair)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->repair->totalHour_copper_link * $item->qty_trafo;
            });

        $jumlahtotalHour_radiator_panel = Mps::where('production_line', 'REPAIR')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.repair'])
            ->whereIn('id_wo', $woRepair)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->repair->totalHour_radiator_panel * $item->qty_trafo;
            });

        $jumlahtotalHour_conservator = Mps::where('production_line', 'REPAIR')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.repair'])
            ->whereIn('id_wo', $woRepair)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->repair->totalHour_conservator * $item->qty_trafo;
            });

        // dd($woRepair);

        switch ($periode) {
            case 1:
                $kebutuhanMPUntangking = $jumlahtotalHour_untangking / (173  * 0.93);
                $kebutuhanMPBongkar = $jumlahtotalHour_bongkar / (173  * 0.93);
                $kebutuhanMPCoil_Making = $jumlahtotalHourCoil_Making / (173  * 0.93);
                $kebutuhanMPCoreAssembly = $jumlahtotalHour_CoreAssembly / (173  * 0.93);
                $kebutuhanMPConectAssembly = $jumlahtotalHour_ConectAssembly / (173  * 0.93);
                $kebutuhanMPFinal_Assembly = $jumlahtotalHour_FinalAssembly / (173  * 0.93);
                $kebutuhanMPSpecial_Final_Assembly = $jumlahtotalHour_SpecialFinalAssembly / (173  * 0.93);
                $kebutuhanMPFinishing = $jumlahtotalHour_Finishing / (173  * 0.93);
                $kebutuhanMPCabelBox = $jumlahtotalHour_cabelbox / (173  * 0.93);
                $kebutuhanMPWiringControlBox = $jumlahtotalHour_wiring_controlbox / (173  * 0.93);
                $kebutuhanMPCoperLink = $jumlahtotalHour_copper_link / (173  * 0.93);
                $kebutuhanMPRadiatorPanel = $jumlahtotalHour_radiator_panel / (173  * 0.93);
                $kebutuhanMPConservator = $jumlahtotalHour_conservator / (173  * 0.93);
                break;
            case 2:
                $kebutuhanMPUntangking = $jumlahtotalHour_untangking / (40  * 0.93);
                $kebutuhanMPBongkar = $jumlahtotalHour_bongkar / (40  * 0.93);
                $kebutuhanMPCoil_Making = $jumlahtotalHourCoil_Making / (40  * 0.93);
                $kebutuhanMPCoreAssembly = $jumlahtotalHour_CoreAssembly / (40  * 0.93);
                $kebutuhanMPConectAssembly = $jumlahtotalHour_ConectAssembly / (40  * 0.93);
                $kebutuhanMPFinal_Assembly = $jumlahtotalHour_FinalAssembly / (40  * 0.93);
                $kebutuhanMPSpecial_Final_Assembly = $jumlahtotalHour_SpecialFinalAssembly / (40  * 0.93);
                $kebutuhanMPFinishing = $jumlahtotalHour_Finishing / (40  * 0.93);
                $kebutuhanMPCabelBox = $jumlahtotalHour_cabelbox / (40  * 0.93);
                $kebutuhanMPWiringControlBox = $jumlahtotalHour_wiring_controlbox / (40  * 0.93);
                $kebutuhanMPCoperLink = $jumlahtotalHour_copper_link / (40  * 0.93);
                $kebutuhanMPRadiatorPanel = $jumlahtotalHour_radiator_panel / (40  * 0.93);
                $kebutuhanMPConservator = $jumlahtotalHour_conservator / (40  * 0.93);
                break;
            case 3:
                $kebutuhanMPUntangking = $jumlahtotalHour_untangking / (40  * 0.93);
                $kebutuhanMPBongkar = $jumlahtotalHour_bongkar / (40  * 0.93);
                $kebutuhanMPCoil_Making = $jumlahtotalHourCoil_Making / (40  * 0.93);
                $kebutuhanMPCoreAssembly = $jumlahtotalHour_CoreAssembly / (40  * 0.93);
                $kebutuhanMPConectAssembly = $jumlahtotalHour_ConectAssembly / (40  * 0.93);
                $kebutuhanMPFinal_Assembly = $jumlahtotalHour_FinalAssembly / (40  * 0.93);
                $kebutuhanMPSpecial_Final_Assembly = $jumlahtotalHour_SpecialFinalAssembly / (40  * 0.93);
                $kebutuhanMPFinishing = $jumlahtotalHour_Finishing / (40  * 0.93);
                $kebutuhanMPCabelBox = $jumlahtotalHour_cabelbox / (40  * 0.93);
                $kebutuhanMPWiringControlBox = $jumlahtotalHour_wiring_controlbox / (40  * 0.93);
                $kebutuhanMPCoperLink = $jumlahtotalHour_copper_link / (40  * 0.93);
                $kebutuhanMPRadiatorPanel = $jumlahtotalHour_radiator_panel / (40  * 0.93);
                $kebutuhanMPConservator = $jumlahtotalHour_conservator / (40  * 0.93);

                break;
            case 4:
                $kebutuhanMPUntangking = $jumlahtotalHour_untangking / (173  * 0.93);
                $kebutuhanMPBongkar = $jumlahtotalHour_bongkar / (173  * 0.93);
                $kebutuhanMPCoil_Making = $jumlahtotalHourCoil_Making / (173  * 0.93);
                $kebutuhanMPCoreAssembly = $jumlahtotalHour_CoreAssembly / (173  * 0.93);
                $kebutuhanMPConectAssembly = $jumlahtotalHour_ConectAssembly / (173  * 0.93);
                $kebutuhanMPFinal_Assembly = $jumlahtotalHour_FinalAssembly / (173  * 0.93);
                $kebutuhanMPSpecial_Final_Assembly = $jumlahtotalHour_SpecialFinalAssembly / (173  * 0.93);
                $kebutuhanMPFinishing = $jumlahtotalHour_Finishing / (173  * 0.93);
                $kebutuhanMPCabelBox = $jumlahtotalHour_cabelbox / (173  * 0.93);
                $kebutuhanMPWiringControlBox = $jumlahtotalHour_wiring_controlbox / (173  * 0.93);
                $kebutuhanMPCoperLink = $jumlahtotalHour_copper_link / (173  * 0.93);
                $kebutuhanMPRadiatorPanel = $jumlahtotalHour_radiator_panel / (173  * 0.93);
                $kebutuhanMPConservator = $jumlahtotalHour_conservator / (173  * 0.93);
                break;
        }



        $selisihMPUntangking = $kebutuhanMPUntangking - $totalManPower;
        $selisihMPBongkar = $kebutuhanMPBongkar - $totalManPower;
        $selisihMPCoil_Making = $kebutuhanMPCoil_Making - $totalManPower;
        $selisihMPCoreAssembly = $kebutuhanMPCoreAssembly - $totalManPower;
        $selisihMPConect_Assembly = $kebutuhanMPConectAssembly - $totalManPower;
        $selisihMPFinal_Assembly = $kebutuhanMPFinal_Assembly - $totalManPower;
        $selisihMPSpecial_Final_Assembly = $kebutuhanMPSpecial_Final_Assembly - $totalManPower;
        $selisihMPFinishing = $kebutuhanMPFinishing - $totalManPower;
        $selisihMPCabelBox = $kebutuhanMPCabelBox - $totalManPower;
        $selisihMPWiringControlBox = $kebutuhanMPWiringControlBox - $totalManPower;
        $selisihMPCoperLink = $kebutuhanMPCoperLink - $totalManPower;
        $selisihMPRadiatorPanel = $kebutuhanMPRadiatorPanel - $totalManPower;
        $selisihMPConservator = $kebutuhanMPConservator - $totalManPower;

        if ($kebutuhanMPUntangking != 0) {
            $presentaseKurangMPUntangking = ($selisihMPUntangking / $kebutuhanMPUntangking) * 100;
        } else {
            $presentaseKurangMPUntangking = 0;
        }
        if ($kebutuhanMPBongkar != 0) {
            $presentaseKurangMPBongkar = ($selisihMPBongkar / $kebutuhanMPBongkar) * 100;
        } else {
            $presentaseKurangMPBongkar = 0;
        }
        if ($kebutuhanMPCoil_Making != 0) {
            $presentaseKurangMPCoil_Making = ($selisihMPCoil_Making / $kebutuhanMPCoil_Making) * 100;
        } else {
            $presentaseKurangMPCoil_Making = 0;
        }
        if ($kebutuhanMPCoreAssembly != 0) {
            $presentaseKurangMPCoreAssembly = ($selisihMPCoreAssembly / $kebutuhanMPCoreAssembly) * 100;
        } else {
            $presentaseKurangMPCoreAssembly = 0;
        }
        if ($kebutuhanMPConectAssembly != 0) {
            $presentaseKurangMPConect_Assembly = ($selisihMPConect_Assembly / $kebutuhanMPConectAssembly) * 100;
        } else {
            $presentaseKurangMPConect_Assembly = 0;
        }
        if ($kebutuhanMPFinal_Assembly != 0) {
            $presentaseKurangMPFinal_Assembly = ($selisihMPFinal_Assembly / $kebutuhanMPFinal_Assembly) * 100;
        } else {
            $presentaseKurangMPFinal_Assembly = 0;
        }
        if ($kebutuhanMPSpecial_Final_Assembly != 0) {
            $presentaseKurangMPSpecial_Final_Assembly = ($selisihMPSpecial_Final_Assembly / $kebutuhanMPSpecial_Final_Assembly) * 100;
        } else {
            $presentaseKurangMPSpecial_Final_Assembly = 0;
        }
        if ($kebutuhanMPFinishing != 0) {
            $presentaseKurangMPFinishing = ($selisihMPFinishing / $kebutuhanMPFinishing) * 100;
        } else {
            $presentaseKurangMPFinishing = 0;
        }
        if ($kebutuhanMPCabelBox != 0) {
            $presentaseKurangMPCabelBox = ($selisihMPCabelBox / $kebutuhanMPCabelBox) * 100;
        } else {
            $presentaseKurangMPCabelBox = 0;
        }
        if ($kebutuhanMPWiringControlBox != 0) {
            $presentaseKurangMPWiringControlBox = ($selisihMPWiringControlBox / $kebutuhanMPWiringControlBox) * 100;
        } else {
            $presentaseKurangMPWiringControlBox = 0;
        }
        if ($kebutuhanMPCoperLink != 0) {
            $presentaseKurangMPCoperLink = ($selisihMPCoperLink / $kebutuhanMPCoperLink) * 100;
        } else {
            $presentaseKurangMPCoperLink = 0;
        }
        if ($kebutuhanMPRadiatorPanel != 0) {
            $presentaseKurangMPRadiatorPanel = ($selisihMPRadiatorPanel / $kebutuhanMPRadiatorPanel) * 100;
        } else {
            $presentaseKurangMPRadiatorPanel = 0;
        }
        if ($kebutuhanMPFinishing != 0) {
            $presentaseKurangMPConservator = ($selisihMPConservator / $kebutuhanMPConservator) * 100;
        } else {
            $presentaseKurangMPConservator = 0;
        }

        $ketersediaanMPUntangking = $kebutuhanMPUntangking - ($kebutuhanMPUntangking * $presentaseKurangMPUntangking) / 100;
        $ketersediaanMPBongkar = $kebutuhanMPBongkar - ($kebutuhanMPBongkar * $presentaseKurangMPBongkar) / 100;
        $ketersediaanMPCoil_Making = $kebutuhanMPCoil_Making - ($kebutuhanMPCoil_Making * $presentaseKurangMPCoil_Making) / 100;
        $ketersediaanMPCoreAssembly = $kebutuhanMPCoreAssembly - ($kebutuhanMPCoreAssembly * $presentaseKurangMPCoreAssembly) / 100;
        $ketersediaanMPConect_Assembly = $kebutuhanMPConectAssembly - ($kebutuhanMPConectAssembly * $presentaseKurangMPConect_Assembly) / 100;
        $ketersediaanMPFinal_Assembly = $kebutuhanMPFinal_Assembly - ($kebutuhanMPFinal_Assembly * $presentaseKurangMPFinal_Assembly) / 100;
        $ketersediaanMPSpecial_Final_Assembly = $kebutuhanMPSpecial_Final_Assembly - ($kebutuhanMPSpecial_Final_Assembly * $presentaseKurangMPSpecial_Final_Assembly) / 100;
        $ketersediaanMPFinishing = $kebutuhanMPFinishing - ($kebutuhanMPFinishing * $presentaseKurangMPFinishing) / 100;
        $ketersediaanMPCabelBox = $kebutuhanMPCabelBox - ($kebutuhanMPCabelBox * $presentaseKurangMPCabelBox) / 100;
        $ketersediaanMPWiringControlBox = $kebutuhanMPWiringControlBox - ($kebutuhanMPWiringControlBox * $presentaseKurangMPWiringControlBox) / 100;
        $ketersediaanMPCoperLink = $kebutuhanMPCoperLink - ($kebutuhanMPCoperLink * $presentaseKurangMPCoperLink) / 100;
        $ketersediaanMPRadiatorPanel = $kebutuhanMPRadiatorPanel - ($kebutuhanMPRadiatorPanel * $presentaseKurangMPRadiatorPanel) / 100;
        $ketersediaanMPConservator = $kebutuhanMPConservator - ($kebutuhanMPConservator * $presentaseKurangMPConservator) / 100;

        if ($kebutuhanMPUntangking <= $ketersediaanMPUntangking) {
            $selisihMPUntangking = 0;
            $ketersediaanMPUntangking = $kebutuhanMPUntangking;
        }
        if ($kebutuhanMPBongkar <= $ketersediaanMPBongkar) {
            $selisihMPBongkar = 0;
            $ketersediaanMPBongkar = $kebutuhanMPBongkar;
        }
        if ($kebutuhanMPCoil_Making <= $ketersediaanMPCoil_Making) {
            $selisihMPCoil_Making = 0;
            $ketersediaanMPCoil_Making = $kebutuhanMPCoil_Making;
        }
        if ($kebutuhanMPCoreAssembly <= $ketersediaanMPCoreAssembly) {
            $selisihMPCoreAssembly = 0;
            $ketersediaanMPCoreAssembly = $kebutuhanMPCoreAssembly;
        }
        if ($kebutuhanMPConectAssembly <= $ketersediaanMPConect_Assembly) {
            $selisihMPConect_Assembly = 0;
            $ketersediaanMPConect_Assembly = $kebutuhanMPConectAssembly;
        }
        if ($kebutuhanMPFinal_Assembly <= $ketersediaanMPFinal_Assembly) {
            $selisihMPFinal_Assembly = 0;
            $ketersediaanMPFinal_Assembly = $kebutuhanMPFinal_Assembly;
        }
        if ($kebutuhanMPSpecial_Final_Assembly <= $ketersediaanMPSpecial_Final_Assembly) {
            $selisihMPSpecial_Final_Assembly = 0;
            $ketersediaanMPSpecial_Final_Assembly = $kebutuhanMPSpecial_Final_Assembly;
        }
        if ($kebutuhanMPFinishing <= $ketersediaanMPFinishing) {
            $selisihMPFinishing = 0;
            $ketersediaanMPFinishing = $kebutuhanMPFinishing;
        }
        if ($kebutuhanMPCabelBox <= $ketersediaanMPCabelBox) {
            $selisihMPCabelBox = 0;
            $ketersediaanMPCabelBox = $kebutuhanMPCabelBox;
        }
        if ($kebutuhanMPWiringControlBox <= $ketersediaanMPWiringControlBox) {
            $selisihMPWiringControlBox = 0;
            $ketersediaanMPWiringControlBox = $kebutuhanMPWiringControlBox;
        }
        if ($kebutuhanMPCoperLink <= $ketersediaanMPCoperLink) {
            $selisihMPCoperLink = 0;
            $ketersediaanMPCoperLink = $kebutuhanMPCoperLink;
        }
        if ($kebutuhanMPRadiatorPanel <= $ketersediaanMPRadiatorPanel) {
            $selisihMPRadiatorPanel = 0;
            $ketersediaanMPRadiatorPanel = $kebutuhanMPRadiatorPanel;
        }
        if ($kebutuhanMPConservator <= $ketersediaanMPConservator) {
            $selisihMPConservator = 0;
            $ketersediaanMPConservator = $kebutuhanMPConservator;
        }

        $wc_Untangking =  'Untangking ';
        $wc_Bongkar =  'Bongkar';
        $wc_Coil_Making =  'Coil Making ';
        $wc_Core_Assembly =  'Core Assembly';
        $wc_Conect_Assembly =  'Conect Assembly';
        $wc_Final_Assembly =  'Final Assembly';
        $wc_Special_Final_Assembly =  'Special Final Assembly';
        $wc_Finishing =  'Finishing';
        $wc_cabelbox =  'Cabel Box';
        $wc_Wiring_Controlbox =  'Wiring Control Box';
        $wc_Coper_link =  'Coper Link';
        $wc_Radioator_Panel =  'Radioator Panel';
        $wc_Conservator =  'Conservator';

        $data = [
            'jumlahtotalHour_untangking' => $jumlahtotalHour_untangking,
            'jumlahtotalHour_bongkar' => $jumlahtotalHour_bongkar,
            'jumlahtotalHourCoil_Making' => $jumlahtotalHourCoil_Making,
            'jumlahtotalHour_CoreAssembly' => $jumlahtotalHour_CoreAssembly,
            'jumlahtotalHour_ConectAssembly' => $jumlahtotalHour_ConectAssembly,
            'jumlahtotalHour_FinalAssembly' => $jumlahtotalHour_FinalAssembly,
            'jumlahtotalHour_SpecialFinalAssembly' => $jumlahtotalHour_SpecialFinalAssembly,
            'jumlahtotalHour_Finishing' => $jumlahtotalHour_Finishing,
            'jumlahtotalHour_cabelbox' => $jumlahtotalHour_cabelbox,
            'jumlahtotalHour_wiring_controlbox' => $jumlahtotalHour_wiring_controlbox,
            'jumlahtotalHour_copper_link' => $jumlahtotalHour_copper_link,
            'jumlahtotalHour_radiator_panel' => $jumlahtotalHour_radiator_panel,
            'jumlahtotalHour_conservator' => $jumlahtotalHour_conservator,
            'selisihMPUntangking' => $selisihMPUntangking,
            'selisihMPBongkar' => $selisihMPBongkar,
            'selisihMPCoil_Making' => $selisihMPCoil_Making,
            'selisihMPCoreAssembly' => $selisihMPCoreAssembly,
            'selisihMPConect_Assembly' => $selisihMPConect_Assembly,
            'selisihMPFinal_Assembly' => $selisihMPFinal_Assembly,
            'selisihMPSpecial_Final_Assembly' => $selisihMPSpecial_Final_Assembly,
            'selisihMPFinishing' => $selisihMPFinishing,
            'selisihMPCabelBox' => $selisihMPCabelBox,
            'selisihMPWiringControlBox' => $selisihMPWiringControlBox,
            'selisihMPCoperLink' => $selisihMPCoperLink,
            'selisihMPRadiatorPanel' => $selisihMPRadiatorPanel,
            'selisihMPConservator' => $selisihMPConservator,
            'totalManPower;' => $totalManPower,

            'kebutuhanMPUntangking' => $kebutuhanMPUntangking,
            'kebutuhanMPBongkar' => $kebutuhanMPBongkar,
            'kebutuhanMPCoil_Making' => $kebutuhanMPCoil_Making,
            'kebutuhanMPCoreAssembly' => $kebutuhanMPCoreAssembly,
            'kebutuhanMPConectAssembly' => $kebutuhanMPConectAssembly,
            'kebutuhanMPFinal_Assembly' => $kebutuhanMPFinal_Assembly,
            'kebutuhanMPSpecial_Final_Assembly' => $kebutuhanMPSpecial_Final_Assembly,
            'kebutuhanMPFinishing' => $kebutuhanMPFinishing,
            'kebutuhanMPCabelBox' => $kebutuhanMPCabelBox,
            'kebutuhanMPWiringControlBox' => $kebutuhanMPWiringControlBox,
            'kebutuhanMPCoperLink' => $kebutuhanMPCoperLink,
            'kebutuhanMPRadiatorPanel' => $kebutuhanMPRadiatorPanel,
            'kebutuhanMPConservator' => $kebutuhanMPConservator,

            'wc_Untangking' => $wc_Untangking,
            'wc_Bongkar' => $wc_Bongkar,
            'wc_Coil_Making' => $wc_Coil_Making,
            'wc_Core_Assembly' => $wc_Core_Assembly,
            'wc_Conect_Assembly' => $wc_Conect_Assembly,
            'wc_Final_Assembly' => $wc_Final_Assembly,
            'wc_Special_Final_Assembly' => $wc_Special_Final_Assembly,
            'wc_Finishing' => $wc_Finishing,
            'wc_cabelbox' => $wc_cabelbox,
            'wc_Wiring_Controlbox' => $wc_Wiring_Controlbox,
            'wc_Coper_link' => $wc_Coper_link,
            'wc_Radioator_Panel' => $wc_Radioator_Panel,
            'wc_Conservator' => $wc_Conservator,
            'ketersediaanMPUntangking' => $ketersediaanMPUntangking,
            'ketersediaanMPBongkar' => $ketersediaanMPBongkar,
            'ketersediaanMPCoil_Making' => $ketersediaanMPCoil_Making,
            'ketersediaanMPCoreAssembly' => $ketersediaanMPCoreAssembly,
            'ketersediaanMPConect_Assembly' => $ketersediaanMPConect_Assembly,
            'ketersediaanMPFinal_Assembly' => $ketersediaanMPFinal_Assembly,
            'ketersediaanMPSpecial_Final_Assembly' => $ketersediaanMPSpecial_Final_Assembly,
            'ketersediaanMPFinishing' => $ketersediaanMPFinishing,
            'ketersediaanMPCabelBox' => $ketersediaanMPCabelBox,
            'ketersediaanMPWiringControlBox' => $ketersediaanMPWiringControlBox,
            'ketersediaanMPCoperLink' => $ketersediaanMPCoperLink,
            'ketersediaanMPRadiatorPanel' => $ketersediaanMPRadiatorPanel,
            'ketersediaanMPConservator' => $ketersediaanMPConservator,
            'title1' => $title1,
            'mps' => $mps,
            'kapasitas' => $kapasitas,
            'PL' => $PL,
            'deadlineDate' => $deadlineDate,
            'repair' => $repair,
        ];
        return view('produksi.resource_work_planning.REPAIR.kebutuhan', ['data' => $data]);
    }
}
