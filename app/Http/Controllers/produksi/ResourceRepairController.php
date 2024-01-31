<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourceRepairController extends Controller
{
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
}
