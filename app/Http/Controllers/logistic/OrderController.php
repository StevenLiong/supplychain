<?php

namespace App\Http\Controllers\logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        return view('logistic.services.transaksigudang.order');
    }
    
    public function create(){
        return view('logistic.services.transaksigudang.createOrder');
    }
}

