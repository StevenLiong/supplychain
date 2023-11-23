<?php

namespace App\Http\Controllers\logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    // public function index(){
    //     return view('logistic.shipping.index');
    // }

    public function indexPack(){
        return view('logistic.shipping.createpackinglist.index');

    }

    // Transaksi Produksi
    public function indexDelivery(){
        return view('logistic.shipping.deliveryreceipt.index');
    }
}
