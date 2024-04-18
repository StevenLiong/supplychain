<?php

namespace App\Http\Controllers\produksi\StandardizedWork;

use App\Models\produksi\ManHourCtVt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\produksi\CtVt;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\StandardizeWork;
use Illuminate\Http\Response;

class CtVtController extends Controller
{
    public function create(): Response
    {

        $title = 'Form CT/VT';
        $manhour = ManHourCtVt::all();
        $kapasitas = Kapasitas::all();

        // dd($kapasitas);
        return response(view('produksi.standardized_work.form.formctvt', ['manhour' => $manhour, 'kapasitas' => $kapasitas, 'title' => $title]));
    }

    public function createManhour($id)
    {
        $manhour = ManHourCtVt::where('ukuran_kapasitas', $id)->get();

        return response()->json($manhour);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'total_hour' => 'required',
            'ukuran_kapasitas' => 'required',
            'id_fg' => 'required',
            'nomor_so' => 'required',
        ], [
            'total_hour.required' => 'Total hour is required.',
            'ukuran_kapasitas.required' => 'Ukuran kapasitas is required.',
            'id_fg.required' => 'ID FG is required.',
            'nomor_so.required' => 'Nomor SO is required.',
        ]);
        $params = $request->all();

        $existingDryResin = StandardizeWork::where('kd_manhour', $params['kd_manhour'])->first();

        if ($existingDryResin) {
            return redirect()->back()->withInput()->with('error', 'Nomor SO yang anda input sudah ada coba periksa kembali  !');
        }
        CtVt::create($params);

        return redirect(route('home'))->with('success', 'Added!');
    }
}
