<?php

namespace App\Http\Controllers\logistic;

use Illuminate\Http\Request;
use App\Models\logistic\Incoming;
use App\Models\logistic\Material;
use App\Models\logistic\Supplier;
use App\Http\Controllers\Controller;

class IncomingController extends Controller
{
    public function index()
    {
        $incoming = Incoming::with('material', 'supplier')->get();
        return view('logistic.receiving.index', compact('incoming'));
    }

    public function create()
    {
        $incoming = Incoming::with('material', 'supplier');
        $material = Material::all();
        $supplier = Supplier::all();
        return view('logistic.receiving.create', [
            'incoming' => $incoming,
            'material' => $material,
            'supplier' => $supplier
        ]);
    }

    public function store(Request $request, Incoming $incoming)
    {
        $rules = [
            'kd_material' => 'required',
            'kd_supplier' => 'required',
            'no_po' => 'required',
            'no_surat_jalan' => 'required',
            'batch_datang' => 'required',
            'qty_kedatangan' => 'required|numeric',
        ];

        $request->validate($rules);

        Incoming::create($request->all());

        return redirect('receiving/incoming')->with('success', 'berhasil menambahkan data');
    }

    public function show()
    {
    }

    public function edit()
    {
        return view('logistic.receiving.edit');
    }

    public function update(Request $request)
    {
    }

    public function print()
    {
        return view('logistic.receiving.print');
    }
}
