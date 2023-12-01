<?php

namespace App\Http\Controllers\purchaser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\purchaser\delivery;
use App\Models\purchaser\po;
use App\Models\purchaser\mr;
// use App\Models\supplier;
use App\Models\logistic\Supplier as supplier;

use Carbon\Carbon;

class poController extends Controller
{
    //
    public function index()
    {
        return view('purchaser.contentpo.dashboardpo');
    }

    //tampilan data mr
    public function purchaseOrder()
    {

        $dataPo = mr::all();
        return view('purchaser.contentpo.purchaseorder', ['dataPo' => $dataPo,]);
    }

    //create data po
    public function createpo($id_mr)
    {
        $po = mr::all()->where('id_mr', $id_mr)->first();
        $length = 10;
        $suppliers = supplier::all();
        $deliverys = delivery::all();
        $uniqueNumber = str_pad(random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        $id = 'PO' . $uniqueNumber;
        $now = Carbon::now();
        return view(
            'purchaser.contentpo.adddatamaterialpo',
            [
                'po' => $po,
                'id' => $id,
                'now' => $now,
                'suppliers' => $suppliers,
                'deliverys' => $deliverys
            ]
        );
    }

    //create data form to DB
    // @dd($request->all());
    public function storepo(Request $request)
    {
        $validated = $request->validate([
            'id_mr' => 'required',
            'id_po' => 'required',
            'tanggal_po' => 'required',
            'status_po' => 'required',
            'jenispembelian' => 'required',
            'tanggal_kirim' => 'required',
            'keterangan' => 'required',
            'kd_supplier' => 'required',
            'id_delivery' => 'required',
            'jenispembayaran' => 'required',
            'term' => 'required',
        ]);

        $po = new po();
        $po->id_po = $validated['id_po'];
        $po->tanggal_po = $validated['tanggal_po'];
        $po->status_po = $validated['status_po'];
        $po->jenispembelian = $validated['jenispembelian'];
        $po->tanggal_kirim = $validated['tanggal_kirim'];
        $po->keterangan = $validated['keterangan'];
        $po->kd_supplier = $validated['kd_supplier'];
        $po->id_delivery = $validated['id_delivery'];
        $po->jenispembayaran = $validated['jenispembayaran'];
        $po->term = $validated['term'];
        $po->id_mr = $validated['id_mr'];

        $po->save();

        $mr = mr::where('id_mr', $validated['id_mr'])->first();
        $mr->id_po = $validated['id_po'];
        $mr->save();

        return redirect('/purchaseorder')->with('success', 'Item has been created successfully!');
    }
}
