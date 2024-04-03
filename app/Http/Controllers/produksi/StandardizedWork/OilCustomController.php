<?php

namespace App\Http\Controllers\produksi\StandardizedWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\produksi\ManHourOilCustom;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\ManHour;
use App\Models\produksi\OilCustom;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class OilCustomController extends Controller
{
    public function create(): Response
    {

        $title = 'Form Oil Custom';
        $manhour = ManHourOilCustom::all();
        $kapasitas = Kapasitas::all();
        // dd($manhour);

        return response(view('produksi.standardized_work.form.formoilcustom', ['manhour' => $manhour, 'kapasitas' => $kapasitas, 'title' => $title]));

    }

    public function createManhour($id)
    {
        $manhour = ManHourOilCustom::where('ukuran_kapasitas', $id)->get();

        return response()->json($manhour);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->input('customRadio-11'));
        $params = $request->all();

        $checkboxFields = ['potong_isolasi', 'lv_bobbin', 'lv_moulding', 'touch_up', 'others', 'accesories', 'potong_isolasi_fiber'];

        foreach ($checkboxFields as $field) {
            $checkbox = $request->input($field);
            $params[$field] = implode(',', $checkbox);
        }

        OilCustom::create($params);

        return redirect(route('home'))->with('success', 'Added!');
    }


}
