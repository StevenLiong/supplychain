<?php

namespace App\Http\Controllers\logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function indexPack(){
        return view('logistic.shipping.createpackinglist.index');

    }

    // Transaksi Produksi
    public function indexDelivery(){
        return view('logistic.shipping.deliveryreceipt.index');
    }

    public function createPack()
    {
        return view('logistic.shipping.createpackinglist.create');
    }

    public function createDelivery()
    {
        return view('logistic.shipping.deliveryreceipt.create');
}

}
