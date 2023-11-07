<?php

namespace App\Http\Controllers\logistic;

use App\Models\logistic\Rak;
use Illuminate\Http\Request;
use App\Models\logistic\Gudang;
use App\Models\logistic\Material;
use App\Http\Controllers\Controller;

class RakController extends Controller
{
    public function index()
    {
        $rack = Rak::with('gudang')->get();
        return view('logistic.dataMaster.rack.index', compact('rack'));
    }

    public function create()
    {
        $gudang = Gudang::all();
        return view('logistic.dataMaster.rack.create', compact('gudang'));
    }

    public function store(Request $request)
    {
        $rules = [
            'kd_rak' => 'required|unique:raks,kd_rak',
            'kd_gudang' => 'required',
        ];

        $request->validate($rules);

        Rak::create($request->all());

        return redirect('datamaster/rak')->with('success', 'Berhasil Menambah Data Rak');

        
    }

    public function show($id)
    {
        $rak = Rak::find($id);
        return view('logistic.dataMaster.rack.show', compact('rak'));
    }

    public function edit($id)
    {
        $rak = Rak::with('gudang')->find($id);
        $gudang = Gudang::all();
        return view('logistic.dataMaster.rack.edit', [
            'rak' => $rak,
            'gudang' => $gudang
        ]);
    }

    public function update(Request $request, Rak $rak)
    {
        var_dump($rak);
        // $rules = [
        //     'kd_rak' => 'required',
        //     'kd_gudang' => 'required',
        // ];

        // $request->validate($rules);

        // $rak->update($request->all());

        // return redirect('datamaster/rak')->with('success', 'Berhasil Edit Data Rak');
    }


    public function destroy(Rak $rak)
    {
        $rak->delete($rak->id);
        return redirect('datamaster/rak')->with('success', 'Data telah di hapus');
    }

    public function print($id)
    {
        $rak = Rak::find($id);

        return view('logistic.dataMaster.rack.printRak', compact('rak'));
    }

}
