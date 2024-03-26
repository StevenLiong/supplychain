<?php

namespace App\Http\Controllers\produksi\ResourceWorkPlanning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourceKalkulasiSDMrController extends Controller
{
    function kalkulasiSDM()
    {
        $title1 = 'Kalkulasi SDM';
        $data = [
            'title1' => $title1,
        ];
        return view('produksi.resource_work_planning.kalkulasiSDM', ['data' => $data]);
    }
}
