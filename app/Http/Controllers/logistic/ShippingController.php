<?php

namespace App\Http\Controllers\logistic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\logistic\PackingList;
use App\Models\logistic\DeliveryReceipt;
use App\Models\logistic\Finishedgood;

class ShippingController extends Controller
{
    public function indexPack()
    {
        $packing = PackingList::all();
        return view('logistic.shipping.createpackinglist.index', compact('packing'));
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
            'customer' => 'required'
        ];

        $request->validate($rules);
        PackingList::create($request->all());


        return redirect('shipping/createpackinglist')->with('success', 'berhasil menambahkan data');
    }

    public function printPack()
    {
        return view('logistic.shipping.createpackinglist.print');
    }

    public function indexDelivery()
    {
        $delivery = DeliveryReceipt::all();
        return view('logistic.shipping.deliveryreceipt.index', compact('delivery'));
    }

    public function createDelivery()
    {
        $finishedgood = Finishedgood::all();
        $delivery = session()->get('delivery');
        return view('logistic.shipping.deliveryreceipt.create', compact('finishedgood', 'delivery'));
    }

    public function storeDelivery(Request $request)
    {
        $rules = [
            'id_wo' => 'required',
            'nsp' => 'required',
            'nsk' => 'required',
            'Tanggal_Delivery' => 'required|date',
            'NO_SO' => 'required',
            'NO_DO' => 'required',
            'packaging' => 'required',
            'ekspedisi' => 'required',
            'no_kendaraan' => 'required',
            // 'alamat' => 'required'
        ];

        $request->validate($rules);
        DeliveryReceipt::create($request->all());

        // $nama_workcenter = $request->input('nama_workcenter');
        // $dataBom = Order::where('nama_workcenter', $nama_workcenter)->first();

        // $id = $request->input('no_delivery');
        // Ambil daftar material yang sudah ada
        // $delivery = DeliveryReceipt::find($id);

        // session()->flash('delivery', $delivery);
        // session()->flash('dataBom', $id);

        return redirect('shipping/deliveryreceipt/create');
    }

    public function printDelivery()
    {
        return view('logistic.shipping.deliveryreceipt.print');
    }
}
