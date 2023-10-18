<?php

namespace App\Http\Controllers\logistic;

use Illuminate\Http\Request;
use App\Models\logistic\Material;
use App\Models\logistic\Supplier;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier = Supplier::all();
        return view('logistic.dataMaster.supplier.index', compact('supplier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('logistic.dataMaster.supplier.create');
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'kd_supplier' => 'required|unique:suppliers,kd_supplier',
            'nama_supplier' => 'required|max:255',
            'email' => 'required|max:255',
            'alamat' => 'required'
        ];

        $request->validate($rules);

        Supplier::create($request->all());

        return redirect('datamaster/supplier');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
       
        return view('logistic.dataMaster.supplier.edit', [
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $rules = [
            'nama_supplier' => 'required|max:255',
            'email' => 'required|max:255',
            'alamat' => 'required'
        ];

        $request->validate($rules);
        $supplier->update($request->all());

        return redirect('datamaster/supplier')->with('success', 'berhasil edit supplier');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect('datamaster/supplier')->with('success', 'Data telah di hapus');
    }
}
