<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Models\planner\Mps;
use App\Models\produksi\DryCastResin;
use App\Models\produksi\ManPower;
use App\Models\produksi\ProductionLine;
use Illuminate\Http\Request;


class ResourceDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $title1 = 'Dashboard';
        $drycastresin = DryCastResin::all();
        $mps = Mps::all();
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
        $request->session()->put('periode', $periode);

        //FILTER PL
        $filteredMpsPL2 = $mps->where('production_line', 'PL2');
        $filteredMpsPL3 = $mps->where('production_line', 'PL3');
        $filteredMpsCTVT = $mps->where('production_line', 'CTVT');
        $filteredMpsDRY = $mps->where('production_line', 'Drytype');
        $filteredMpsREPAIR = $mps->where('production_line', 'REPAIR');

        //QTY PL
        $qtyPL2 =  $filteredMpsPL2->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
        $qtyPL3 =  $filteredMpsPL3->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
        $qtyCTVT =  $filteredMpsCTVT->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
        $qtyDRY =  $filteredMpsDRY->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
        $qtyREPAIR =  $filteredMpsREPAIR->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');

        //ambil id WO
        $woPL2 = Mps::where('production_line', 'PL2')->pluck('id_wo');
        $woPL3 = Mps::where('production_line', 'PL3')->pluck('id_wo');
        $woCTVT = Mps::where('production_line', 'CTVT')->pluck('id_wo');
        $woDRY = Mps::where('production_line', 'Drytype')->pluck('id_wo');
        $woREPAIR = Mps::where('production_line', 'REPAIR')->pluck('id_wo');

        //ambil data mps berdasarkan PL,
        $jumlahtotalHourSumDRY = Mps::where('production_line', 'Drytype')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->total_hour * $item->qty_trafo;
            });

        $jumlahtotalHourSumPL2 = Mps::where('production_line', 'PL2')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work'])
            ->whereIn('id_wo', $woPL2)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->total_hour * $item->qty_trafo;
            });

        $jumlahtotalHourSumPL3 = Mps::where('production_line', 'PL3')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work'])
            ->whereIn('id_wo', $woPL3)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->total_hour * $item->qty_trafo;
            });

        $jumlahtotalHourSumCTVT = Mps::where('production_line', 'CTVT')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work'])
            ->whereIn('id_wo', $woCTVT)
            ->get()
            ->sum(function ($item) {
                return $item->wo->standardize_work->total_hour * $item->qty_trafo;
            });

        $jumlahtotalHourSumREPAIR = Mps::where('production_line', 'REPAIR')
            ->whereBetween('deadline', $deadlineDate)
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
}