<?php

namespace App\Http\Controllers\planner;

use App\Http\Controllers\Controller;
use App\Models\planner\Mps;
use Illuminate\Http\Request;

class GPADryController extends Controller
{
    public function index()
    {
        $dataMps = Mps::all();
        return view('planner.gpa.indexgpadry', compact('dataMps'));
    }

    public function gpaDryDetail()
    {
        $dataMps = Mps::all();
        return view('planner.gpa.detail-gpa-dry', compact('dataMps'));
    }
}