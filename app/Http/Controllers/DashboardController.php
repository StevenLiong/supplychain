<?php

namespace App\Http\Controllers;

use App\Charts\FinishedgoodsCharts;
use App\Charts\MaterialStockChart;
use App\Charts\MontlyIncomingChart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\logistic\Incoming;
use App\Models\logistic\Material;
use App\Models\logistic\Supplier;
use App\Http\Controllers\Controller;
use App\Models\logistic\Finishedgood;

class DashboardController extends Controller
{
    public function index(MontlyIncomingChart $chart, MaterialStockChart $materialStock, FinishedgoodsCharts $finishedgoodChart)
    {
        $chart = $chart->build();
        $materialStock = $materialStock->build();
        $finishedgoodChart = $finishedgoodChart->build();
        $material = Material::all();
        $finishedgood = Finishedgood::all();

        // dd($finishedgoodChart);
        return view('logistic.dashboard.index', compact('material', 'finishedgood', 'chart', 'materialStock', 'finishedgoodChart'));
    }
}
