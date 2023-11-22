<?php

namespace App\Http\Controllers\logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinishedgoodController extends Controller
{
    public function index(){
        return view('logistic.dataMaster.finishedgood.index');
    }
}
