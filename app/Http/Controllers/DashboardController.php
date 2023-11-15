<?php

namespace App\Http\Controllers;

use App\Charts\MontlyIncomingChart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\logistic\Incoming;
use App\Models\logistic\Material;
use App\Models\logistic\Supplier;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(MontlyIncomingChart $chart)
    {
        $chart = $chart->build();
        $material = Material::all();
        $supplier = Supplier::all();
        return view('logistic.dashboard.index', compact('material', 'supplier', 'chart'));
    }

    public function statistikKedatangan()
    {
        
    }
}
