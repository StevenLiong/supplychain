<?php

namespace App\Http\Controllers\logistic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\logistic\PackingList;
use App\Models\logistic\DeliveryReceipt;

class ShippingController extends Controller
{
    // public function index(){
    //     return view('logistic.shipping.index');
    // }

    public function indexPack(){
        $packing = PackingList::all();
        return view('logistic.shipping.createpackinglist.index' , compact('packing'));

    }

    public function createPack()
    {
        return view('logistic.shipping.createpackinglist.create');
    }

    public function storePack(Request $request)
    {
        $rules = [
            'Tanggal_Packing' => 'required|date',
            'NO_DO' => 'required',
            'NO_WO' => 'required',
            'NSP' => 'required',
            'NSK' => 'required',
            'packaging' => 'required',
            'ukuran_dimensi' => 'required',
            'supplier' => 'required'
        ];

        $request->validate($rules);
        PackingList::create($request->all());
        

        return redirect('shipping/createpackinglist')->with('success', 'berhasil menambahkan data');
    }

    public function indexDelivery(){
        $delivery = DeliveryReceipt::all();
        return view('logistic.shipping.deliveryreceipt.index', compact('delivery'));
    }

    public function createDelivery()
    {
        return view('logistic.shipping.deliveryreceipt.create');
    }

    public function storeDelivery(Request $request)
    {
        $rules = [
            'Tanggal_Delivery' => 'required|date',
            'NO_SO' => 'required',
            'NO_DO' => 'required',
            'NO_WO' => 'required',
        ];

        $request->validate($rules);
        DeliveryReceipt::create($request->all());
        

        return redirect('shipping/deliveryreceipt')->with('success', 'berhasil menambahkan data');
    }
}
