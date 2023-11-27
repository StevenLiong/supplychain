<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Models\planner\Mps;
use App\Models\produksi\DryCastResin;
use App\Models\produksi\Kapasitas;
use Illuminate\Http\Request;

class ResourceWorkPlanningController extends Controller
{
    public function dashboard()
    {
        // $totalQty = Mps::sum('qty_trafo');
        $title1 = 'Dashboard';
        $mps = Mps::all();
        $drycastresin = DryCastResin::all();
        // $totalHour = DryCastResin::where('id_wo', 1)->sum('total_hour');
        // $mpsData = Mps::with('drycastresin:id,total_hour')->find(1);
        // $totalHour = $mpsData->drycastresin->total_hour;
        return view('produksi.resource_work_planning.dashboard', ['mps' => $mps, 'drycastresin' => $drycastresin, 'title1' => $title1]);
    }

    function pl2Workload()
    {
        $title1 = 'PL 2 - Work Load';
        $mps = Mps::all();
        $kapasitas = Kapasitas::all();
        return view('produksi.resource_work_planning.PL2.work-load', ['mps' => $mps, 'kapasitas' => $kapasitas, 'title1' => $title1]);
    }

    function pl2Rekomendasi()
    {
        $title1 = 'PL 2 - Rekomendasi';
        return view('produksi.resource_work_planning.PL2.rekomendasi', ['title1' => $title1]);
    }

    function pl2Jumlah()
    {
        $title1 = 'PL 2 - Jumlah';
        return view('produksi.resource_work_planning.PL2.jumlah', ['title1' => $title1]);
    }

    function pl3Workload()
    {
        $title1 = 'PL 3 - Work Load';
        return view('produksi.resource_work_planning.PL3.work-load', ['title1' => $title1]);
    }

    function pl3Rekomendasi()
    {
        $title1 = 'PL 3 - Rekomendasi';
        return view('produksi.resource_work_planning.PL3.rekomendasi', ['title1' => $title1]);
    }

    function pl3Jumlah()
    {
        $title1 = 'PL 3 - RekomJumlah';
        return view('produksi.resource_work_planning.PL3.jumlah', ['title1' => $title1]);
    }

    function ctvtWorkload()
    {
        $title1 = 'CT VT - Work Load';
        return view('produksi.resource_work_planning.CT-VT.work-load', ['title1' => $title1]);
    }

    function ctvtRekomendasi()
    {
        $title1 = 'CT VT - Rekomendasi';
        return view('produksi.resource_work_planning.CT-VT.rekomendasi', ['title1' => $title1]);
    }

    function ctvtJumlah()
    {
        $title1 = 'CT VT - RekomJumlah';
        return view('produksi.resource_work_planning.CT-VT.jumlah', ['title1' => $title1]);
    }

    function dryWorkload()
    {
        $title1 = 'Dry - Work Load';
        return view('produksi.resource_work_planning.DRY.work-load', ['title1' => $title1]);
    }

    function dryRekomendasi()
    {
        $title1 = 'Dry - Rekomendasi';
        return view('produksi.resource_work_planning.DRY.rekomendasi', ['title1' => $title1]);
    }

    function dryJumlah()
    {
        $title1 = 'Dry - Jumlah';
        return view('produksi.resource_work_planning.DRY.jumlah', ['title1' => $title1]);
    }

    function repairWorkload()
    {
        $title1 = 'Repair - Work Load';
        return view('produksi.resource_work_planning.REPAIR.work-load', ['title1' => $title1]);
    }

    function repairRekomendasi()
    {
        $title1 = 'Repair - Rekomendasi';
        return view('produksi.resource_work_planning.REPAIR.rekomendasi', ['title1' => $title1]);
    }

    function repairJumlah()
    {
        $title1 = 'Repair - Jumlah';
        return view('produksi.resource_work_planning.REPAIR.jumlah', ['title1' => $title1]);
    }

    function kalkulasiSDM()
    {
        $title1 = 'Kalkulasi SDM';
        return view('produksi.resource_work_planning.kalkulasiSDM', ['title1' => $title1]);
    }
}
