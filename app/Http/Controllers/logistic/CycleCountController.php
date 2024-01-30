<?php

namespace App\Http\Controllers\logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CycleCountController extends Controller
{
    public function index(){
        return view('logistic.cycleCount.index');
    }

    public function create(){

        return view('logistic.cycleCount.create');
    }
}
