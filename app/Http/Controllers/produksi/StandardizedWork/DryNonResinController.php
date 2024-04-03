<?php

namespace App\Http\Controllers\produksi\StandardizedWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\produksi\DryNonResin;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\ManHour;
use App\Models\produksi\ManhourDrynonresin;
use App\Models\produksi\StandardizeWork;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DryNonResinController extends Controller
{
    public function create(): Response
    {
        // $standardize_works = StandardizeWork::all();
        $title = 'Form Dry Non Resin';
        $manhour = ManhourDrynonresin::all();
        $kapasitas = Kapasitas::all();

        // dd($kapasitas);
        return response(view('produksi.standardized_work.form.formdrynonresin', ['manhour' => $manhour, 'kapasitas' => $kapasitas, 'title' => $title]));

    }


    public function createManhour($id)
    {
        $manhour = ManhourDrynonresin::where('ukuran_kapasitas', $id)->get();

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

        // Cek apakah 'customRadio-11' ada dalam permintaan
        if ($request->has('customRadio-11')) {
            // Jika ada, set kolom 'keterangan' dengan nilai radio button
            $params['keterangan'] = $request->input('customRadio-11');
        } else {
            // Jika tidak ada, gunakan nilai default
            $params['keterangan'] = 'Tidak Menggunakan Housing';
        }

        $multipleFields = ['oven','potong_isolasi', 'others', 'accesories', 'potong_isolasi_fiber','qc_testing'];

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

        $existingStandardizeWork = StandardizeWork::where('kd_manhour', $params['kd_manhour'])->first();

        if ($existingStandardizeWork) {
            return redirect()->back()->withInput()->with('error', 'Nomor SO yang Anda input sudah ada. Harap periksa kembali!');
        }
        DryNonResin::create($params);

        return redirect(route('home'))->with('success', 'Added!');
    }

    public function edit(string $id): Response
    {
        $product = DryNonResin::findOrFail($id);
        $manhour = ManhourDrynonresin::orderBy('id')->get();

        return response(view('produksi.standardized_work.edit', ['product' => $product, 'manhour' => $manhour]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request,string $id)
    {
        $product = DryNonResin::findOrFail($id);
        $params = $request->all();
        if ($product->update($params)) {

            return redirect(route('home'))->with('success', 'Updated!');
        }
    }
}
