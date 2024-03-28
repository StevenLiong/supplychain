<?php

namespace App\Http\Controllers\produksi\StandardizedWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\produksi\DryCastResin;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\ManHour;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


class DryCastResinController extends Controller
{
    public function create(): Response
    {
        $title = 'Form Dry Cast Resin';
        $manhour = Manhour::all();
        $kapasitas = Kapasitas::all();
        // dd($kapasitas->where(''));
        return response(view('produksi.standardized_work.form.formdrycastresin', ['manhour' => $manhour, 'kapasitas' => $kapasitas, 'title' => $title]));
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
        // Validasi input
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

        $multipleFields = ['potong_isolasi', 'lv_bobbin', 'lv_moulding', 'touch_up', 'others', 'accesories', 'oven', 'potong_isolasi_fiber', 'qc_testing'];

        foreach ($multipleFields as $field) {
            $multiple = $request->input($field);

            if (is_array($multiple)) {
                $params[$field] = implode(',', $multiple);
            } else {
                $params[$field] = $multiple;
            }
        }

        // Check if kd_manhour already exists
        $existingDryResin = DryCastResin::where('kd_manhour', $params['kd_manhour'])->first();

        if ($existingDryResin) {
            return redirect()->back()->withInput()->with('error', 'Nomor SO yang anda input sudah ada coba periksa kembali  !');
        }

        // Kd_manhour doesn't exist, create new DryCastResin
        DryCastResin::create($params);

        return redirect(route('home'))->with('success', 'Added!');
    }



    public function detail(string $id): Response
    {
        $title = 'Detail Dry Cast Resin';
        $product = DryCastResin::findOrFail($id);
        $manhour = ManHour::orderBy('id')->get();
        return response(view('produksi.standardized_work.detaildrycastresin', ['product' => $product, 'manhour' => $manhour, 'title' => $title]));
    }

    public function edit(string $id): Response
    {
        $title = 'Edit Dry Cast Resin';
        $product = DryCastResin::findOrFail($id);
        $manhour = ManHour::orderBy('id')->get();
        // $kapasitas = Kapasitas::all();
        return response(view('produksi.standardized_work.editdrycastresin', ['product' => $product, 'manhour' => $manhour,  'title' => $title]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = DryCastResin::findOrFail($id);
        $params = $request->all();

        if ($product->update($params)) {

            return redirect(route('home'))->with('success', 'Updated!');
        }
    }
}
