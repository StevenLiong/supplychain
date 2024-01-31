<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourcePl3Controller extends Controller
{
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
}
