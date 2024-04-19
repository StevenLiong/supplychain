<?php

namespace App\Http\Controllers\produksi\StandardizedWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\produksi\Kapasitas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Models\produksi\ManHour;
use App\Models\produksi\ManHourRepair;
use App\Models\produksi\Repair;
use App\Models\produksi\StandardizeWork;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function create(): Response
    {

        $title = 'Form Repair';
        $manhour = ManHourRepair::all();
        $kapasitas = Kapasitas::all();

        // dd($kapasitas);
        return response(view('produksi.standardized_work.form.formrepair', ['manhour' => $manhour, 'kapasitas' => $kapasitas, 'title' => $title]));

    }

    public function createManhour($id)
    {
        $manhour = ManHourRepair::where('ukuran_kapasitas', $id)->get();

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

        // Repair::create($params);

        // return redirect(route('home'))->with('success', 'Added!');
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

        $multipleFields = [ 'coil_lv','coil_hv','connect','final_assembly','accessories','qc'];

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

        Repair::create($params);

        return redirect(route('home'))->with('success', 'Added!');

    }
}
