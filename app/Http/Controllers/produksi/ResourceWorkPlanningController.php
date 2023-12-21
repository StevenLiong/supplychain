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
use App\Models\produksi\Proses;
use App\Models\produksi\StandardizeWork;
use App\Models\produksi\Wo2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Phpml\Classification\KNearestNeighbors;

class ResourceWorkPlanningController extends Controller
{
    public function dashboard(Request $request)
    {
        $title1 = 'Dashboard';
        $drycastresin = DryCastResin::all();
        $mps = Mps2::all();
        $PL = ProductionLine::all();
        $totalManPower = ManPower::count();

        $periode = $request->input('periode', 1);
        switch ($periode) {
            case 1:
                $deadlineDate = [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ];
                break;

            case 2:
                $deadlineDate = [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ];
                break;

            case 3:
                $deadlineDate = [
                    now()->startOfWeek()->addWeek(),
                    now()->endOfWeek()->addWeek()
                ];
                break;

            case 4:
                $deadlineDate = [
                    now()->startOfMonth()->addMonth(),
                    now()->endOfMonth()->addMonth()
                ];
                break;
        }
        // dd($deadlineDate);
        $request->session()->put('periode', $periode);

        //FILTER PL
        $filteredMpsPL2 = $mps->where('production_line', 'PL2');
        $filteredMpsPL3 = $mps->where('production_line', 'PL3');
        $filteredMpsCTVT = $mps->where('production_line', 'CTVT');
        $filteredMpsDRY = $mps->where('production_line', 'DRY');
        $filteredMpsREPAIR = $mps->where('production_line', 'REPAIR');

        //QTY PL
        $qtyPL2 =  $filteredMpsPL2->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
        $qtyPL3 =  $filteredMpsPL3->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
        $qtyCTVT =  $filteredMpsCTVT->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
        $qtyDRY =  $filteredMpsDRY->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
        $qtyREPAIR =  $filteredMpsREPAIR->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');

        //ambil id WO
        $woPL2 = Mps2::where('production_line', 'PL2')->pluck('id_wo');
        $woPL3 = Mps2::where('production_line', 'PL3')->pluck('id_wo');
        $woCTVT = Mps2::where('production_line', 'CTVT')->pluck('id_wo');
        $woDRY = Mps2::where('production_line', 'DRY')->pluck('id_wo');
        $woREPAIR = Mps2::where('production_line', 'REPAIR')->pluck('id_wo');

        //ambil data mps berdasarkan PL,
        $jumlahtotalHourSumDRY = Mps2::where('production_line', 'DRY')
            ->with(['wo.standardize_work'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->total_hour * $item->qty_trafo;
            });
        $jumlahtotalHourSumPL2 = Mps2::where('production_line', 'PL2')
            ->with(['wo.standardize_work'])
            ->whereIn('id_wo', $woPL2)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->total_hour * $item->qty_trafo;
            });
        $jumlahtotalHourSumPL3 = Mps2::where('production_line', 'PL3')
            ->with(['wo.standardize_work'])
            ->whereIn('id_wo', $woPL3)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->total_hour * $item->qty_trafo;
            });
        $jumlahtotalHourSumCTVT = Mps2::where('production_line', 'CTVT')
            ->with(['wo.standardize_work'])
            ->whereIn('id_wo', $woCTVT)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->total_hour * $item->qty_trafo;
            });
        $jumlahtotalHourSumREPAIR = Mps2::where('production_line', 'REPAIR')
            ->with(['wo.standardize_work'])
            ->whereIn('id_wo', $woREPAIR)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->total_hour * $item->qty_trafo;
            });

        switch ($periode) {
            case 1:
                $kebutuhanMPPL2 = $jumlahtotalHourSumPL2 / (173 * 0.93);
                $kebutuhanMPPL3 = $jumlahtotalHourSumPL3 / (173 * 0.93);
                $kebutuhanMPCTVT = $jumlahtotalHourSumCTVT / (173 * 0.93);
                $kebutuhanMPDRY = $jumlahtotalHourSumDRY / (173 * 0.93);
                $kebutuhanMPREPAIR = $jumlahtotalHourSumREPAIR / (173 * 0.93);
                break;
            case 2:
                $kebutuhanMPPL2 = $jumlahtotalHourSumPL2 / (40 * 0.93);
                $kebutuhanMPPL3 = $jumlahtotalHourSumPL3 / (40 * 0.93);
                $kebutuhanMPCTVT = $jumlahtotalHourSumCTVT / (40 * 0.93);
                $kebutuhanMPDRY = $jumlahtotalHourSumDRY / (40 * 0.93);
                $kebutuhanMPREPAIR = $jumlahtotalHourSumREPAIR / (40 * 0.93);
                break;
            case 3:
                $kebutuhanMPPL2 = $jumlahtotalHourSumPL2 / (40 * 0.93);
                $kebutuhanMPPL3 = $jumlahtotalHourSumPL3 / (40 * 0.93);
                $kebutuhanMPCTVT = $jumlahtotalHourSumCTVT / (40 * 0.93);
                $kebutuhanMPDRY = $jumlahtotalHourSumDRY / (40 * 0.93);
                $kebutuhanMPREPAIR = $jumlahtotalHourSumREPAIR / (40 * 0.93);
                break;
            case 4:
                $kebutuhanMPPL2 = $jumlahtotalHourSumPL2 / (173 * 0.93);
                $kebutuhanMPPL3 = $jumlahtotalHourSumPL3 / (173 * 0.93);
                $kebutuhanMPCTVT = $jumlahtotalHourSumCTVT / (173 * 0.93);
                $kebutuhanMPDRY = $jumlahtotalHourSumDRY / (173 * 0.93);
                $kebutuhanMPREPAIR = $jumlahtotalHourSumREPAIR / (173 * 0.93);
                break;
        }

        //TOTAL HOUR SEMUANYA
        $jumlahtotalHourSum = $jumlahtotalHourSumPL2 + $jumlahtotalHourSumPL3 + $jumlahtotalHourSumCTVT + $jumlahtotalHourSumDRY + $jumlahtotalHourSumREPAIR;

        //TOTAL KEBUTUHAN MP
        $kebutuhanMP = round($kebutuhanMPPL2 + $kebutuhanMPPL3 + $kebutuhanMPCTVT + $kebutuhanMPDRY + $kebutuhanMPREPAIR, 2);
        //TOTAL SELISIH KEKURANGAN MP
        $selisihKurangMP = $kebutuhanMP - $totalManPower;
        //PRESENTASE KEKURANGAN MP

        if ($kebutuhanMP != 0) {
            $presentaseKurangMP = ($selisihKurangMP / $kebutuhanMP) * 100;
        } else {
            $presentaseKurangMP = 0;
        }


        //ambil total kapasitas dari tabel production_line
        //berikut dari database merupakan kapasitas harian
        $kapasitasPL2harian = $PL->firstWhere('nama_pl', 'PL2')->kapasitas_pl ?? null;
        $kapasitasPL3harian = $PL->firstWhere('nama_pl', 'PL3')->kapasitas_pl ?? null;
        $kapasitasCTVTharian = $PL->firstWhere('nama_pl', 'CTVT')->kapasitas_pl ?? null;
        $kapasitasDRYharian = $PL->firstWhere('nama_pl', 'DRY')->kapasitas_pl ?? null;
        $kapasitasREPAIRharian = $PL->firstWhere('nama_pl', 'REPAIR')->kapasitas_pl ?? null;


        switch ($periode) {
            case 1: //bulanan
                $kapasitasPL2 = $kapasitasPL2harian * 22; //dikalikan dengan hari kerja
                $kapasitasPL3 = $kapasitasPL3harian * 22;
                $kapasitasCTVT = $kapasitasCTVTharian * 22;
                $kapasitasDRY = $kapasitasDRYharian * 22;
                $kapasitasREPAIR = $kapasitasREPAIRharian * 22;
                break;
            case 2: //3 minggu
                $kapasitasPL2 = $kapasitasPL2harian * 5;
                $kapasitasPL3 = $kapasitasPL3harian * 5;
                $kapasitasCTVT = $kapasitasCTVTharian * 5;
                $kapasitasDRY = $kapasitasDRYharian * 5;
                $kapasitasREPAIR = $kapasitasREPAIRharian * 5;
                break;
            case 3: //2 minggu
                $kapasitasPL2 = $kapasitasPL2harian * 5;
                $kapasitasPL3 = $kapasitasPL3harian * 5;
                $kapasitasCTVT = $kapasitasCTVTharian * 5;
                $kapasitasDRY = $kapasitasDRYharian * 5;
                $kapasitasREPAIR = $kapasitasREPAIRharian * 5;
                break;
            case 4: //1 minggu
                $kapasitasPL2 = $kapasitasPL2harian * 22;
                $kapasitasPL3 = $kapasitasPL3harian * 22;
                $kapasitasCTVT = $kapasitasCTVTharian * 22;
                $kapasitasDRY = $kapasitasDRYharian * 22;
                $kapasitasREPAIR = $kapasitasREPAIRharian * 22;
                break;
        }

        $ketersediaanMPPL2 = $kebutuhanMPPL2 - ($kebutuhanMPPL2 * $presentaseKurangMP) / 100;
        $ketersediaanMPPL3 = $kebutuhanMPPL3 - ($kebutuhanMPPL3 * $presentaseKurangMP) / 100;
        $ketersediaanMPCTVT = $kebutuhanMPCTVT - ($kebutuhanMPCTVT * $presentaseKurangMP) / 100;
        $ketersediaanMPDRY = $kebutuhanMPDRY  - ($kebutuhanMPDRY * $presentaseKurangMP) / 100;
        $ketersediaanMPREPAIR = $kebutuhanMPREPAIR - ($kebutuhanMPREPAIR * $presentaseKurangMP) / 100;

        //TOTAL KETERSEDIAAN MP
        $ketersediaanMP = $ketersediaanMPPL2 + $ketersediaanMPPL3 + $ketersediaanMPCTVT + $ketersediaanMPDRY + $ketersediaanMPREPAIR;

        //ambil inputan dari dropdown
        // dd($kapasitasPL2);
        //presentasi muatan kapasitas

        if ($kapasitasPL2 == 0) {
            $loadkapasitasPL2 = 0;
        } else {
            $loadkapasitasPL2 = ($qtyPL2 / $kapasitasPL2) * 100;
        }

        if ($kapasitasPL3 == 0) {
            $loadkapasitasPL3 = 0;
        } else {
            $loadkapasitasPL3 = ($qtyPL3 / $kapasitasPL3) * 100;
        }
        if ($kapasitasCTVT == 0) {
            $loadkapasitasCTVT = 0;
        } else {
            $loadkapasitasCTVT = ($qtyCTVT / $kapasitasCTVT) * 100;
        }
        if ($kapasitasDRY == 0) {
            $loadkapasitasDRY = 0;
        } else {
            $loadkapasitasDRY = ($qtyDRY / $kapasitasDRY) * 100;
        }

        if ($kapasitasREPAIR == 0) {
            $loadkapasitasREPAIR = 0;
        } else {
            $loadkapasitasREPAIR = ($qtyREPAIR / $kapasitasREPAIR) * 100;
        }

        //rules untuk jika over capacity
        $ifoverCapacityPL2 = $loadkapasitasPL2 > 100; //100 adalah hasil dari $loadkapasitas PL2
        $ifoverCapacityPL3 = $loadkapasitasPL3 > 100; //100 adalah hasil dari $loadkapasitas PL3
        $ifoverCapacityCTVT = $loadkapasitasCTVT > 100; //100 adalah hasil dari $loadkapasitas CTVT
        $ifoverCapacityDRY = $loadkapasitasDRY > 100; //100 adalah hasil dari $loadkapasitas DRY
        $ifoverCapacityREPAIR = $loadkapasitasREPAIR > 100; //100 adalah hasil dari $loadkapasitas REPAIR

        //akan overcapacity jika:

        $overCapacityPL3 = $loadkapasitasPL3 - 100; //total over nya
        $loadkapasitasPL3new = $loadkapasitasPL3 - $overCapacityPL3; //total
        $overCapacityCTVT = $loadkapasitasCTVT - 100; //total over nya
        $loadkapasitasCTVTnew = $loadkapasitasCTVT - $overCapacityCTVT; //total
        $overCapacityDRY = $loadkapasitasDRY - 100; //total over nya
        $loadkapasitasDRYnew = $loadkapasitasDRY - $overCapacityDRY; //total
        $overCapacityREPAIR = $loadkapasitasREPAIR - 100; //total over nya
        $loadkapasitasREPAIRnew = $loadkapasitasREPAIR - $overCapacityREPAIR; //total

        if ($ifoverCapacityPL2) {
            $overCapacityPL2 = $loadkapasitasPL2 - 100; //total over nya
            $loadkapasitasPL2new = $loadkapasitasPL2 - $overCapacityPL2; //total
        } else {
            $overCapacityPL2 = 0;
            $loadkapasitasPL2new = $loadkapasitasPL2;
        }

        if ($ifoverCapacityPL3) {
            $overCapacityPL3 = $loadkapasitasPL3 - 100; //total over nya
            $loadkapasitasPL3new = $loadkapasitasPL3 - $overCapacityPL3; //total
        } else {
            $overCapacityPL3 = 0;
            $loadkapasitasPL3new = $loadkapasitasPL3;
        }

        if ($ifoverCapacityCTVT) {
            $overCapacityCTVT = $loadkapasitasCTVT - 100; //total over nya
            $loadkapasitasCTVTnew = $loadkapasitasCTVT - $overCapacityCTVT; //total
        } else {
            $overCapacityCTVT = 0;
            $loadkapasitasCTVTnew = $loadkapasitasCTVT;
        }

        if ($ifoverCapacityDRY) {
            $overCapacityDRY = $loadkapasitasDRY - 100; //total over nya
            $loadkapasitasDRYnew = $loadkapasitasDRY - $overCapacityDRY; //total
        } else {
            $overCapacityDRY = 0;
            $loadkapasitasDRYnew = $loadkapasitasDRY;
        }

        if ($ifoverCapacityREPAIR) {
            $overCapacityREPAIR = $loadkapasitasREPAIR - 100; //total over nya
            $loadkapasitasREPAIRnew = $loadkapasitasREPAIR - $overCapacityREPAIR; //total
        } else {
            $overCapacityREPAIR = 0;
            $loadkapasitasREPAIRnew = $loadkapasitasREPAIR;
        }



        //*****JIKA KEBUTUHAN LEBIH BANYAK DARI PADA KETERSEDIAAN, MAKA HARUS DI HITUNG PRESENTASE SELISIH ANTARA KEBUTUHAN DAN KETERSEDIAAN
        //*****DAN SEBALIKNYA



        //0000000000000000000000000000000000000000000000000000000

        if ($ketersediaanMPPL2 != 0 && $totalManPower < $kebutuhanMP) {
            switch ($periode) {
                case 1: //bulanan
                    $overtimePL2 = (($jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * 173 * 0.93)) / ($ketersediaanMPPL2 * 173 * 0.93)) * 100;
                    break;
                case 2: //3 minggu
                    $overtimePL2 = (($jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * 40 * 0.93)) / ($ketersediaanMPPL2 * 40 * 0.93)) * 100;
                    break;
                case 3: //2 minggu
                    $overtimePL2 = (($jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * 40 * 0.93)) / ($ketersediaanMPPL2 * 40 * 0.93)) * 100;
                    break;
                case 4: //1 minggu
                    $overtimePL2 = (($jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * 173 * 0.93)) / ($ketersediaanMPPL2 * 173 * 0.93)) * 100;
                    break;
            }
        } else {
            $overtimePL2 = 0; // Default value if $ketersediaanMPPL is zero
            $ketersediaanMPPL2 = $kebutuhanMPPL2;
        }

        if ($ketersediaanMPPL3 != 0 && $totalManPower < $kebutuhanMP) {
            switch ($periode) {
                case 1: //bulanan
                    $overtimePL3 = (($jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * 173 * 0.93)) / ($ketersediaanMPPL3 * 173 * 0.93)) * 100;
                    break;
                case 2: //3 minggu
                    $overtimePL3 = (($jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * 40 * 0.93)) / ($ketersediaanMPPL3 * 40 * 0.93)) * 100;
                    break;
                case 3: //2 minggu
                    $overtimePL3 = (($jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * 40 * 0.93)) / ($ketersediaanMPPL3 * 40 * 0.93)) * 100;
                    break;
                case 4: //1 minggu
                    $overtimePL3 = (($jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * 173 * 0.93)) / ($ketersediaanMPPL3 * 173 * 0.93)) * 100;
                    break;
            }
        } else {
            $overtimePL3 = 0; // Default value if $ketersediaanMPPL is zero
            $ketersediaanMPPL3 = $kebutuhanMPPL3;
        }

        if ($ketersediaanMPCTVT != 0 && $totalManPower < $kebutuhanMP) {
            switch ($periode) {
                case 1: //bulanan
                    $overtimeCTVT = (($jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * 173 * 0.93)) / ($ketersediaanMPCTVT * 173 * 0.93)) * 100;
                    break;
                case 2: //3 minggu
                    $overtimeCTVT = (($jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * 40 * 0.93)) / ($ketersediaanMPCTVT * 40 * 0.93)) * 100;
                    break;
                case 3: //2 minggu
                    $overtimeCTVT = (($jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * 40 * 0.93)) / ($ketersediaanMPCTVT * 40 * 0.93)) * 100;
                    break;
                case 4: //1 minggu
                    $overtimeCTVT = (($jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * 173 * 0.93)) / ($ketersediaanMPCTVT * 173 * 0.93)) * 100;
                    break;
            }
        } else {
            $overtimeCTVT = 0; // Default value if $ketersediaanMPPL is zero
            $ketersediaanMPCTVT = $kebutuhanMPCTVT;
        }

        if ($ketersediaanMPDRY != 0 && $totalManPower < $kebutuhanMP) {
            switch ($periode) {
                case 1: //bulanan
                    $overtimeDRY = (($jumlahtotalHourSumDRY - ($ketersediaanMPDRY * 173 * 0.93)) / ($ketersediaanMPDRY * 173 * 0.93)) * 100;
                    break;
                case 2: //3 minggu
                    $overtimeDRY = (($jumlahtotalHourSumDRY - ($ketersediaanMPDRY * 40 * 0.93)) / ($ketersediaanMPDRY * 40 * 0.93)) * 100;
                    break;
                case 3: //2 minggu
                    $overtimeDRY = (($jumlahtotalHourSumDRY - ($ketersediaanMPDRY * 40 * 0.93)) / ($ketersediaanMPDRY * 40 * 0.93)) * 100;
                    break;
                case 4: //1 minggu
                    $overtimeDRY = (($jumlahtotalHourSumDRY - ($ketersediaanMPDRY * 173 * 0.93)) / ($ketersediaanMPDRY * 173 * 0.93)) * 100;
                    break;
            }
        } else {
            $overtimeDRY = 0; // Default value if $ketersediaanMPPL is zero
            $ketersediaanMPDRY = $kebutuhanMPDRY;
        }

        if ($ketersediaanMPREPAIR != 0 && $totalManPower < $kebutuhanMP) {
            switch ($periode) {
                case 1: //bulanan
                    $overtimeREPAIR = (($jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 173 * 0.93)) / ($ketersediaanMPREPAIR * 173 * 0.93)) * 100;
                    break;
                case 2: //3 minggu
                    $overtimeREPAIR = (($jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 40 * 0.93)) / ($ketersediaanMPREPAIR * 40 * 0.93)) * 100;
                    break;
                case 3: //2 minggu
                    $overtimeREPAIR = (($jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 40 * 0.93)) / ($ketersediaanMPREPAIR * 40 * 0.93)) * 100;
                    break;
                case 4: //1 minggu
                    $overtimeREPAIR = (($jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * 173 * 0.93)) / ($ketersediaanMPREPAIR * 173 * 0.93)) * 100;
                    break;
            }
        } else {
            $overtimeREPAIR = 0; // Default value if $ketersediaanMPPL is zero
            $ketersediaanMPREPAIR = $kebutuhanMPREPAIR;
        }

        //TOTAL OVERTIME
        $overtime = $overtimePL2 + $overtimePL3 + $overtimeCTVT + $overtimeDRY + $overtimeREPAIR;

        //kirim ke view
        $data = [
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
            'overtimePL2' => $overtimePL2,
            'ifoverCapacityPL2' => $ifoverCapacityPL2,
            'overCapacityPL2' => $overCapacityPL2,
            'loadkapasitasPL2new' => $loadkapasitasPL2new,
            // PL3
            'filteredMpsPL3' => $filteredMpsPL3,
            'qtyPL3' => $qtyPL3,
            'kapasitasPL3' => $kapasitasPL3,
            'loadkapasitasPL3' => $loadkapasitasPL3,
            'jumlahtotalHourSumPL3' => $jumlahtotalHourSumPL3,
            'kebutuhanMPPL3' => $kebutuhanMPPL3,
            'ketersediaanMPPL3' => $ketersediaanMPPL3,
            'overtimePL3' => $overtimePL3,
            'ifoverCapacityPL3' => $ifoverCapacityPL3,
            'overCapacityPL3' => $overCapacityPL3,
            'loadkapasitasPL3new' => $loadkapasitasPL3new,
            // CTVT
            'filteredMpsCTVT' => $filteredMpsCTVT,
            'qtyCTVT' => $qtyCTVT,
            'kapasitasCTVT' => $kapasitasCTVT,
            'loadkapasitasCTVT' => $loadkapasitasCTVT,
            'jumlahtotalHourSumCTVT' => $jumlahtotalHourSumCTVT,
            'kebutuhanMPCTVT' => $kebutuhanMPCTVT,
            'ketersediaanMPCTVT' => $ketersediaanMPCTVT,
            'overtimeCTVT' => $overtimeCTVT,
            'ifoverCapacityCTVT' => $ifoverCapacityCTVT,
            'overCapacityCTVT' => $overCapacityCTVT,
            'loadkapasitasCTVTnew' => $loadkapasitasCTVTnew,
            // DRY
            'filteredMpsDRY' => $filteredMpsDRY,
            'qtyDRY' => $qtyDRY,
            'kapasitasDRY' => $kapasitasDRY,
            'loadkapasitasDRY' => $loadkapasitasDRY,
            'jumlahtotalHourSumDRY' => $jumlahtotalHourSumDRY,
            'kebutuhanMPDRY' => $kebutuhanMPDRY,
            'ketersediaanMPDRY' => $ketersediaanMPDRY,
            'overtimeDRY' => $overtimeDRY,
            'ifoverCapacityDRY' => $ifoverCapacityDRY,
            'overCapacityDRY' => $overCapacityDRY,
            'loadkapasitasDRYnew' => $loadkapasitasDRYnew,
            // REPAIR
            'filteredMpsREPAIR' => $filteredMpsREPAIR,
            'qtyREPAIR' => $qtyREPAIR,
            'kapasitasREPAIR' => $kapasitasREPAIR,
            'loadkapasitasREPAIR' => $loadkapasitasREPAIR,
            'jumlahtotalHourSumREPAIR' => $jumlahtotalHourSumREPAIR,
            'kebutuhanMPREPAIR' => $kebutuhanMPREPAIR,
            'ketersediaanMPREPAIR' => $ketersediaanMPREPAIR,
            'overtimeREPAIR' => $overtimeREPAIR,
            'ifoverCapacityREPAIR' => $ifoverCapacityREPAIR,
            'overCapacityREPAIR' => $overCapacityREPAIR,
            'loadkapasitasREPAIRnew' => $loadkapasitasREPAIRnew,
            // ALL
            'jumlahtotalHourSum' => $jumlahtotalHourSum,
            'kebutuhanMP' => $kebutuhanMP,
            'ketersediaanMP' => $ketersediaanMP,
            'selisihKurangMP' => $selisihKurangMP,
            'overtime' => $overtime,
        ];


        return view('produksi.resource_work_planning.dashboard',  ['data' => $data]);
    }


    function Workload(Request $request)
    {
        $PL = ProductionLine::all();
        $title1 = ' Work Load';
        $mps = Mps2::all();
        $kapasitas = Kapasitas::all();
        $periode = $request->session()->get('periode', 1);
        switch ($periode) {
            case 1:
                $periodeLabel = 'Bulan Sekarang';
                $deadlineDate = [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ];
                break;

            case 2:
                $periodeLabel = 'Minggu Sekarang';
                $deadlineDate = [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ];
                break;

            case 3:
                $periodeLabel = 'Minggu Depan';
                $deadlineDate = [
                    now()->startOfWeek()->addWeek(),
                    now()->endOfWeek()->addWeek()
                ];
                break;

            case 4:
                $periodeLabel = 'Bulan Depan';
                $deadlineDate = [
                    now()->addMonth()->startOfMonth(),
                    now()->addMonth()->endOfMonth()
                ];
                break;
        }


        $data = [
            'title1' => $title1,
            'mps' => $mps,
            'kapasitas' => $kapasitas,
            'PL' => $PL,
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

    function pl2Kebutuhan()
    {
        $title1 = 'PL 2 - Kebutuhan';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.PL2.kebutuhan', ['data' => $data]);
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

    function pl3Kebutuhan()
    {
        $title1 = 'PL 3 - Jumlah';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.PL3.kebutuhan', ['data' => $data]);
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

    function ctvtKebutuhan()
    {
        $title1 = 'CT VT - Jumlah';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.CT-VT.kebutuhan', ['data' => $data]);
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

    public function dryRekomendasi(Request $request)
    {
        $title1 = 'Dry - Rekomendasi';

        // Ambil data dari tabel matriks_skill
        $matrixSkills = MatriksSkill::all();
        $selectedWorkcenter_rekomendasi = $request->input('selectedWorkcenter_rekomendasi', 1);

        switch ($selectedWorkcenter_rekomendasi) {
            case 1:
                $workcenterLabel = 'Coil Making HV';
                $targetProses = 2; // Sesuaikan dengan proses yang diinginkan
                break;
            case 2:
                $workcenterLabel = 'Coil Making LV';
                $targetProses = 1; // Sesuaikan dengan proses yang diinginkan
                break;
            case 3:
                $workcenterLabel = 'Mould & Casting';
                // Sesuaikan dengan proses yang diinginkan untuk workcenter ini
                break;
            case 4:
                $workcenterLabel = 'Core Coil Assembly';
                // Sesuaikan dengan proses yang diinginkan untuk workcenter ini
                break;
        }

        // Siapkan data untuk PHP-ML
        $samples = [];
        $targets = [];

        foreach ($matrixSkills as $matrixSkill) {
            // Filter berdasarkan workcenter, kategori produk, dan proses yang diinginkan
            if (
                $matrixSkill->id_production_line == 5 &&
                $matrixSkill->id_kategori_produk == 4 &&
                $matrixSkill->id_proses == $targetProses
                // Sesuaikan dengan kondisi lainnya jika diperlukan
            ) {
                $samples[] = [
                    $matrixSkill->id_production_line,
                    $matrixSkill->id_kategori_produk,
                    $matrixSkill->id_proses,
                    $matrixSkill->id_tipe_proses
                ];
                $targets[] = $matrixSkill->skill;
            }
        }



        // Buat dan latih model Knn
        //run di command : composer require php-ai/php-ml
        $model = new KNearestNeighbors();
        $model->train($samples, $targets);

        // Contoh ID manpower, Anda dapat menggantinya dengan ID yang sesuai dari request atau data lainnya
        $manpowerId = 5;

        // Ambil data manpower berdasarkan ID
        $manpower = ManPower::find($manpowerId);

        if (!$manpower) {
            return redirect()->route('home')->with('error', 'Manpower not found');
        }

        // Prediksi skill menggunakan model PHP-ML
        $predictedSkill = $model->predict([
            $manpower->id_production_line,
            $manpower->id_kategori_produk,
            $manpower->id_proses,
            $manpower->id_tipe_proses
        ]);

        // Mencari semua ID_MP yang sesuai dengan hasil prediksi
        $matchingManpowers = MatriksSkill::where('skill', '>=', $predictedSkill)->get();

        // Mendapatkan semua ID_MP dari hasil pencarian tanpa duplikasi
        $idMpsFromPrediction = $matchingManpowers->pluck('id_mp')->unique()->toArray();

        // Mendapatkan nama dari semua ID_MP yang sesuai dengan hasil prediksi tanpa duplikasi
        $manpowerNames = ManPower::whereIn('id', $idMpsFromPrediction)->pluck('nama')->toArray();

        $data = [
            'title1' => $title1,
            'workcenterLabel' => $workcenterLabel,
            'manpowerNames' => $manpowerNames,
        ];


        // Tampilkan atau lakukan apa pun yang Anda inginkan dengan $data
        return view('produksi.resource_work_planning.DRY.rekomendasi', ['data' => $data]);
    }


    function dryKebutuhan(Request $request)
    {
        $totalManPower = ManPower::count();
        $title1 = 'Dry - Kebutuhan';
        $PL = ProductionLine::all();
        $kapasitas = Kapasitas::all();
        $mps = Mps2::where('production_line', 'DRY')->get();
        $drycastresin = DryCastResin::all();
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
        $filteredMpsDRY = $mps->where('production_line', 'DRY');

        //QTY PL
        $qtyDRY =  $filteredMpsDRY->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
        // dd($qtyDRY);
        $woDRY = Mps2::where('production_line', 'DRY')->pluck('id_wo');
        $jumlahtotalHourCoil_Making_HV = Mps2::where('production_line', 'DRY')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.dry_cast_resin'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->dry_cast_resin->hour_coil_hv * $item->qty_trafo;
            });
        $jumlahtotalHourCoil_Making_LV = Mps2::where('production_line', 'DRY')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.dry_cast_resin'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                //ambil hour dulu baru dikali qty
                $hourCoilLV = $item->wo->standardize_work->dry_cast_resin->hour_coil_lv;
                $hourPotongLeadwire = $item->wo->standardize_work->dry_cast_resin->hour_potong_leadwire;
                $hourPotongIsolasi = $item->wo->standardize_work->dry_cast_resin->hour_potong_isolasi;
                //dikali qty
                return ($hourCoilLV + $hourPotongLeadwire + $hourPotongIsolasi) * $item->qty_trafo;
            });
        $jumlahtotalHourMould_Casting = Mps2::where('production_line', 'DRY')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.dry_cast_resin'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->dry_cast_resin->totalHour_MouldCasting * $item->qty_trafo;
            });

        $jumlahtotalHourCore_Assembly = Mps2::where('production_line', 'DRY')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work.dry_cast_resin'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->dry_cast_resin->totalHour_CoreCoilAssembly * $item->qty_trafo;
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
            'drycastresin' => $drycastresin,
        ];
        return view('produksi.resource_work_planning.DRY.kebutuhan', ['data' => $data]);
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

    function repairKebutuhan()
    {
        $title1 = 'Repair - Kebutuhan';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.REPAIR.kebutuhan', ['data' => $data]);
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
