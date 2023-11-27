<?php

namespace App\Http\Controllers\logistic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\logistic\MaterialRak;

class PickingController extends Controller
{
    public function pickingScan()
    {

        $materialRak = MaterialRak::with('material', 'rak')->latest()->paginate(2);
        $search = strtolower(request('search'));
        if ($search) {
            $materialRak = MaterialRak::whereHas('material', function ($query) use ($search) {
                $query->where('kd_material', 'like', '%' . $search . '%');
            })->paginate(5);
            
        }
        return view('logistic.services.transaksigudang.pickingScan', compact('materialRak'));
    }

    public function cutStock($id)
    {
        $materialRak = MaterialRak::find($id);
        return view('logistic.services.transaksigudang.pickingCut', compact('materialRak'));
    }

    public function updateStock(Request $request, $id)
    {
        $materialRak = MaterialRak::find($id);

        $request->validate([
            'cutstock' => 'required|numeric|min:1',
        ]);

        $materialRak->qty_rak -= $request->input('cutstock');
        $materialRak->save();

        return redirect('services/transaksigudang/picking/cutstock/' . $id)->with('success', 'Cutting stock successfully');
    }
}
