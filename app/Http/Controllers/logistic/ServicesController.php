<?php

namespace App\Http\Controllers\logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    // Transaksi Gudang
    
    public function indexGudang(){
        return view('logistic.services.transaksigudang.index');

    }

    // Transaksi Produksi
    public function indexProduksi(){
        return view('logistic.services.transaksiproduksi.index');
    }
}

