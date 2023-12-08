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

class ResourceWorkPlanningController extends Controller
{
    public function dashboard(Request $request)
    {
        $title1 = 'Dashboard';
        $drycastresin = DryCastResin::all();
        $mps = Mps2::all();
        $PL = ProductionLine::all();
        $totalManPower = ManPower::count();



        // update pengambilan data dan apabila menggunakan pengambilan data ini timbul eror
        $periode = $request->input('periode', 1);
        switch ($periode) {
            case 1:
                $deadlineDate = [
                    now()->startOfMonth(),
                    now()->endOfMonth(),
                    $totalJamKerja = 173,
                    $totalHariKerja = 22,
                ];
                // dd($deadlineDate);
                break;

            case 2:
                $deadlineDate = [
                    now()->startOfWeek(),
                    now()->endOfWeek(),
                    $totalJamKerja = 40,
                    $totalHariKerja = 5,
                ];
                break;

            case 3:
                $deadlineDate = [
                    now()->startOfWeek()->addWeek(),
                    now()->endOfWeek()->addWeek(),
                    $totalJamKerja = 40,
                    $totalHariKerja = 5,
                ];
                break;

            case 4:
                $deadlineDate = [
                    now()->startOfWeek()->addWeeks(2),
                    now()->endOfWeek()->addWeeks(2),
                    $totalJamKerja = 173,
                    $totalHariKerja = 22,
                ];
                break;
        }

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
        // dd($qtyPL2);

        $jumlahtotalHourSumPL2 = Mps2::where('production_line', 'PL2')->with(['wo.standardize_work'])->get()->pluck('wo.standardize_work.total_hour')->sum() * $qtyPL2;
        $jumlahtotalHourSumPL3 = Mps2::where('production_line', 'PL3')->with(['wo.standardize_work'])->get()->pluck('wo.standardize_work.total_hour')->sum() * $qtyPL3;
        $jumlahtotalHourSumCTVT = Mps2::where('production_line', 'CTVT')->with(['wo.standardize_work'])->get()->pluck('wo.standardize_work.total_hour')->sum() * $qtyCTVT;
        $jumlahtotalHourSumDRY = Mps2::where('production_line', 'DRY')->with(['wo.standardize_work'])->get()->pluck('wo.standardize_work.total_hour')->sum() * $qtyDRY;
        $jumlahtotalHourSumREPAIR = Mps2::where('production_line', 'REPAIR')->with(['wo.standardize_work'])->get()->pluck('wo.standardize_work.total_hour')->sum() * $qtyREPAIR;


        switch ($periode) {
            case 1:
                $kebutuhanMPPL2 = $jumlahtotalHourSumPL2 / ($totalJamKerja * 0.93);
                $kebutuhanMPPL3 = $jumlahtotalHourSumPL3 / ($totalJamKerja * 0.93);
                $kebutuhanMPCTVT = $jumlahtotalHourSumCTVT / ($totalJamKerja * 0.93);
                $kebutuhanMPDRY = $jumlahtotalHourSumDRY / ($totalJamKerja * 0.93);
                $kebutuhanMPREPAIR = $jumlahtotalHourSumREPAIR / ($totalJamKerja * 0.93);
                break;
            case 2:
                $kebutuhanMPPL2 = $jumlahtotalHourSumPL2 / ($totalJamKerja * 0.93);
                $kebutuhanMPPL3 = $jumlahtotalHourSumPL3 / ($totalJamKerja * 0.93);
                $kebutuhanMPCTVT = $jumlahtotalHourSumCTVT / ($totalJamKerja * 0.93);
                $kebutuhanMPDRY = $jumlahtotalHourSumDRY / ($totalJamKerja * 0.93);
                $kebutuhanMPREPAIR = $jumlahtotalHourSumREPAIR / ($totalJamKerja * 0.93);
                break;
            case 3:
                $kebutuhanMPPL2 = $jumlahtotalHourSumPL2 / ($totalJamKerja * 0.93);
                $kebutuhanMPPL3 = $jumlahtotalHourSumPL3 / ($totalJamKerja * 0.93);
                $kebutuhanMPCTVT = $jumlahtotalHourSumCTVT / ($totalJamKerja * 0.93);
                $kebutuhanMPDRY = $jumlahtotalHourSumDRY / ($totalJamKerja * 0.93);
                $kebutuhanMPREPAIR = $jumlahtotalHourSumREPAIR / ($totalJamKerja * 0.93);
                break;
            case 4:
                $kebutuhanMPPL2 = $jumlahtotalHourSumPL2 / ($totalJamKerja * 0.93);
                $kebutuhanMPPL3 = $jumlahtotalHourSumPL3 / ($totalJamKerja * 0.93);
                $kebutuhanMPCTVT = $jumlahtotalHourSumCTVT / ($totalJamKerja * 0.93);
                $kebutuhanMPDRY = $jumlahtotalHourSumDRY / ($totalJamKerja * 0.93);
                $kebutuhanMPREPAIR = $jumlahtotalHourSumREPAIR / ($totalJamKerja * 0.93);
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
                $kapasitasPL2 = $kapasitasPL2harian * $totalHariKerja; //dikalikan dengan hari kerja
                $kapasitasPL3 = $kapasitasPL3harian * $totalHariKerja;
                $kapasitasCTVT = $kapasitasCTVTharian * $totalHariKerja;
                $kapasitasDRY = $kapasitasDRYharian * $totalHariKerja;
                $kapasitasREPAIR = $kapasitasREPAIRharian * $totalHariKerja;
                break;
            case 2: //3 minggu
                $kapasitasPL2 = $kapasitasPL2harian * $totalHariKerja;
                $kapasitasPL3 = $kapasitasPL3harian * $totalHariKerja;
                $kapasitasCTVT = $kapasitasCTVTharian * $totalHariKerja;
                $kapasitasDRY = $kapasitasDRYharian * $totalHariKerja;
                $kapasitasREPAIR = $kapasitasREPAIRharian * $totalHariKerja;
                break;
            case 3: //2 minggu
                $kapasitasPL2 = $kapasitasPL2harian * $totalHariKerja;
                $kapasitasPL3 = $kapasitasPL3harian * $totalHariKerja;
                $kapasitasCTVT = $kapasitasCTVTharian * $totalHariKerja;
                $kapasitasDRY = $kapasitasDRYharian * $totalHariKerja;
                $kapasitasREPAIR = $kapasitasREPAIRharian * $totalHariKerja;
                break;
            case 4: //1 minggu
                $kapasitasPL2 = $kapasitasPL2harian * $totalHariKerja;
                $kapasitasPL3 = $kapasitasPL3harian * $totalHariKerja;
                $kapasitasCTVT = $kapasitasCTVTharian * $totalHariKerja;
                $kapasitasDRY = $kapasitasDRYharian * $totalHariKerja;
                $kapasitasREPAIR = $kapasitasREPAIRharian * $totalHariKerja;
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
        $loadkapasitasPL2 = ($qtyPL2 / $kapasitasPL2) * 100;
        $loadkapasitasPL3 = ($qtyPL3 / $kapasitasPL3) * 100;
        $loadkapasitasCTVT = ($qtyCTVT / $kapasitasCTVT) * 100;
        $loadkapasitasDRY = ($qtyDRY / $kapasitasDRY) * 100;
        $loadkapasitasREPAIR = ($qtyREPAIR / $kapasitasREPAIR) * 100;

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
                    $overtimePL2 = (($jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * $totalJamKerja * 0.93)) / ($ketersediaanMPPL2 * $totalJamKerja * 0.93)) * 100;
                    break;
                case 2: //3 minggu
                    $overtimePL2 = (($jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * $totalJamKerja * 0.93)) / ($ketersediaanMPPL2 * $totalJamKerja * 0.93)) * 100;
                    break;
                case 3: //2 minggu
                    $overtimePL2 = (($jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * $totalJamKerja * 0.93)) / ($ketersediaanMPPL2 * $totalJamKerja * 0.93)) * 100;
                    break;
                case 4: //1 minggu
                    $overtimePL2 = (($jumlahtotalHourSumPL2 - ($ketersediaanMPPL2 * $totalJamKerja * 0.93)) / ($ketersediaanMPPL2 * $totalJamKerja * 0.93)) * 100;
                    break;
            }
        } else {
            $overtimePL2 = 0; // Default value if $ketersediaanMPPL is zero
            $ketersediaanMPPL2 = $kebutuhanMPPL2;
        }

        if ($ketersediaanMPPL3 != 0 && $totalManPower < $kebutuhanMP) {
            switch ($periode) {
                case 1: //bulanan
                    $overtimePL3 = (($jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * $totalJamKerja * 0.93)) / ($ketersediaanMPPL3 * $totalJamKerja * 0.93)) * 100;
                    break;
                case 2: //3 minggu
                    $overtimePL3 = (($jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * $totalJamKerja * 0.93)) / ($ketersediaanMPPL3 * $totalJamKerja * 0.93)) * 100;
                    break;
                case 3: //2 minggu
                    $overtimePL3 = (($jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * $totalJamKerja * 0.93)) / ($ketersediaanMPPL3 * $totalJamKerja * 0.93)) * 100;
                    break;
                case 4: //1 minggu
                    $overtimePL3 = (($jumlahtotalHourSumPL3 - ($ketersediaanMPPL3 * $totalJamKerja * 0.93)) / ($ketersediaanMPPL3 * $totalJamKerja * 0.93)) * 100;
                    break;
            }
        } else {
            $overtimePL3 = 0; // Default value if $ketersediaanMPPL is zero
            $ketersediaanMPPL3 = $kebutuhanMPPL3;
        }

        if ($ketersediaanMPCTVT != 0 && $totalManPower < $kebutuhanMP) {
            switch ($periode) {
                case 1: //bulanan
                    $overtimeCTVT = (($jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * $totalJamKerja * 0.93)) / ($ketersediaanMPCTVT * $totalJamKerja * 0.93)) * 100;
                    break;
                case 2: //3 minggu
                    $overtimeCTVT = (($jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * $totalJamKerja * 0.93)) / ($ketersediaanMPCTVT * $totalJamKerja * 0.93)) * 100;
                    break;
                case 3: //2 minggu
                    $overtimeCTVT = (($jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * $totalJamKerja * 0.93)) / ($ketersediaanMPCTVT * $totalJamKerja * 0.93)) * 100;
                    break;
                case 4: //1 minggu
                    $overtimeCTVT = (($jumlahtotalHourSumCTVT - ($ketersediaanMPCTVT * $totalJamKerja * 0.93)) / ($ketersediaanMPCTVT * $totalJamKerja * 0.93)) * 100;
                    break;
            }
        } else {
            $overtimeCTVT = 0; // Default value if $ketersediaanMPPL is zero
            $ketersediaanMPCTVT = $kebutuhanMPCTVT;
        }

        if ($ketersediaanMPDRY != 0 && $totalManPower < $kebutuhanMP) {
            switch ($periode) {
                case 1: //bulanan
                    $overtimeDRY = (($jumlahtotalHourSumDRY - ($ketersediaanMPDRY * $totalJamKerja * 0.93)) / ($ketersediaanMPDRY * $totalJamKerja * 0.93)) * 100;
                    break;
                case 2: //3 minggu
                    $overtimeDRY = (($jumlahtotalHourSumDRY - ($ketersediaanMPDRY * $totalJamKerja * 0.93)) / ($ketersediaanMPDRY * $totalJamKerja * 0.93)) * 100;
                    break;
                case 3: //2 minggu
                    $overtimeDRY = (($jumlahtotalHourSumDRY - ($ketersediaanMPDRY * $totalJamKerja * 0.93)) / ($ketersediaanMPDRY * $totalJamKerja * 0.93)) * 100;
                    break;
                case 4: //1 minggu
                    $overtimeDRY = (($jumlahtotalHourSumDRY - ($ketersediaanMPDRY * $totalJamKerja * 0.93)) / ($ketersediaanMPDRY * $totalJamKerja * 0.93)) * 100;
                    break;
            }
        } else {
            $overtimeDRY = 0; // Default value if $ketersediaanMPPL is zero
            $ketersediaanMPDRY = $kebutuhanMPDRY;
        }

        if ($ketersediaanMPREPAIR != 0 && $totalManPower < $kebutuhanMP) {
            switch ($periode) {
                case 1: //bulanan
                    $overtimeREPAIR = (($jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * $totalJamKerja * 0.93)) / ($ketersediaanMPREPAIR * $totalJamKerja * 0.93)) * 100;
                    break;
                case 2: //3 minggu
                    $overtimeREPAIR = (($jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * $totalJamKerja * 0.93)) / ($ketersediaanMPREPAIR * $totalJamKerja * 0.93)) * 100;
                    break;
                case 3: //2 minggu
                    $overtimeREPAIR = (($jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * $totalJamKerja * 0.93)) / ($ketersediaanMPREPAIR * $totalJamKerja * 0.93)) * 100;
                    break;
                case 4: //1 minggu
                    $overtimeREPAIR = (($jumlahtotalHourSumREPAIR - ($ketersediaanMPREPAIR * $totalJamKerja * 0.93)) / ($ketersediaanMPREPAIR * $totalJamKerja * 0.93)) * 100;
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
                // dd($deadlineDate);
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
                $periodeLabel = '2 Minggu Kedepan';
                $deadlineDate = [
                    now()->startOfWeek()->addWeeks(2),
                    now()->endOfWeek()->addWeeks(2)
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

    function dryKebutuhan(Request $request)
    {
        $title1 = 'Dry - Kebutuhan';
        $PL = ProductionLine::all();
        $mps = Mps2::where('production_line', 'DRY')
            // ->with(['wo.standardize_work.dry_cast_resin'])
            ->get();

        $proses = Proses::all();
        $kapasitas = Kapasitas::all();
        // $ukuran_kapasitas = $kapasitas->where('ukuran_kapasitas');
        $drycastresin = DryCastResin::all();
        $filteredData = $mps->filter(function ($item) use ($kapasitas) {
            return $item->kapasitas_id == $kapasitas->first()->id;
        });

        $jumlahkebutuhanMPDRY = $filteredData->pluck('wo.standardize_work.dry_cast_resin.totalHour_coil_making')->sum();


        $PL = $mps->where('production_line', '=', 'DRY');
        $qtyDry = $PL->where('jenis', '=', 'D')->sum('qty_trafo');

        $selectedWorkcenter = $request->input('selectedWorkcenter', 1);
        switch ($selectedWorkcenter) {
            case 1:
                $selectedWorkcenterData = $proses->where('nama_proses', 'COIL MAKING')->first();
                $hourworkcenter = Mps2::where('production_line', '=', 'DRY')->with(['wo.standardize_work.dry_cast_resin'])->get()->pluck('wo.standardize_work.dry_cast_resin.totalHour_coil_making')->sum();

                break;
            case 2:
                $selectedWorkcenterData = $proses->where('nama_proses', 'MOULD & CASTING')->first();
                $hourworkcenter = Mps2::where('production_line', '=', 'DRY')->with(['wo.standardize_work.dry_cast_resin'])->get()->pluck('wo.standardize_work.dry_cast_resin.totalHour_MouldCasting')->sum();
                break;
            case 3:
                $selectedWorkcenterData = $proses->where('nama_proses', 'CORE COIL ASSEMBLY')->first();
                $hourworkcenter = Mps2::where('production_line', '=', 'DRY')->with(['wo.standardize_work.dry_cast_resin'])->get()->pluck('wo.standardize_work.dry_cast_resin.totalHour_CoreCoilAssembly')->sum();
                break;
        }


        $periode = $request->session()->get('periode', 1);
        switch ($periode) {
            case 1:
                $deadlineDate = now()->subMonth()->toDateString();
                $jumlahkebutuhanMPDRY = ($hourworkcenter * $qtyDry) / 173 * 0.93;
                break;
            case 2:
                $deadlineDate = now()->subWeeks(3)->toDateString();
                $jumlahkebutuhanMPDRY = ($hourworkcenter * $qtyDry) / 120 * 0.93;
                break;
            case 3:
                $deadlineDate = now()->subWeeks(2)->toDateString();
                $jumlahkebutuhanMPDRY = ($hourworkcenter * $qtyDry) / 80 * 0.93;
                break;
            case 4:
                $deadlineDate = now()->subWeek()->toDateString();
                $jumlahkebutuhanMPDRY = ($hourworkcenter * $qtyDry) / 40 * 0.93;
                break;
        }


        $data = [
            'jumlahkebutuhanMPDRY' => $jumlahkebutuhanMPDRY,
            'title1' => $title1,
            'mps' => $mps,
            'kapasitas' => $kapasitas,
            // 'ukuran_kapasitas' => $ukuran_kapasitas,
            'PL' => $PL,
            'selectedWorkcenterData' => $selectedWorkcenterData,
            'deadlineDate' => $deadlineDate,
            'drycastresin' => $drycastresin,

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
