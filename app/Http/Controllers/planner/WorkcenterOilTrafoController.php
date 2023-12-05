<?php

namespace App\Http\Controllers\planner;

use App\Models\planner\Mps;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\planner\WorkcenterOilTrafo;

class WorkcenterOilTrafoController extends Controller
{
    public function index()
    {
        $dataWorkcenter = WorkcenterOilTrafo::all();
        return view('planner.WC.indexworkcenteroil', compact('dataWorkcenter'));
    }

    public function wcoildetail(String $nama_workcenter):View
    {
        $dataWorkcenter = WorkcenterOilTrafo::where('nama_workcenter', $nama_workcenter)->first();
        $dataMps = Mps::all();
        return view('planner.WC.detailworkcenteroil', compact('dataWorkcenter', 'dataMps'));
    }
}