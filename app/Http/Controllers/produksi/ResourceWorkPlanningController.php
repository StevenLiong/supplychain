<?php

namespace App\Http\Controllers\produksi;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ResourceWorkPlanningController extends Controller
{
    public function dashboard()
    {
        return view('produksi.resource_work_planning.dashboard');
    }

    function pl2Workload()
    {
        return view('produksi.resource_work_planning.PL2.work-load');
    }

    function pl2Rekomendasi()
    {
        return view('produksi.resource_work_planning.PL2.rekomendasi');
    }

    function pl2Jumlah()
    {
        return view('produksi.resource_work_planning.PL2.jumlah');
    }

    function pl3Workload()
    {
        return view('produksi.resource_work_planning.PL3.work-load');
    }

    function pl3Rekomendasi()
    {
        return view('produksi.resource_work_planning.PL3.rekomendasi');
    }

    function pl3Jumlah()
    {
        return view('produksi.resource_work_planning.PL3.jumlah');
    }

    function ctvtWorkload()
    {
        return view('produksi.resource_work_planning.CT-VT.work-load');
    }

    function ctvtRekomendasi()
    {
        return view('produksi.resource_work_planning.CT-VT.rekomendasi');
    }

    function ctvtJumlah()
    {
        return view('produksi.resource_work_planning.CT-VT.jumlah');
    }

    function dryWorkload()
    {
        return view('produksi.resource_work_planning.DRY.work-load');
    }

    function dryRekomendasi()
    {
        return view('produksi.resource_work_planning.DRY.rekomendasi');
    }

    function dryJumlah()
    {
        return view('produksi.resource_work_planning.DRY.jumlah');
    }

    function repairWorkload()
    {
        return view('produksi.resource_work_planning.REPAIR.work-load');
    }

    function repairRekomendasi()
    {
        return view('produksi.resource_work_planning.REPAIR.rekomendasi');
    }

    function repairJumlah()
    {
        return view('produksi.resource_work_planning.REPAIR.jumlah');
    }

    function kalkulasiSDM()
    {
        return view('produksi.resource_work_planning.kalkulasiSDM');
    }
}
