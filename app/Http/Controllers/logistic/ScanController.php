<?php

namespace App\Http\Controllers\logistic;

use Illuminate\Http\Request;
use App\Models\logistic\Material;
use App\Http\Controllers\Controller;
use App\Models\logistic\MaterialRak;

class ScanController extends Controller
{
    public function receivingScan()
    {
        return view('logistic.receiving.chooseScan');
    }

    public function scanInformationmaterial()
    {
        return view('logistic.receiving.scanInfo');
    }

    public function StockIn()
    {
        return view('logistic.receiving.scanStock');
    }

    // storage scan rak

    public function storageScan()
    {
        return view('logistic.storage.rawmaterial.scanqty');
    }
}
