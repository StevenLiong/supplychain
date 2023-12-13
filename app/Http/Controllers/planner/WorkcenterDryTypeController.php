<?php

namespace App\Http\Controllers\planner;

use App\Models\planner\Mps;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\planner\GPADry;
use App\Models\planner\WorkcenterDryType;

class WorkcenterDryTypeController extends Controller
{
    public function index()
    {
        $dataWorkcenter = WorkcenterDryType::select('nama_workcenter')->get();
        return view('planner.WC.indexworkcenterdrytype', compact('dataWorkcenter'));
    }

    public function wcdrytypedetail(String $nama_workcenter): View
    {
        // Ambil data WorkcenterDryType berdasarkan nama_workcenter yang diberikan
        $dataWorkcenter = WorkcenterDryType::where('nama_workcenter', $nama_workcenter)->first();
        $dataGpa = GPADry::where('nama_workcenter', $nama_workcenter)->get();

        // // Jika nama_workcenter adalah 'Bill of Material', kurangi 8 hari dari deadline
        // if ($nama_workcenter === 'Bill of Material') {
        //     foreach ($dataGpa as $item) {
        //         $item->deadline = date('Y-m-d', strtotime($item->deadline . ' -8 days'));
        //     }
        // }
        // dd($dataWorkcenter);

        return view('planner.WC.detailworkcenterdrytype', compact('dataWorkcenter','dataGpa'));
    }


}