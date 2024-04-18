<?php

namespace App\Http\Controllers\logistic;

use App\Models\planner\Wo;
use Illuminate\Http\Request;
use App\Models\logistic\Gudang;
use App\Http\Controllers\Controller;
use App\Models\logistic\Finishedgood;
use App\Models\produksi\Wo2;

class FinishedgoodController extends Controller
{
    public function index()
    {
        $finishedgood = Finishedgood::latest()->get();
        return view('logistic.dataMaster.finishedgood.index', compact('finishedgood'));
    }

    public function create()
    {
        $wo = Wo::all();
        $gudang = Gudang::all();
        return view('logistic.dataMaster.finishedgood.create', compact('wo', 'gudang'));
    }

    public function store(Request $request){
        Finishedgood::create([
            'id_wo' => $request->input('id_wo'),
            'kd_finishedgood' => $request->input('kd_finishedgood'),
            'kva' => $request->input('kva'),
            'qty' => $request->input('qty_trafo'),
            'nsp' => $request->input('nsp'),
            'nsk' => $request->input('nsk'),
            'gudang' => $request->input('gudang')
        ]);

        return redirect('datamaster/finishedgood');
    }
}
