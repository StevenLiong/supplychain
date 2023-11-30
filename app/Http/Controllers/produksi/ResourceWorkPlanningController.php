<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Models\planner\Mps;
use App\Models\planner\Wo;
use App\Models\produksi\Mps2;
use App\Models\produksi\DryCastResin;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\ManPower;
use App\Models\produksi\MatriksSkill;
use App\Models\produksi\ProductionLine;
use App\Models\produksi\StandardizeWork;
use App\Models\produksi\Wo2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResourceWorkPlanningController extends Controller
{
    public function dashboard(Request $request)
    {
        $title1 = 'Dashboard';
        $drycastresin = DryCastResin::all();
        $mps = Mps2::all();
        $PL = ProductionLine::all();
        $totalManPower = ManPower::count();

        //pengelompokkan periode
        //ambil input dulu pake $request
        $periode = $request->input('periode', 1);
        switch ($periode) {
            case 1:
                $deadlineDate = now()->subMonth()->toDateString();
                break;
            case 2:
                $deadlineDate = now()->subWeeks(3)->toDateString();
                break;
            case 3:
                $deadlineDate = now()->subWeeks(2)->toDateString();
                break;
            case 4:
                $deadlineDate = now()->subWeek()->toDateString();
                break;
        }


        //FILTER PL
        $filteredMpsPL2 = $mps->where('production_line', 'PL2');
        $filteredMpsPL3 = $mps->where('production_line', 'PL3');
        $filteredMpsCTVT = $mps->where('production_line', 'CTVT');
        $filteredMpsDRY = $mps->where('production_line', 'DRY');
        $filteredMpsREPAIR = $mps->where('production_line', 'REPAIR');

        //QTY PL
        $qtyPL2 =  $filteredMpsPL2->where('deadline', '>=', $deadlineDate)->sum('qty_trafo');
        $qtyPL3 =  $filteredMpsPL3->where('deadline', '>=', $deadlineDate)->sum('qty_trafo');
        $qtyCTVT =  $filteredMpsCTVT->where('deadline', '>=', $deadlineDate)->sum('qty_trafo');
        $qtyDRY =  $filteredMpsDRY->where('deadline', '>=', $deadlineDate)->sum('qty_trafo');
        $qtyREPAIR =  $filteredMpsREPAIR->where('deadline', '>=', $deadlineDate)->sum('qty_trafo');


        $jumlahtotalHourSumPL2 = Mps2::where('production_line', 'PL2')->with(['wo.standardize_work'])->get()->pluck('wo.standardize_work.total_hour')->sum() * $qtyPL2;
        $jumlahtotalHourSumPL3 = Mps2::where('production_line', 'PL3')->with(['wo.standardize_work'])->get()->pluck('wo.standardize_work.total_hour')->sum() * $qtyPL3;
        $jumlahtotalHourSumCTVT = Mps2::where('production_line', 'CTVT')->with(['wo.standardize_work'])->get()->pluck('wo.standardize_work.total_hour')->sum() * $qtyCTVT;
        $jumlahtotalHourSumDRY = Mps2::where('production_line', 'DRY')->with(['wo.standardize_work'])->get()->pluck('wo.standardize_work.total_hour')->sum() * $qtyDRY;
        $jumlahtotalHourSumREPAIR = Mps2::where('production_line', 'REPAIR')->with(['wo.standardize_work'])->get()->pluck('wo.standardize_work.total_hour')->sum() * $qtyREPAIR;


        switch ($periode) {
            case 1:
                $kebutuhanMPPL2 = ceil($jumlahtotalHourSumPL2 / (173 * 0.93));
                $kebutuhanMPPL3 = ceil($jumlahtotalHourSumPL3 / (173 * 0.93));
                $kebutuhanMPCTVT = ceil($jumlahtotalHourSumCTVT / (173 * 0.93));
                $kebutuhanMPDRY = ceil($jumlahtotalHourSumDRY / (173 * 0.93));
                $kebutuhanMPREPAIR = ceil($jumlahtotalHourSumREPAIR / (173 * 0.93));
                break;
            case 2:
                $kebutuhanMPPL2 = ceil($jumlahtotalHourSumPL2 / (120 * 0.93));
                $kebutuhanMPPL3 = ceil($jumlahtotalHourSumPL3 / (120 * 0.93));
                $kebutuhanMPCTVT = ceil($jumlahtotalHourSumCTVT / (120 * 0.93));
                $kebutuhanMPDRY = ceil($jumlahtotalHourSumDRY / (120 * 0.93));
                $kebutuhanMPREPAIR = ceil($jumlahtotalHourSumREPAIR / (120 * 0.93));
                break;
            case 3:
                $kebutuhanMPPL2 = ceil($jumlahtotalHourSumPL2 / (80 * 0.93));
                $kebutuhanMPPL3 = ceil($jumlahtotalHourSumPL3 / (80 * 0.93));
                $kebutuhanMPCTVT = ceil($jumlahtotalHourSumCTVT / (80 * 0.93));
                $kebutuhanMPDRY = ceil($jumlahtotalHourSumDRY / (80 * 0.93));
                $kebutuhanMPREPAIR = ceil($jumlahtotalHourSumREPAIR / (80 * 0.93));
                break;
            case 4:
                $kebutuhanMPPL2 = ceil($jumlahtotalHourSumPL2 / (40 * 0.93));
                $kebutuhanMPPL3 = ceil($jumlahtotalHourSumPL3 / (40 * 0.93));
                $kebutuhanMPCTVT = ceil($jumlahtotalHourSumCTVT / (40 * 0.93));
                $kebutuhanMPDRY = ceil($jumlahtotalHourSumDRY / (40 * 0.93));
                $kebutuhanMPREPAIR = ceil($jumlahtotalHourSumREPAIR / (40 * 0.93));
                break;
        }

        //TOTAL HOUR SEMUANYA
        $jumlahtotalHourSum = $jumlahtotalHourSumPL2 + $jumlahtotalHourSumPL3 + $jumlahtotalHourSumCTVT + $jumlahtotalHourSumDRY + $jumlahtotalHourSumREPAIR;

        //TOTAL KEBUTUHAN MP
        $kebutuhanMP = round($kebutuhanMPPL2 + $kebutuhanMPPL3 + $kebutuhanMPCTVT + $kebutuhanMPDRY + $kebutuhanMPREPAIR);
        //TOTAL SELISIH KEKURANGAN MP
        $selisihKurangMP = $kebutuhanMP - $totalManPower;
        //PRESENTASE KEKURANGAN MP
        $presentaseKurangMP = $selisihKurangMP / $kebutuhanMP;

        $ketersediaanMPPL2 = ceil($kebutuhanMPPL2 - ($kebutuhanMPPL2 * $presentaseKurangMP));
        $ketersediaanMPPL3 = ceil($kebutuhanMPPL3 - ($kebutuhanMPPL3 * $presentaseKurangMP));
        $ketersediaanMPCTVT = ceil($kebutuhanMPCTVT - ($kebutuhanMPCTVT * $presentaseKurangMP));
        $ketersediaanMPDRY = ceil($kebutuhanMPDRY  - ($kebutuhanMPDRY * $presentaseKurangMP));
        $ketersediaanMPREPAIR = ceil($kebutuhanMPREPAIR - ($kebutuhanMPREPAIR * $presentaseKurangMP));

        //TOTAL KETERSEDIAAN MP
        $ketersediaanMP = $ketersediaanMPPL2 + $ketersediaanMPPL3 + $ketersediaanMPCTVT + $ketersediaanMPDRY + $ketersediaanMPREPAIR;

        //ambil total kapasitas dari tabel production_line
        //berikut dari database merupakan kapasitas harian
        $kapasitasPL2harian = $PL->firstWhere('nama_pl', 'PL2')->kapasitas_pl ?? null;
        $kapasitasPL3harian = $PL->firstWhere('nama_pl', 'PL3')->kapasitas_pl ?? null;
        $kapasitasCTVTharian = $PL->firstWhere('nama_pl', 'CTVT')->kapasitas_pl ?? null;
        $kapasitasDRYharian = $PL->firstWhere('nama_pl', 'DRY')->kapasitas_pl ?? null;
        $kapasitasREPAIRharian = $PL->firstWhere('nama_pl', 'REPAIR')->kapasitas_pl ?? null;


        switch ($periode) {
            case 1: //bulanan
                $kapasitasPL2 = $kapasitasPL2harian * 20;
                $kapasitasPL3 = $kapasitasPL3harian * 20;
                $kapasitasCTVT = $kapasitasCTVTharian * 20;
                $kapasitasDRY = $kapasitasDRYharian * 20;
                $kapasitasREPAIR = $kapasitasREPAIRharian * 20;
                break;
            case 2: //3 minggu
                $kapasitasPL2 = $kapasitasPL2harian * 15;
                $kapasitasPL3 = $kapasitasPL3harian * 15;
                $kapasitasCTVT = $kapasitasCTVTharian * 15;
                $kapasitasDRY = $kapasitasDRYharian * 15;
                $kapasitasREPAIR = $kapasitasREPAIRharian * 15;
                break;
            case 3: //2 minggu
                $kapasitasPL2 = $kapasitasPL2harian * 10;
                $kapasitasPL3 = $kapasitasPL3harian * 10;
                $kapasitasCTVT = $kapasitasCTVTharian * 10;
                $kapasitasDRY = $kapasitasDRYharian * 10;
                $kapasitasREPAIR = $kapasitasREPAIRharian * 10;
                break;
            case 4: //1 minggu
                $kapasitasPL2 = $kapasitasPL2harian * 5;
                $kapasitasPL3 = $kapasitasPL3harian * 5;
                $kapasitasCTVT = $kapasitasCTVTharian * 5;
                $kapasitasDRY = $kapasitasDRYharian * 5;
                $kapasitasREPAIR = $kapasitasREPAIRharian * 5;
                break;
        }

        //ambil inputan dari dropdown
        // $request->session()->put('periode', $periode);

        //presentasi muatan kapasitas
        $loadkapasitasPL2 = ($qtyPL2 / $kapasitasPL2) * 100;
        $loadkapasitasPL3 = ($qtyPL3 / $kapasitasPL3) * 100;
        $loadkapasitasCTVT = ($qtyCTVT / $kapasitasCTVT) * 100;
        $loadkapasitasDRY = ($qtyDRY / $kapasitasDRY) * 100;
        $loadkapasitasREPAIR = ($qtyREPAIR / $kapasitasREPAIR) * 100;

        // if ($ketersediaanMPPL2 < $kebutuhanMPPL2 || $ketersediaanMPPL3 < $kebutuhanMPPL3 || $ketersediaanMPCTVT < $kebutuhanMPCTVT  || $ketersediaanMPDRY < $kebutuhanMPDRY || $ketersediaanMPREPAIR < $kebutuhanMPREPAIR) {
        //     switch ($periode) {
        //         case 1: //bulanan
        //             $overtimePL2 = $jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * 173 * 0.93);
        //             $overtimePL3 = $jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * 173 * 0.93);
        //             $overtimeCTVT = $jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * 173 * 0.93);
        //             $overtimeDRY = $jumlahtotalHourSumDRY - ($ketersediaanMPDRY * 173 * 0.93);
        //             $overtimeREPAIR = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 173 * 0.93);
        //             break;
        //         case 2: //3 minggu
        //             $overtimePL2 = $jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * 120 * 0.93);
        //             $overtimePL3 = $jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * 120 * 0.93);
        //             $overtimeCTVT = $jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * 120 * 0.93);
        //             $overtimeDRY = $jumlahtotalHourSumDRY - ($ketersediaanMPDRY * 120 * 0.93);
        //             $overtimeREPAIR = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 120 * 0.93);
        //             break;
        //         case 3: //2 minggu
        //             $overtimePL2 = $jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * 80 * 0.93);
        //             $overtimePL3 = $jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * 80 * 0.93);
        //             $overtimeCTVT = $jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * 80 * 0.93);
        //             $overtimeDRY = $jumlahtotalHourSumDRY - ($ketersediaanMPDRY * 80 * 0.93);
        //             $overtimeREPAIR = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 80 * 0.93);
        //             break;
        //         case 4: //1 minggu
        //             $overtimePL2 = $jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * 40 * 0.93);
        //             $overtimePL3 = $jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * 40 * 0.93);
        //             $overtimeCTVT = $jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * 40 * 0.93);
        //             $overtimeDRY = $jumlahtotalHourSumDRY - ($ketersediaanMPDRY * 40 * 0.93);
        //             $overtimeREPAIR = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 40 * 0.93);
        //             break;
        //     }
        // } else {
        //     switch ($periode) {
        //         case 1: //bulanan
        //             $overtimePL2old = $jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * 173 * 0.93);
        //             $overtimePL2 = number_format($overtimePL2old / ($ketersediaanMPPL2 * 173 * 0.93)*100);
        //             $overtimePL3old = $jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * 173 * 0.93);
        //             $overtimePL3 = number_format($overtimePL3old / ($ketersediaanMPPL3 * 173 * 0.93)*100);
        //             $overtimeCTVTold = $jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * 173 * 0.93);
        //             $overtimeCTVT = number_format($overtimeCTVTold / ($ketersediaanMPCTVT * 173 * 0.93)*100);
        //             $overtimeDRYold = $jumlahtotalHourSumDRY - ($ketersediaanMPDRY * 173 * 0.93);
        //             $overtimeDRY = number_format($overtimeDRYold / ($ketersediaanMPDRY * 173 * 0.93)*100);
        //             $overtimeREPAIRold = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 173 * 0.93);
        //             $overtimeREPAIR = number_format($overtimeREPAIRold / ($ketersediaanMPREPAIR * 173 * 0.93)*100);
        //             break;
        //         case 2: //3 minggu
        //             $overtimePL2old = $jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * 120 * 0.93);
        //             $overtimePL2 = number_format($overtimePL2old / ($ketersediaanMPPL2 * 120 * 0.93)*100);
        //             $overtimePL3old = $jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * 120 * 0.93);
        //             $overtimePL3 = number_format($overtimePL3old / ($ketersediaanMPPL3 * 120 * 0.93)*100);
        //             $overtimeCTVTold = $jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * 120 * 0.93);
        //             $overtimeCTVT = number_format($overtimeCTVTold / ($ketersediaanMPCTVT * 120 * 0.93)*100);
        //             $overtimeDRYold = $jumlahtotalHourSumDRY - ($ketersediaanMPDRY * 120 * 0.93);
        //             $overtimeDRY = number_format($overtimeDRYold / ($ketersediaanMPDRY * 120 * 0.93)*100);
        //             $overtimeREPAIRold = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 120 * 0.93);
        //             $overtimeREPAIR = number_format($overtimeREPAIRold / ($ketersediaanMPREPAIR * 120 * 0.93)*100);
        //             break;
        //         case 3: //2 minggu
        //             $overtimePL2old = $jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * 80 * 0.93);
        //             $overtimePL2 = number_format($overtimePL2old / ($ketersediaanMPPL2 * 80 * 0.93)*100);
        //             $overtimePL3old = $jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * 80 * 0.93);
        //             $overtimePL3 = number_format($overtimePL3old / ($ketersediaanMPPL3 * 80 * 0.93)*100);
        //             $overtimeCTVTold = $jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * 80 * 0.93);
        //             $overtimeCTVT = number_format($overtimeCTVTold / ($ketersediaanMPCTVT * 80 * 0.93)*100);
        //             $overtimeDRYold = $jumlahtotalHourSumDRY - ($ketersediaanMPDRY * 80 * 0.93);
        //             $overtimeDRY = number_format($overtimeDRYold / ($ketersediaanMPDRY * 80 * 0.93)*100);
        //             $overtimeREPAIRold = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 80 * 0.93);
        //             $overtimeREPAIR = number_format($overtimeREPAIRold / ($ketersediaanMPREPAIR * 80 * 0.93)*100);
        //             break;
        //         case 4: //1 minggu
        //             $overtimePL2old = $jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * 40 * 0.93);
        //             $overtimePL2 = number_format($overtimePL2old / ($ketersediaanMPPL2 * 40 * 0.93)*100);
        //             $overtimePL3old = $jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * 40 * 0.93);
        //             $overtimePL3 = number_format($overtimePL3old / ($ketersediaanMPPL3 * 40 * 0.93)*100);
        //             $overtimeCTVTold = $jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * 40 * 0.93);
        //             $overtimeCTVT = number_format($overtimeCTVTold / ($ketersediaanMPCTVT * 40 * 0.93)*100);
        //             $overtimeDRYold = $jumlahtotalHourSumDRY - ($ketersediaanMPDRY * 40 * 0.93);
        //             $overtimeDRY = number_format($overtimeDRYold / ($ketersediaanMPDRY * 40 * 0.93)*100);
        //             $overtimeREPAIRold = $jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 40 * 0.93);
        //             $overtimeREPAIR = number_format($overtimeREPAIRold / ($ketersediaanMPREPAIR * 40 * 0.93)*100);
        //             break;
        //     }
        // }



        //TOTAL OVERTIME
        // $overtime = $overtimePL2 + $overtimePL3 + $overtimeCTVT + $overtimeDRY + $overtimeREPAIR;

        //******************JIKA KEBUTUHAN LEBIH BANYAK DARI PADA KETERSEDIAAN, MAKA HARUS DI HITUNG PRESENTASE SELISIH ANTARA KEBUTUHAN DAN KETERSEDIAAN
        //*******************DAN SEBALIKNYA



        //kirim ke view
        $data = [
            //test

            //  test

            'title1' => $title1,
            'drycastresin' => $drycastresin,
            'mps' => $mps,
            'PL' => $PL,
            'totalManPower' => $totalManPower,
            'presentaseKurangMP' => $presentaseKurangMP,
            'deadlineDate' => $deadlineDate,
            //PL2
            'filteredMpsPL2' => $filteredMpsPL2,
            'qtyPL2' => $qtyPL2,
            'kapasitasPL2' => $kapasitasPL2,
            'loadkapasitasPL2' => $loadkapasitasPL2,
            'jumlahtotalHourSumPL2' => $jumlahtotalHourSumPL2,
            'kebutuhanMPPL2' => $kebutuhanMPPL2,
            'ketersediaanMPPL2' => $ketersediaanMPPL2,
            // 'overtimePL2' => $overtimePL2,
            // PL3
            'filteredMpsPL3' => $filteredMpsPL3,
            'qtyPL3' => $qtyPL3,
            'kapasitasPL3' => $kapasitasPL3,
            'loadkapasitasPL3' => $loadkapasitasPL3,
            'jumlahtotalHourSumPL3' => $jumlahtotalHourSumPL3,
            'kebutuhanMPPL3' => $kebutuhanMPPL3,
            'ketersediaanMPPL3' => $ketersediaanMPPL3,
            // 'overtimePL3' => $overtimePL3,
            // CTVT
            'filteredMpsCTVT' => $filteredMpsCTVT,
            'qtyCTVT' => $qtyCTVT,
            'kapasitasCTVT' => $kapasitasCTVT,
            'loadkapasitasCTVT' => $loadkapasitasCTVT,
            'jumlahtotalHourSumCTVT' => $jumlahtotalHourSumCTVT,
            'kebutuhanMPCTVT' => $kebutuhanMPCTVT,
            'ketersediaanMPCTVT' => $ketersediaanMPCTVT,
            // 'overtimeCTVT' => $overtimeCTVT,
            // DRY
            'filteredMpsDRY' => $filteredMpsDRY,
            'qtyDRY' => $qtyDRY,
            'kapasitasDRY' => $kapasitasDRY,
            'loadkapasitasDRY' => $loadkapasitasDRY,
            'jumlahtotalHourSumDRY' => $jumlahtotalHourSumDRY,
            'kebutuhanMPDRY' => $kebutuhanMPDRY,
            'ketersediaanMPDRY' => $ketersediaanMPDRY,
            // 'overtimeDRY' => $overtimeDRY,
            // REPAIR
            'filteredMpsREPAIR' => $filteredMpsREPAIR,
            'qtyREPAIR' => $qtyREPAIR,
            'kapasitasREPAIR' => $kapasitasREPAIR,
            'loadkapasitasREPAIR' => $loadkapasitasREPAIR,
            'jumlahtotalHourSumREPAIR' => $jumlahtotalHourSumREPAIR,
            'kebutuhanMPREPAIR' => $kebutuhanMPREPAIR,
            'ketersediaanMPREPAIR' => $ketersediaanMPREPAIR,
            // 'overtimeREPAIR' => $overtimeREPAIR,

            // ALL
            'jumlahtotalHourSum' => $jumlahtotalHourSum,
            'kebutuhanMP' => $kebutuhanMP,
            'ketersediaanMP' => $ketersediaanMP,
            'selisihKurangMP' => $selisihKurangMP,
            // 'overtime' => $overtime,
        ];


        return view('produksi.resource_work_planning.dashboard', ['data' => $data]);
    }


    function Workload(Request $request)
    {
        $pl = ProductionLine::all();
        $title1 = ' Work Load';
        $mps = Mps2::all();
        $kapasitas = Kapasitas::all();

        $periode = $request->session()->get('periode', 1);

        switch ($periode) {
            case 1:
                $periodeLabel = '1 Bulan';
                $deadlineDate = now()->subMonth()->toDateString();

                break;
            case 2:
                $periodeLabel = '3 Minggu';
                $deadlineDate = now()->subWeeks(3)->toDateString();

                break;
            case 3:
                $periodeLabel = '2 Minggu';
                $deadlineDate = now()->subWeeks(2)->toDateString();

                break;
            case 4:
                $periodeLabel = '1 Minggu';
                $deadlineDate = now()->subWeek()->toDateString();

                break;
        }

        $data = [
            'title1' => $title1,
            'mps' => $mps,
            'kapasitas' => $kapasitas,
            'pl' => $pl,
            'deadlineDate' => $deadlineDate,
        ];

        return view('produksi.resource_work_planning.work-load', compact('periodeLabel'), ['data' => $data]);
    }

    function pl2Rekomendasi()
    {
        $title1 = 'PL 2 - Rekomendasi';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.PL2.rekomendasi', ['data' => $data]);
    }

    function pl2Jumlah()
    {
        $title1 = 'PL 2 - Jumlah';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.PL2.jumlah', ['data' => $data]);
    }

    function pl3Workload()
    {
        $title1 = 'PL 3 - Work Load';
        $kapasitas = Kapasitas::all();
        $data = [
            'title1' => $title1,
            'kapasitas' => $kapasitas,
        ];
        return view('produksi.resource_work_planning.PL3.work-load', ['data' => $data]);
    }

    function pl3Rekomendasi()
    {
        $title1 = 'PL 3 - Rekomendasi';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.PL3.rekomendasi', ['data' => $data]);
    }

    function pl3Jumlah()
    {
        $title1 = 'PL 3 - RekomJumlah';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.PL3.jumlah', ['data' => $data]);
    }

    function ctvtWorkload()
    {
        $title1 = 'CT VT - Work Load';
        $kapasitas = Kapasitas::all();
        $data = [
            'title1' => $title1,
            'kapasitas' => $kapasitas,
        ];
        return view('produksi.resource_work_planning.CT-VT.work-load', ['data' => $data]);
    }

    function ctvtRekomendasi()
    {
        $title1 = 'CT VT - Rekomendasi';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.CT-VT.rekomendasi', ['data' => $data]);
    }

    function ctvtJumlah()
    {
        $title1 = 'CT VT - RekomJumlah';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.CT-VT.jumlah', ['data' => $data]);
    }

    function dryWorkload()
    {
        $title1 = 'Dry - Work Load';
        $mps = Mps2::all();
        $kapasitas = Kapasitas::all();

        $data = [
            'title1' => $title1,
            'mps' => $mps,
            'kapasitas' => $kapasitas,
        ];
        return view('produksi.resource_work_planning.DRY.work-load', ['data' => $data]);
    }

    function dryRekomendasi()
    {
        $title1 = 'Dry - Rekomendasi';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.DRY.rekomendasi', ['data' => $data]);
    }

    function dryJumlah()
    {
        $title1 = 'Dry - Jumlah';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.DRY.jumlah', ['data' => $data]);
    }

    function repairWorkload()
    {
        $title1 = 'Repair - Work Load';
        $mps = Mps2::all();
        $kapasitas = Kapasitas::all();

        $data = [
            'title1' => $title1,
            'mps' => $mps,
            'kapasitas' => $kapasitas,
        ];
        return view('produksi.resource_work_planning.REPAIR.work-load', ['data' => $data]);
    }

    function repairRekomendasi()
    {
        $title1 = 'Repair - Rekomendasi';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.REPAIR.rekomendasi', ['data' => $data]);
    }

    function repairJumlah()
    {
        $title1 = 'Repair - Jumlah';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.REPAIR.jumlah', ['data' => $data]);
    }

    function kalkulasiSDM()
    {
        $title1 = 'Kalkulasi SDM';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.kalkulasiSDM', ['data' => $data]);
    }
}
