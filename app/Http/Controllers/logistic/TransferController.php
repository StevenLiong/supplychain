<?php

namespace App\Http\Controllers\logistic;

use Carbon\Carbon;
use App\Models\planner\Wo;
use Illuminate\Http\Request;
use App\Models\logistic\Gudang;
use App\Models\logistic\Transfer;
use App\Http\Controllers\Controller;
use App\Models\logistic\Finishedgood;

class TransferController extends Controller
{
    public function index()
    {
        $transfer = Transfer::with('wo')->get();
        return view('logistic.services.transaksiproduksi.transfermaterial', compact('transfer'));
    }

    public function create()
    {
        $wo = Wo::all();
        return view('logistic.services.transaksiproduksi.transfermaterialcreate', compact('wo'));
    }

    public function store(Request $request)
    {
        Transfer::create([

            'id_wo' => $request->input('id_wo'),
        ]);

        return redirect('/services/transaksiproduksi/transfer');
    }

    public function tracker($no_bon)
    {

        $wo = Wo::all();
        $gudang = Gudang::all();
        $transfer = Transfer::where('no_bon', $no_bon)->first();
        // var_dump($transfer->wo);

        return view('logistic.services.transaksiproduksi.transfertracker', compact('transfer', 'wo', 'gudang'));
    }

    public function updateStatus($no_bon)
    {
        $transfer = Transfer::where('no_bon', $no_bon)->first();

        if ($transfer->status < 7) {
            $transfer->status++;
            // Tambahkan baris ini untuk mengupdate tanggal update
            $transfer->updated_at = Carbon::now();
            $transfer->save();
        }

        return redirect('services/transaksiproduksi/transfer/lacak/' . $no_bon)->with('success', 'Perpindahan Work Center');
    }

    public function addToStock(Request $request)
    {
        $no_bon = $request->input('no_bon');
        Finishedgood::create([
            'no_transfer' => $request->input('no_bon'),
            'id_wo' => $request->input('id_wo'),
            'kd_finishedgood' => $request->input('kd_finishedgood'),
            'kva' => $request->input('kva'),
            'qty' => $request->input('qty_trafo'),
            'nsp' => $request->input('nsp'),
            'nsk' => $request->input('nsk'),
            'gudang' => $request->input('gudang')
        ]);

        $transfer = Transfer::where('no_bon', $no_bon)->first();
        $transfer->status++;
        // Tambahkan baris ini untuk mengupdate tanggal update
        $transfer->updated_at = Carbon::now();
        $transfer->save();

        return redirect('services/transaksiproduksi/transfer/lacak/'.$no_bon)->with('success', 'Berhasil Menambah stok Finsihed good');
    }
}
