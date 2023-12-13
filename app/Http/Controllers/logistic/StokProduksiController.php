<?php

namespace App\Http\Controllers\logistic;

use App\Http\Controllers\Controller;
use App\Models\logistic\StokProduksi;
use Illuminate\Http\Request;

class StokProduksiController extends Controller
{
    // transfer stok
    public function index()
    {
        $stokProduksi = StokProduksi::all();
        return view('logistic.services.transaksiproduksi.stok.index', compact('stokProduksi'));
    }
}
