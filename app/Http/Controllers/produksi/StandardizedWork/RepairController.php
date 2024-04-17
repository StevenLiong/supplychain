<?php

namespace App\Http\Controllers\produksi\StandardizedWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\produksi\Kapasitas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Models\produksi\ManHour;
use App\Models\produksi\Repair;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function create(): Response
    {

        $title = 'Form Repair';
        $manhour = Manhour::all();
        $kapasitas = Kapasitas::all();

        // dd($kapasitas);
        return response(view('produksi.standardized_work.form.formrepair', ['manhour' => $manhour, 'kapasitas' => $kapasitas, 'title' => $title]));

    }

    public function createManhour($id)
    {
        $manhour = ManHour::where('ukuran_kapasitas', $id)->get();

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

        Repair::create($params);

        return redirect(route('home'))->with('success', 'Added!');
    }

    // public function edit(string $id): Response
    // {
    //     $product = Repair::findOrFail($id);
    //     $manhour = ManHour::orderBy('id')->get();



    //     return response(view('produksi.standardized_work.edit', ['product' => $product, 'manhour' => $manhour]));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdateProductRequest $request, string $id): RedirectResponse
    // {
    //     $product = Repair::findOrFail($id);
    //     $params = $request->validated();

    //     if ($product->update($params)) {

    //         return redirect(route('home'))->with('success', 'Updated!');
    //     }
    // }
}
