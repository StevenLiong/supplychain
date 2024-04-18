<?php

namespace App\Http\Controllers\produksi\StandardizedWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\produksi\ManHourOilCustom;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\ManHour;
use App\Models\produksi\OilCustom;
use App\Models\produksi\StandardizeWork;
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
        // $params = $request->all();

        // $checkboxFields = ['potong_isolasi', 'lv_bobbin', 'lv_moulding', 'touch_up', 'others', 'accesories', 'potong_isolasi_fiber'];

        // foreach ($checkboxFields as $field) {
        //     $checkbox = $request->input($field);
        //     $params[$field] = implode(',', $checkbox);
        // }



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

        $multipleFields = ['coil_lv', 'coil_hv', 'cca', 'core_coil_assembly','connection','final_assy','special_assembly','finishing','qc_testing' ];

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

        OilCustom::create($params);

        return redirect(route('home'))->with('success', 'Added!');
    }


}
