<?php

namespace App\Http\Controllers\purchaser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\purchaser\delivery;
use App\Models\purchaser\po;
use App\Models\purchaser\mr;
// use App\Models\supplier;
use App\Models\logistic\Supplier as supplier;
use App\Models\purchaser\pesanan;
use Carbon\Carbon;

class poController extends Controller
{
    //
    public function index()
    {
        $dataPo = mr::all();
        return view('purchaser.contentpo.purchaseorder', ['dataPo' => $dataPo,]);
    }

    public function reportPo()
    {
        $dataPo = mr :: all();
        return view('purchaser.contentpo.reportpo', ['dataPo' => $dataPo,]);
    }

    //tampilan data mr
    // public function purchaseOrder()
    // {
    //     $dataPo = mr::all();
    //     return view('purchaser.contentpo.purchaseorder', ['dataPo' => $dataPo,]);
    // }

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

    public function editpo($id_po)
    {
        $po = po::where('id_po', $id_po)->firstOrFail();
        return view(
            'purchaser.contentpo.editdatamaterialpo',
            [
                'po' => $po,
            ]
        );
    }

    //save stage edit mr from DB
    public function storeEditpo($id_po, Request $request)
    {
        //  @dd($request->all());
        $validated = $request->validate([
            'status_po' => 'required',
            'keterangan' => 'required',
            'term' => 'required',
            'pesanan' => 'required',
            'total' => 'required'
        ]);
        //  dd($validated);
        $po = po::where('id_po', $id_po)->firstOrFail();

        $po->status_po = $validated['status_po'];
        $po->keterangan = $validated['keterangan'];
        $po->term = $validated['term'];

        foreach ($validated['pesanan'] as $key => $value) {
            $pesanan = Pesanan::where('id_pesanan', $value)->firstOrFail();
            $pesanan->total = $validated['total'][$key];
            $pesanan->save();
        }
        $po->save();

        return redirect('/purchaseorder')->with('success', 'Item has been edited successfully!');
    }

    //create data form to DB
    public function storepo(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'id_po' => 'required',
            'tanggal_po' => 'required',
            'supplier' => 'required',
            'status_po' => 'required',
            'jenispembelian' => 'required',
            'term' => 'required',
            'tanggal_kirim' => 'required',
            'jenispembayaran' => 'required',
            'id_mr' => 'required',
            'keterangan' => 'required',
            'id_delivery' => 'required',
            'pesanan' => 'required',
            'total' => 'required',
        ]);

        // dd($validated);
        $po = new po();
        $po->id_po = $validated['id_po'];
        $po->tanggal_po = $validated['tanggal_po'];
        $po->status_po = $validated['status_po'];
        $po->kd_supplier = $validated['supplier'];
        $po->jenispembelian = $validated['jenispembelian'];
        $po->tanggal_kirim = $validated['tanggal_kirim'];
        $po->keterangan = $validated['keterangan'];
        $po->id_delivery = $validated['id_delivery'];
        $po->jenispembayaran = $validated['jenispembayaran'];
        $po->term = $validated['term'];
        $po->id_mr = $validated['id_mr'];

        $mr = mr::where('id_mr', $validated['id_mr'])->firstOrFail();
        $mr->id_po = $validated['id_po'];
        $mr->save();

        foreach ($validated['pesanan'] as $key => $value) {
            $pesanan = Pesanan::where('id_pesanan', $value)->firstOrFail();
            $pesanan->total = $validated['total'][$key];
            $pesanan->save();
        }
        $po->save();
        
        return redirect('/purchaseorder')->with('success', 'Item has been created successfully!');
    }
}
