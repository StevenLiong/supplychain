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
        // $totalQty = Mps::sum('qty_trafo');
        $title1 = 'Dashboard';
        $drycastresin = DryCastResin::all();
        $mps = Mps2::all();
        $PL = ProductionLine::all();
        $matriks_skill = ManPower::all();

        //PL2
        $filteredMpsPL2 = $mps->where('production_line', 'PL2');
        $jumlahtotalHourSumPL2 = $filteredMpsPL2->sum(function ($hasiltotalhour) {
            // Mengambil id mps2s dari $hasiltotalhour
            $mps2sId = $hasiltotalhour->id;
            // Mengambil objek mps2s berdasarkan id
            $mps2s = Mps2::find($mps2sId);
            // Memastikan $mps2s ada dan memiliki properti 'qty'
            if ($mps2s && isset($mps2s->qty_trafo)) {
                // Mengalikan $hasiltotalhour dengan qty
                return $hasiltotalhour->wo->standardize_work->total_hour * $mps2s->qty_trafo;
            }
            // Mengembalikan nilai default jika tidak dapat melakukan perhitungan
            return 0;
        });

        $periode = $request->input('periode', 1);

        switch ($periode) {
            case 1:
                $kebutuhanMPPL2 = $jumlahtotalHourSumPL2 / (173 * 0.93);
                $deadlineDate = now()->subMonth()->toDateString();
                break;
            case 2:
                $kebutuhanMPPL2 = $jumlahtotalHourSumPL2 / (120 * 0.93);
                $deadlineDate = now()->subWeeks(3)->toDateString();
                break;
            case 3:
                $kebutuhanMPPL2 = $jumlahtotalHourSumPL2 / (80 * 0.93);
                $deadlineDate = now()->subWeeks(2)->toDateString();
                break;
            case 4:
                $kebutuhanMPPL2 = $jumlahtotalHourSumPL2 / (40 * 0.93);
                $deadlineDate = now()->subWeek()->toDateString();
                break;
        }
        // $kebutuhanMPPL2 = $jumlahtotalHourSumPL2 / (173 * 0.93);
        $ketersediaanMPPL2 = $matriks_skill-> count();;

        //PL3
        $filteredMpsPL3 = $mps->where('production_line', 'PL3');
        $jumlahtotalHourSumPL3 = $filteredMpsPL3->sum(function ($hasiltotalhour) {
            // Mengambil id mps2s dari $hasiltotalhour
            $mps2sId = $hasiltotalhour->id;
            // Mengambil objek mps2s berdasarkan id
            $mps2s = Mps2::find($mps2sId);
            // Memastikan $mps2s ada dan memiliki properti 'qty'
            if ($mps2s && isset($mps2s->qty_trafo)) {
                // Mengalikan $hasiltotalhour dengan qty
                return $hasiltotalhour->wo->standardize_work->total_hour * $mps2s->qty_trafo;
            }
            // Mengembalikan nilai default jika tidak dapat melakukan perhitungan
            return 0;
        });
        $kebutuhanMPPL3 = $jumlahtotalHourSumPL3 / (173 * 0.93);
        $ketersediaanMPPL3 = $matriks_skill->where('production_line', 'PL3')->where('skill', '>=', 2)->count();

        //CTVT
        $filteredMpsCTVT = $mps->where('production_line', 'CTVT');
        $jumlahtotalHourSumCTVT = $filteredMpsCTVT->sum(function ($hasiltotalhour) {
            // Mengambil id mps2s dari $hasiltotalhour
            $mps2sId = $hasiltotalhour->id;
            // Mengambil objek mps2s berdasarkan id
            $mps2s = Mps2::find($mps2sId);
            // Memastikan $mps2s ada dan memiliki properti 'qty'
            if ($mps2s && isset($mps2s->qty_trafo)) {
                // Mengalikan $hasiltotalhour dengan qty
                return $hasiltotalhour->wo->standardize_work->total_hour * $mps2s->qty_trafo;
            }
            // Mengembalikan nilai default jika tidak dapat melakukan perhitungan
            return 0;
        });
        $kebutuhanMPCTVT = $jumlahtotalHourSumCTVT / (173 * 0.93);
        $ketersediaanMPCTVT = $matriks_skill->where('production_line', 'CTVT')->where('skill', '>=', 2)->count();

        //DRY
        $filteredMpsDRY = $mps->where('production_line', 'DRY');
        $jumlahtotalHourSumDRY = $filteredMpsDRY->sum(function ($hasiltotalhour) {
            // Mengambil id mps2s dari $hasiltotalhour
            $mps2sId = $hasiltotalhour->id;
            // Mengambil objek mps2s berdasarkan id
            $mps2s = Mps2::find($mps2sId);
            // Memastikan $mps2s ada dan memiliki properti 'qty'
            if ($mps2s && isset($mps2s->qty_trafo)) {
                // Mengalikan $hasiltotalhour dengan qty
                return $hasiltotalhour->wo->standardize_work->total_hour * $mps2s->qty_trafo;
            }
            // Mengembalikan nilai default jika tidak dapat melakukan perhitungan
            return 0;
        });
        $kebutuhanMPDRY = $jumlahtotalHourSumDRY / (173 * 0.93);
        // $ketersediaanMPDRY = $matriks_skill->where('production_line', 'DRY')->where('skill', '>=', 2)->count();
        $ketersediaanMPDRY = $matriks_skill->where('production_line', 'DRY')->where('skill', '>=', 2)->count();
        //JIKA KEBUTUHAN LEBIH BANYAK DARI PADA KETERSEDIAAN, MAKA HARUS DI HITUNG PRESENTASE SELISIH ANTARA KEBUTUHAN DAN KETERSEDIAAN
        // DAN SEBALIKNYA

        //REPAIR
        $filteredMpsREPAIR = $mps->where('production_line', 'REPAIR');
        $jumlahtotalHourSumREPAIR = $filteredMpsREPAIR->sum(function ($hasiltotalhour) {
            // Mengambil id mps2s dari $hasiltotalhour
            $mps2sId = $hasiltotalhour->id;
            // Mengambil objek mps2s berdasarkan id
            $mps2s = Mps2::find($mps2sId);
            // Memastikan $mps2s ada dan memiliki properti 'qty'
            if ($mps2s && isset($mps2s->qty_trafo)) {
                // Mengalikan $hasiltotalhour dengan qty
                return $hasiltotalhour->wo->standardize_work->total_hour * $mps2s->qty_trafo;
            }
            // Mengembalikan nilai default jika tidak dapat melakukan perhitungan
            return 0;
        });
        $kebutuhanMPREPAIR = $jumlahtotalHourSumREPAIR / (173 * 0.93);
        $ketersediaanMPREPAIR = $matriks_skill->where('production_line', 'REPAIR')->where('skill', '>=', 2)->count();


        //ALL PRODUCTION LINE
        $jumlahtotalHourSum = $jumlahtotalHourSumPL2 + $jumlahtotalHourSumPL3 + $jumlahtotalHourSumCTVT + $jumlahtotalHourSumDRY + $jumlahtotalHourSumREPAIR;
        $kebutuhanMP = round($kebutuhanMPPL2 + $kebutuhanMPPL3 + $kebutuhanMPCTVT + $kebutuhanMPDRY + $kebutuhanMPREPAIR);
        $ketersediaanMP = $ketersediaanMPPL2 + $ketersediaanMPPL3 + $ketersediaanMPCTVT + $ketersediaanMPDRY + $ketersediaanMPREPAIR;

        //kirim ke view
        $data = [
            'title1' => $title1,
            'drycastresin' => $drycastresin,
            'mps' => $mps,
            'PL' => $PL,
            //PL2
            'deadlineDate' => $deadlineDate,
            'filteredMpsPL2' => $filteredMpsPL2,
            'jumlahtotalHourSumPL2' => $jumlahtotalHourSumPL2,
            'kebutuhanMPPL2' => $kebutuhanMPPL2,
            'ketersediaanMPPL2' => $ketersediaanMPPL2,
            // PL3
            'filteredMpsPL3' => $filteredMpsPL3,
            'jumlahtotalHourSumPL3' => $jumlahtotalHourSumPL3,
            'kebutuhanMPPL3' => $kebutuhanMPPL3,
            'ketersediaanMPPL3' => $ketersediaanMPPL3,
            // CTVT
            'filteredMpsCTVT' => $filteredMpsCTVT,
            'jumlahtotalHourSumCTVT' => $jumlahtotalHourSumCTVT,
            'kebutuhanMPCTVT' => $kebutuhanMPCTVT,
            'ketersediaanMPCTVT' => $ketersediaanMPCTVT,
            // DRY
            'filteredMpsDRY' => $filteredMpsDRY,
            'jumlahtotalHourSumDRY' => $jumlahtotalHourSumDRY,
            'kebutuhanMPDRY' => $kebutuhanMPDRY,
            'ketersediaanMPDRY' => $ketersediaanMPDRY,
            // REPAIR
            'filteredMpsREPAIR' => $filteredMpsREPAIR,
            'jumlahtotalHourSumREPAIR' => $jumlahtotalHourSumREPAIR,
            'kebutuhanMPREPAIR' => $kebutuhanMPREPAIR,
            'ketersediaanMPREPAIR' => $ketersediaanMPREPAIR,
            // ALL
            'jumlahtotalHourSum' => $jumlahtotalHourSum,
            'kebutuhanMP' => $kebutuhanMP,
            'ketersediaanMP' => $ketersediaanMP,
        ];


        return view('produksi.resource_work_planning.dashboard', ['data' => $data]);
    }


    function pl2Workload()
    {
        $title1 = 'PL 2 - Work Load';
        $mps = Mps2::all();
        $kapasitas = Kapasitas::all();

        $data = [
            'title1' => $title1,
            'mps' => $mps,
            'kapasitas' => $kapasitas,
        ];

        return view('produksi.resource_work_planning.PL2.work-load', ['data' => $data]);
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
