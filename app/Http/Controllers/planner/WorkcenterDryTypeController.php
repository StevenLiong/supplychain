<?php

namespace App\Http\Controllers\planner;

use App\Models\planner\Mps;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\planner\WorkcenterDryType;

class WorkcenterDryTypeController extends Controller
{
    public function index()
    {
        $dataWorkcenter = WorkcenterDryType::all();
        return view('planner.WC.indexworkcenterdrytype', compact('dataWorkcenter'));
    }

    public function wcdrytypedetail(String $nama_workcenter): View
    {
        // Ambil data WorkcenterDryType berdasarkan nama_workcenter yang diberikan
        $dataWorkcenter = WorkcenterDryType::where('nama_workcenter', $nama_workcenter)->first();

        // Jika data WorkcenterDryType tidak ditemukan, bisa ditangani di sini

        // Ambil data MPS berdasarkan kondisi yang diinginkan dan relasi dengan WorkcenterDryType
        $dataMps = $dataWorkcenter->mps()
            ->where('jenis', 'Dry Type')
            ->where('kva', 1600)
            ->get();

        // Modifikasi deadline jika memenuhi kriteria
        foreach ($dataMps as $mps) {
            $mps->deadline = \Carbon\Carbon::parse($mps->deadline)->subDays(8);
        }

        return view('planner.WC.detailworkcenterdrytype', compact('dataWorkcenter', 'dataMps'));
    }


}