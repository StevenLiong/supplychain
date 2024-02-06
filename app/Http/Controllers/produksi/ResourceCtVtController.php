<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Models\planner\Mps;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\ManPower;
use App\Models\produksi\ProductionLine;
use Illuminate\Http\Request;

class ResourceCtVtController extends Controller
{
    function ctvtRekomendasi()
    {
        $title1 = 'CT VT - Rekomendasi';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.CT-VT.rekomendasi', ['data' => $data]);
    }

    function ctvtKebutuhan(Request $request)
    {
        $title1 = 'CT VT - Jumlah';
        $totalManPower = ManPower::count();
        $title1 = 'Dry - Kebutuhan';
        $PL = ProductionLine::all();
        $kapasitas = Kapasitas::all();
        $mps = Mps::where('production_line', 'CTVT')->get();
        // $drycastresin = DryCastResin::all();
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
        $filteredMpsDRY = $mps->where('production_line', 'CTVT');

        // //QTY PL
        $qtyDRY =  $filteredMpsDRY->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
        // dd($qtyDRY);
        $woDRY = Mps::where('production_line', 'CTVT')->pluck('id_wo');

        $jumlahtotalHourCoil_Making = Mps::where('production_line', 'CTVT')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.ct', 'wo.standardize_work.vt'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                $workData = $item->wo->standardize_work->ct ?? $item->wo->standardize_work->vt;

                if ($workData) {
                    // Ambil nilai totalHour_MouldCasting dan dikali qty
                    $totalHour_Coil_making = $workData->totalHour_Coil_making ?? 0;

                    // Hitung total hour Mould Casting
                    return $totalHour_Coil_making * $item->qty_trafo;
                } else {
                    // Handle jika tidak ada data yang sesuai
                    return 0;
                }
            });



        $jumlahtotalHourMould_Casting = Mps::where('production_line', 'CTVT')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.ct', 'wo.standardize_work.vt'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                // Ambil data berdasarkan jenisnya (ct atau vt)
                $workData = $item->wo->standardize_work->ct ?? $item->wo->standardize_work->vt;

                if ($workData) {
                    // Ambil nilai totalHour_MouldCasting dan dikali qty
                    $totalHourMouldCasting = $workData->totalHour_mould_casting ?? 0;

                    // Hitung total hour Mould Casting
                    return $totalHourMouldCasting * $item->qty_trafo;
                } else {
                    // Handle jika tidak ada data yang sesuai
                    return 0;
                }
            });

        $jumlahtotalHourfinal_assembly = Mps::where('production_line', 'CTVT')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.ct', 'wo.standardize_work.vt'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                // Ambil data berdasarkan jenisnya (ct atau vt)
                $workData = $item->wo->standardize_work->ct ?? $item->wo->standardize_work->vt;

                if ($workData) {
                    // Ambil nilai totalHour_CoreCoilAssembly dan dikali qty
                    $totalHourCoreCoilAssembly = $workData->totalHour_final_assembly ?? 0;

                    // Hitung total hour Core Coil Assembly
                    return $totalHourCoreCoilAssembly * $item->qty_trafo;
                } else {
                    // Handle jika tidak ada data yang sesuai
                    return 0;
                }
            });
        // dd($jumlahtotalHourfinal_assembly);


        switch ($periode) {
            case 1:
                $kebutuhanMPCoil_Making = $jumlahtotalHourCoil_Making / (173  * 0.93);
                $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (173  * 0.93);
                $kebutuhanMPfinal_assembly = $jumlahtotalHourfinal_assembly / (173  * 0.93);
                break;
            case 2:
                $kebutuhanMPCoil_Making = $jumlahtotalHourCoil_Making / (40  * 0.93);
                $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (40  * 0.93);
                $kebutuhanMPfinal_assembly = $jumlahtotalHourfinal_assembly / (40  * 0.93);
                break;
            case 3:
                $kebutuhanMPCoil_Making = $jumlahtotalHourCoil_Making / (40  * 0.93);
                $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (40  * 0.93);
                $kebutuhanMPfinal_assembly = $jumlahtotalHourfinal_assembly / (40  * 0.93);
                break;
            case 4:
                $kebutuhanMPCoil_Making = $jumlahtotalHourCoil_Making / (173  * 0.93);
                $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (173  * 0.93);
                $kebutuhanMPfinal_assembly = $jumlahtotalHourfinal_assembly / (173  * 0.93);
                break;
        }



        $selisihMPCoil_Making = $kebutuhanMPCoil_Making - $totalManPower;
        $selisihMPMould_Casting = $kebutuhanMPMould_Casting - $totalManPower;
        $selisihMPfinal_assembly = $kebutuhanMPfinal_assembly - $totalManPower;

        if ($kebutuhanMPCoil_Making != 0) {
            $presentaseKurangMPCoil_Making = ($selisihMPCoil_Making / $kebutuhanMPCoil_Making) * 100;
        } else {
            $presentaseKurangMPCoil_Making = 0;
        }
        if ($kebutuhanMPMould_Casting != 0) {
            $presentaseKurangMPMould_Casting = ($selisihMPMould_Casting / $kebutuhanMPMould_Casting) * 100;
        } else {
            $presentaseKurangMPMould_Casting = 0;
        }
        if ($kebutuhanMPfinal_assembly != 0) {
            $presentaseKurangMPfinal_assembly = ($selisihMPfinal_assembly / $kebutuhanMPfinal_assembly) * 100;
        } else {
            $presentaseKurangMPfinal_assembly = 0;
        }

        $ketersediaanMPCoil_Making = $kebutuhanMPCoil_Making - ($kebutuhanMPCoil_Making * $presentaseKurangMPCoil_Making) / 100;
        $ketersediaanMPMould_Casting = $kebutuhanMPMould_Casting - ($kebutuhanMPMould_Casting * $presentaseKurangMPMould_Casting) / 100;
        $ketersediaanMPfinal_assembly = $kebutuhanMPfinal_assembly - ($kebutuhanMPfinal_assembly * $presentaseKurangMPfinal_assembly) / 100;

        if ($kebutuhanMPCoil_Making <= $ketersediaanMPCoil_Making) {
            $selisihMPCoil_Making = 0;
            $ketersediaanMPCoil_Making = $kebutuhanMPCoil_Making;
        }

        if ($kebutuhanMPMould_Casting <= $ketersediaanMPMould_Casting) {
            $selisihMPMould_Casting = 0;
            $ketersediaanMPMould_Casting = $kebutuhanMPMould_Casting;
        }
        if ($kebutuhanMPfinal_assembly <= $ketersediaanMPfinal_assembly) {
            $selisihMPfinal_assembly = 0;
            $ketersediaanMPfinal_assembly = $kebutuhanMPfinal_assembly;
        }

        $wc_Coil_Making =  'Coil Making';
        $wc_Mould_Casting =  'Mould & Casting';
        $wc_final_assembly =  'Final Assembly';

        $data = [
            'jumlahtotalHourCoil_Making' => $jumlahtotalHourCoil_Making,
            'jumlahtotalHourMould_Casting' => $jumlahtotalHourMould_Casting,
            'jumlahtotalHourfinal_assembly' => $jumlahtotalHourfinal_assembly,
            'selisihMPCoil_Making' => $selisihMPCoil_Making,
            'selisihMPMould_Casting' => $selisihMPMould_Casting,
            'selisihMPfinal_assembly' => $selisihMPfinal_assembly,
            'totalManPower;' => $totalManPower,
            'kebutuhanMPCoil_Making' => $kebutuhanMPCoil_Making,
            'kebutuhanMPMould_Casting' => $kebutuhanMPMould_Casting,
            'kebutuhanMPfinal_assembly' => $kebutuhanMPfinal_assembly,
            'wc_Coil_Making' => $wc_Coil_Making,
            'wc_Mould_Casting' => $wc_Mould_Casting,
            'wc_final_assembly' => $wc_final_assembly,
            'ketersediaanMPCoil_Making' => $ketersediaanMPCoil_Making,
            'ketersediaanMPMould_Casting' => $ketersediaanMPMould_Casting,
            'ketersediaanMPfinal_assembly' => $ketersediaanMPfinal_assembly,
            'title1' => $title1,
            'mps' => $mps,
            'kapasitas' => $kapasitas,
            'PL' => $PL,
            'deadlineDate' => $deadlineDate,
            // 'drycastresin' => $drycastresin,
        ];
        return view('produksi.resource_work_planning.CT-VT.kebutuhan', ['data' => $data]);
    }
}
