<?php

namespace App\Http\Controllers\logistic;

use App\Http\Controllers\Controller;
use App\Models\logistic\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{

    public function index()
    {
        $material = Material::latest()->paginate(5);

        // search
        $search = strtolower(request('search'));
        if ($search) {
            $material = Material::where('nama_material', 'like', '%' . $search . '%')->paginate(5);
        }
        return view('logistic.dataMaster.material.index', compact('material'));
    }

    public function create()
    {
        return view('logistic.dataMaster.material.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'kd_material' => 'required|unique:materials,kd_material',
            'nama_material' => 'required',
            'satuan' => 'required',
            'jumlah' => 'required'
        ];

        $request->validate($rules);
        Material::create($request->all());
        return redirect('datamaster/material')->with('success', 'Data berhasil di tambah');
    }


    public function show(Material $material)
    {

    }

    public function edit($id)
    {
        return view('logistic.dataMaster.material.edit', [
            'material' => Material::find($id)
        ]);
    }

    public function update(Request $request, Material $material)
    {
        $rules = [
            'nama_material' => 'required',
            'satuan' => 'required',
            'jumlah' => 'required'
        ];

        $request->validate($rules);

        $material->update($request->all());
        return redirect('datamaster/material')->with('success', 'Data berhasil di update');
    }

    public function destroy(Material $material)
    {
        $material->delete($material->kd_material);

        return redirect('datamaster/material')->with('success', 'Berhasil di hapus');
    }

    public function print($id)
    {
        $material = Material::find($id);
        return view('logistic.dataMaster.material.print', compact('material'));
    }

    public function addStock($id)
    {
        $material = Material::find($id);
        return view('logistic.datamaster.material.addStock', compact('material'));
    }

    public function updateStock(Request $request, $id){
        $material = Material::find($id);
        
        $request->validate([
            'addstock' => 'required|numeric|min:1',
        ]);

        $material->jumlah += $request->input('addstock');
        $material->save();

        return redirect('datamaster/material/addstock/'.$id)->with('success', 'Stock added successfully');
    }
}
