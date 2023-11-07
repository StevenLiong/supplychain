<?php

namespace App\Http\Controllers\logistic;

use Milon\Barcode\DNS2D;
use Illuminate\Http\Request;
use App\Models\logistic\Incoming;
use App\Models\logistic\Material;
use App\Models\logistic\Supplier;
use App\Http\Controllers\Controller;
use App\Models\logistic\MaterialRak;


class IncomingController extends Controller
{
    public function index()
    {
        $incoming = Incoming::with('materialRak', 'supplier')->get();
        return view('logistic.receiving.index', compact('incoming'));
    }

    public function create()
    {
        $incoming = Incoming::with('materialRak', 'supplier');
        $supplier = Supplier::all();
        $materialRak =  MaterialRak::all();
        return view('logistic.receiving.create', [
            'incoming' => $incoming,
            'materialRak' => $materialRak,
            'supplier' => $supplier
        ]);
    }

    public function store(Request $request, Incoming $incoming)
    {
        $rules = [
            'kd_material_rak' => 'required',
            'kd_supplier' => 'required',
            'no_po' => 'required',
            'no_surat_jalan' => 'required',
            'batch_datang' => 'required',
            'qty_kedatangan' => 'required|numeric',
            'tgl_kedatangan' => 'required|date',
        ];

        $request->validate($rules);

        Incoming::create($request->all());

        return redirect('receiving/incoming')->with('success', 'berhasil menambahkan data');
    }

    public function show($id)
    {
        $incoming = Incoming::with('materialRak', 'supplier')->find($id);
        return view('logistic.receiving.show', compact('incoming'));
    }

    public function edit($id)
    {
        $incoming = Incoming::with('materialRak', 'supplier')->find($id);
        $materialRak = MaterialRak::all();
        $supplier = Supplier::all();
        return view('logistic.receiving.edit', compact('incoming', 'materialRak', 'supplier'));
    }

    public function update(Request $request, Incoming $incoming)
    {   
        $rules = [
            'kd_material_rak' => 'required',
            'kd_supplier' => 'required',
            'no_po' => 'required',
            'no_surat_jalan' => 'required',
            'batch_datang' => 'required',
            'qty_kedatangan' => 'required|numeric',
            'tgl_kedatangan' => 'required|date',
        ];
        $request->validate($rules);

        $incoming->update($request->all());

        return redirect('receiving/incoming')->with('success', 'Berhasil edit data');
    }

    public function destroy($id){
        $incoming = Incoming::find($id);

        $incoming->delete();

        return redirect('receiving/incoming')->with('success', 'Data telah di hapus');
    }

    public function print($id)
    {
        $incoming = Incoming::find($id);
        return view('logistic.receiving.print', compact('incoming'));
    }

    public function scan()
    {
        return view('logistic.receiving.scan');
    }
}
