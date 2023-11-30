<?php

namespace App\Http\Controllers\purchaser;

use App\Http\Controllers\Controller;
use App\Models\purchaser\division;
use App\Models\logistic\Material as material;
use App\Models\purchaser\pesanan;
use App\Models\purchaser\mr as mr;
use Illuminate\Http\Request; 
use GuzzleHttp\Promise\Create;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class mrController extends Controller
{
 
    public function index()
    {
        return view('purchaser.contentmr.dashboardmr');
    }
    public function materialRequest()
    {
        $dataMr = mr::all();
        return view('purchaser.contentmr.materialrequest',['dataMr' => $dataMr,]);      
    }

    public function editmaterial()
    {
        return view('purchaser.contentmr.editmaterialmr');
    }

    public function tableMaterial()
    {
        return view('purchaser.contentmr.tabelmaterialmr');
    }

    //create data mr
    public function createmr()
    {
        $length = 10;
        $divisions = division::all();
        $uniqueNumber = str_pad(random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        $id = 'MR' . $uniqueNumber;
        $now = Carbon::now();
        $materials = material::all();
        return view(
            'purchaser.contentmr.adddatamaterialmr',
            [
                'id' => $id,
                'now' => $now,
                'materials' => $materials,
                'divisions'=>$divisions
            ]
        );

    }

    //edit mr to DB
    public function editmr($id_mr)
    {
        $mr = mr::where('id_mr',$id_mr)->firstOrFail();
        $materials = material::all()->groupBy('name_material');
        return view('purchaser.contentmr.editdatamaterialmr',
            [
                'mr' => $mr,
                'materials' => $materials
            ]
        );

    }

    //save stage edit mr from DB
    public function storeEditmr($id_mr , Request $request)
    {
        $validated = $request->validate([
            'status_mr'=>'required',
            'keterangan'=>'required',
            'qty'=>'required',
            'material'=>'required',
        ]);

        $mr = mr::where('id_mr',$id_mr)->firstOrFail();

        $mr->status_mr = $validated['status_mr'];
        $mr_keterangan = $validated['keterangan'];

        foreach ($validated['material'] as $key => $value) {
            $pesanan = new pesanan();
            $pesanan->id_material = $value;
            $pesanan->id_mr = $mr->id_mr;
            $pesanan->qty_pesanan = $validated['qty'][$key];
            $pesanan->save();
        }
        $mr->save();

        return redirect('/materialrequest')->with('success', 'Item has been created successfully!'); 

    }

    //create data form to DB
    public function storemr(Request $request)
    { 
        $validated = $request->validate([
            'id_mr'=>'required',
            'id_po'=>'required',
            'keterangan'=>'required',
            'status_mr'=>'required',
            'tanggal_mr'=>'required',
            'accepted_mr'=>'required',
            'id_division'=>'required',
            'material'=>'required',
            'qty'=>'required',
        ]);
        $mr = new mr();
        $mr->id_mr = $validated['id_mr']; // asumsi 'name' adalah nama kolom di tabel
        $mr->keterangan = $validated['keterangan']; // asumsi 'name' adalah nama kolom di tabel
        $mr->status_mr = $validated['status_mr']; // asumsi 'name' adalah nama kolom di tabel
        $mr->tanggal_mr = $validated['tanggal_mr']; // asumsi 'name' adalah nama kolom di tabel
        $mr->accepted_mr = $validated['accepted_mr']; // asumsi 'name' adalah nama kolom di tabel
        $mr->id_division = $validated['id_division']; // asumsi 'name' adalah nama kolom di tabel
        $mr->id_po = $validated['id_po']; // asumsi 'name' adalah nama kolom di tabel
        
        $orders = [];
        foreach ($validated['material'] as $key => $value) {
            $pesanan = new pesanan();
            $pesanan->id_material = $value;
            $pesanan->id_mr = $mr->id_mr;
            $pesanan->qty_pesanan = $validated['qty'][$key];
            $pesanan->save();
        }
        $mr->save();

        return redirect('/materialrequest')->with('success', 'Item has been created successfully!'); 
    }

    //delete mr from DB
    public function destroymr($id)
    {
        $data = mr::where('id_mr', $id)->first();

        if ($data) {
            $data->delete();
            return redirect('/materialrequest')->with('success', 'Item has been delete successfully!');
        }

        return redirect('/materialrequest')->with('error', 'Item not found or already deleted!');
    }
}
