<?php

namespace App\Http\Controllers\produksi\StandardizedWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\ManHour;
use App\Models\produksi\ManHourOilstandard;
use App\Models\produksi\OilStandard;
use App\Models\produksi\StandardizeWork;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class OilStandardController extends Controller
{
    public function create(): Response
    {

        $title = 'Form Oil Standard';
        $manhour = ManHourOilstandard::all();
        $kapasitas = Kapasitas::all();

        // dd($kapasitas);
        return response(view('produksi.standardized_work.form.formoilstandart', ['manhour' => $manhour, 'kapasitas' => $kapasitas, 'title' => $title]));

    }

    public function createManhour($id)
    {
        $manhour = ManHourOilstandard::where('ukuran_kapasitas', $id)->get();

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

        $multipleFields = ['coil_lv', 'coil_hv', 'final_assembly', 'core_coil_assembly', ];

        foreach ($multipleFields as $field) {
            $multiple = $request->input($field);

            // Periksa apakah $multiple adalah array sebelum menggunakan implode
            if (is_array($multiple)) {
                $params[$field] = implode(',', $multiple);
            } else {
                // Jika bukan array, mungkin lakukan penanganan sesuai kebutuhan Anda
                $params[$field] = $multiple;
            }
        }

        // dd($multiple);

        $existingStandardizeWork = StandardizeWork::where('kd_manhour', $params['kd_manhour'])->first();

        if ($existingStandardizeWork) {
            return redirect()->back()->withInput()->with('error', 'Nomor SO yang Anda input sudah ada. Harap periksa kembali!');
        }

        OilStandard::create($params);

        return redirect(route('home'))->with('success', 'Added!');
    }
    // public function store(Request $request)
    // {
    //     // dd($request->input('customRadio-11'));
    //     $params = $request->all();

    //     $multipleFields = ['coil_lv', 'coil_hv', 'final_assembly', 'core_coil_assembly', ];

    //     foreach ($multipleFields as $field) {
    //         $multiple = $request->input($field);

    //         if (is_array($multiple)) {
    //             $params[$field] = implode(',', $multiple);
    //         } else {
    //             $params[$field] = $multiple;
    //         }
    //     }

    //     $existingStandardizeWork = StandardizeWork::where('kd_manhour', $params['kd_manhour'])->first();

    //     if ($existingStandardizeWork) {
    //         return redirect()->back()->withInput()->with('error', 'Nomor SO yang Anda input sudah ada. Harap periksa kembali!');
    //     }

    //     OilStandard::create($params);

    //     return redirect(route('home'))->with('success', 'Added!');
    // }

    // public function edit(string $id): Response
    // {
    //     $product = OilStandard::findOrFail($id);
    //     $manhour = ManHour::orderBy('id')->get();



    //     return response(view('produksi.standardized_work.edit', ['product' => $product, 'manhour' => $manhour]));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     $product = OilStandard::findOrFail($id);
    //     $params = $request->validated();

    //     if ($product->update($params)) {

    //         return redirect(route('home'))->with('success', 'Updated!');
    //     }
    // }
}
