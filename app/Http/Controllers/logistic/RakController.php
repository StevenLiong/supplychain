<?php

namespace App\Http\Controllers\logistic;

use App\Models\logistic\Rak;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RakController extends Controller
{
    public function index (){
        $rack = Rak::all();
        return view('logistic.dataMaster.rack.index', compact('rack'));
    }

    public function create(){
        return view('logistic.dataMaster.rack.create');
    }

    public function store(Request $request) {
        $rules = [
            'kd_rak' => 'required|unique:raks,kd_rak',
            'qty_rak' => 'required|numeric'
        ];

        $request->validate($rules);

        Rak::create($request->all());

        return redirect('datamaster/rak')->with('success', 'Berhasil Menambah Data Rak');

    }

    public function edit(Rak $rak) {
       return view('logistic.dataMaster.rack.edit', [
        'rak' => $rak
       ]);
    }

    public function update(Request $request, Rak $rak){
        $rules = [
            'kd_rak' => 'required',
            'qty_rak' => 'required|numeric'
        ];

        $request->validate($rules);

        $rak->update($request->all());

        return redirect('datamaster/rak')->with('success', 'Berhasil Edit Data Rak');
    }

    public function destroy(Rak $rak){
     
        $rak->delete($rak->id);
        return redirect('datamaster/rak')->with('success', 'Data telah di hapus');
    }
}
