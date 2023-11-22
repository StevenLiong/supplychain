<?php

namespace App\Http\Controllers;

use App\Models\division;
use App\Models\mr;
use App\Models\material;
use App\Models\pesanan;
use Illuminate\Http\Request; 
use GuzzleHttp\Promise\Create;
use Carbon\Carbon;



class mrController extends Controller
{
    //
    public function index()
    {
        return view('contentmr.dashboardmr');
    }
    public function materialRequest()
    {
        $dataMr = mr::all();
        return view(
            'contentmr.materialrequest',

            [
                'dataMr' => $dataMr,
            ]
        );      
    }

    public function editmaterial()
    {
        return view('contentmr.editmaterialmr');
    }

    public function tableMaterial()
    {
        return view('contentmr.tabelmaterialmr');
    }


    public function createmr()
    {
        $length = 10;
        $divisions = division::all();
        $uniqueNumber = str_pad(random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        $id = 'MR' . $uniqueNumber;
        $now = Carbon::now();
        $material = material::all()->groupBy('name_material');
        return view(
            'contentmr.adddatamaterialmr',
            [
                'id' => $id,
                'now' => $now,
                'materials' => $material,
                'divisions'=>$divisions
            ]
        );

    }

    public function editmr($id_mr)
    {
        $mr = mr::where('id_mr',$id_mr)->firstOrFail();
        $materials = material::all()->groupBy('name_material');
        return view(
            'contentmr.editdatamaterialmr',
            [
                'mr' => $mr,
                'materials' => $materials
            ]
        );

    }



    public function storemr(Request $request)
    { 
        $validated = $request->validate([
            'id_mr'=>'required',
            'keterangan'=>'required',
            'status_mr'=>'required',
            'tanggal_mr'=>'required',
            'id_division'=>'required',
            'material'=>'required',
            'qty'=>'required',
        ]);
        $mr = new mr();
        $mr->id_mr = $validated['id_mr']; // asumsi 'name' adalah nama kolom di tabel
        $mr->keterangan = $validated['keterangan']; // asumsi 'name' adalah nama kolom di tabel
        $mr->status_mr = $validated['status_mr']; // asumsi 'name' adalah nama kolom di tabel
        $mr->tanggal_mr = $validated['tanggal_mr']; // asumsi 'name' adalah nama kolom di tabel
        $mr->id_division = $validated['id_division']; // asumsi 'name' adalah nama kolom di tabel
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
