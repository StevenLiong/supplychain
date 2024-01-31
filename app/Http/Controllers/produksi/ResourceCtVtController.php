<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourceCtVtController extends Controller
{
    function ctvtRekomendasi()
    {
        $title1 = 'CT VT - Rekomendasi';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.CT-VT.rekomendasi', ['data' => $data]);
    }

    function ctvtKebutuhan()
    {
        $title1 = 'CT VT - Jumlah';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.CT-VT.kebutuhan', ['data' => $data]);
    }
}
