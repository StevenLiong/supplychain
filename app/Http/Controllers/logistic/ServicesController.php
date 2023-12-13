<?php

namespace App\Http\Controllers\logistic;

use Illuminate\Http\Request;
use App\Models\logistic\Cutting;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{
    // Transaksi Gudang
    
    public function indexGudang(){
       
        return view('logistic.services.transaksigudang.index');
    }


    // Transaksi Produksi
    public function indexProduksi(){
        $countCutting = Cutting::where('status', 0)->count();
        return view('logistic.services.transaksiproduksi.index', compact('countCutting'));
    }
}

