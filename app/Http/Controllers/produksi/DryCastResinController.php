<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\produksi\DryCastResin;
use App\Models\produksi\ManHour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class DryCastResinController extends Controller
{
    public function create(): Response
    {
        return response(view('produksi.standardized_work.formdrycastresin', ['manhour' => ManHour::all()]));
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

        $multipleFields = ['potong_isolasi', 'lv_bobbin', 'lv_moulding', 'touch_up', 'others', 'accesories', 'potong_isolasi_fiber'];

        foreach ($multipleFields as $field) {
            $multiple = $request->input($field);

            if (is_array($multiple)) {
                $params[$field] = implode(',', $multiple);
            } else {
                $params[$field] = $multiple;
            }
        }

        DryCastResin::create($params);

        return redirect(route('home'))->with('success', 'Added!');
    }

    public function edit(string $id): Response
    {
        $product = DryCastResin::findOrFail($id);
        $manhour = ManHour::orderBy('id')->get();
        return response(view('produksi.standardized_work.editdrycastresin', ['product' => $product, 'manhour' => $manhour]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        $product = DryCastResin::findOrFail($id);
        $params = $request->validated();

        if ($product->update($params)) {

            return redirect(route('home'))->with('success', 'Updated!');
        }
    }
}
