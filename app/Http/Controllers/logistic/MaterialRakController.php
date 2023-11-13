<?php

namespace App\Http\Controllers\logistic;

use App\Models\logistic\Rak;
use Illuminate\Http\Request;
use App\Models\logistic\MaterialRak;
use App\Models\logistic\Material;
use App\Http\Controllers\Controller;

class MaterialRakController extends Controller
{
    public function index()
    {
        $materialRak = MaterialRak::with('material', 'rak')->latest()->paginate(2);
        $search = strtolower(request('search'));

        if ($search) {
            $materialRak = MaterialRak::whereHas('material', function($query) use ($search){
                $query->where('nama_material', 'like', '%' .$search .'%');
            })->paginate(2);
        }
        return view('logistic.storage.rawmaterial.rackchecking', compact('materialRak'));
    }

    public function create()
    {
        $material = Material::all();
        $rak = Rak::all();
        return view('logistic.storage.rawmaterial.createRakCheck', compact('material', 'rak'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'material_id' => 'required',
            'rak_id' => 'required',
            'qty_rak' => 'required|numeric',
        ]);

        MaterialRak::create($request->all());

        return redirect('storage/rawmaterial/listmaterial')->with('success', 'Berhasil Menempatkan material ke rak');
    }

    public function edit($id)
    {
        $materialRak = MaterialRak::with('material', 'rak')->find($id);
        $material = Material::all();
        $rak = Rak::all();

        return view('logistic.storage.rawmaterial.editRakChecking', [
            'materialRak' => $materialRak,
            'material' => $material,
            'rak' => $rak
        ]);
    }

    public function update(Request $request, MaterialRak $materialRak){
        var_dump($materialRak);
    }


    public function destroy($id)
    {
        $materialRak = MaterialRak::with('material', 'rak')->find($id);

        $materialRak->delete($materialRak->id);

        return redirect('storage/rawmaterial/listmaterial')->with('success', 'berhasil di hapus');
    }


    public function scan(){
        return view('logistic.storage.rawmaterial.scan');
    }

    public function scanFg(){
        return view('logistic.storage.finishedgood.scan');
    }

    public function updateQty(){
        return view('logistic.storage.rawmaterial.updateQty');
    }


}
