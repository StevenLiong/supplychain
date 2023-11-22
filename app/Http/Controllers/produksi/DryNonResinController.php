<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\produksi\DryNonResin;
use App\Models\produksi\ManHour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DryNonResinController extends Controller
{
    public function create(): Response
    {
        // $standardize_works = StandardizeWork::all();
        return response(view('standardized_work.formdrynonresin',['manhour' => ManHour::all()]));
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

        DryNonResin::create($params);

        return redirect(route('home'))->with('success', 'Added!');
    }

    public function edit(string $id): Response
    {
        $product = DryNonResin::findOrFail($id);
        $manhour = ManHour::orderBy('id')->get();



        return response(view('standardized_work.edit', ['product' => $product, 'manhour' => $manhour]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        $product = DryNonResin::findOrFail($id);
        $params = $request->validated();

        if ($product->update($params)) {

            return redirect(route('home'))->with('success', 'Updated!');
        }
    }
}
