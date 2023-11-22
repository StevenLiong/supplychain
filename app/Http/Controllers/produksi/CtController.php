<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\produksi\Ct;
use App\Models\produksi\ManHour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CtController extends Controller
{
    public function create(): Response
    {
        return response(view('produksi.standardized_work.formct', ['manhour' => ManHour::all()]));
    }

    public function createManhour($id)
    {
        $manhour = ManHour::where('ukuran_kapasitas', $id)->get();

        return response()->json($manhour);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $params = $request->validated();

        $checkboxFields = ['potong_isolasi', 'lv_bobbin', 'lv_moulding', 'touch_up', 'others', 'accesories', 'potong_isolasi_fiber'];

        foreach ($checkboxFields as $field) {
            $checkbox = $request->input($field);
            $params[$field] = implode(',', $checkbox);
        }

        Ct::create($params);

        return redirect(route('home'))->with('success', 'Added!');
    }

    public function edit(string $id): Response
    {
        $product = Ct::findOrFail($id);
        $manhour = ManHour::orderBy('id')->get();



        return response(view('produksi.standardized_work.edit', ['product' => $product, 'manhour' => $manhour]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        $product = Ct::findOrFail($id);
        $params = $request->validated();

        if ($product->update($params)) {

            return redirect(route('home'))->with('success', 'Updated!');
        }
    }
}
