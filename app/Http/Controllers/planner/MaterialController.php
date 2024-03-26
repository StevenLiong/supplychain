<?php

namespace App\Http\Controllers\planner;

use App\Imports\MaterialImport;
use App\Models\planner\Material;
use App\Models\planner\MaterialPlanner;
use App\Models\planner\Stock;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MaterialController extends Controller
{
    public function index()
    {
        $detailMaterial = Material::all();
        // foreach ($detailMaterial as $item) {
        //     $stock = $item;
        //     $stock->updateStockOnHand();
        // }
        return view('planner.material.index', compact('detailMaterial'));
    }

    public function formUpload()
    {
        return view('planner.material.upload-stock');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();

        for ($row = 3; $row <= 1000; $row++) {
            $item_code = $worksheet->getCell("A$row")->getValue();
            $item_name = $worksheet->getCell("B$row")->getFormattedValue();
            $unit = $worksheet->getCell("C$row")->getFormattedValue();
            $qty = $worksheet->getCell("D$row")->getValue();
    
            // $existing_material = Material::where('kd_material', $item_code)->first();
    
            // if (!$existing_material && $item_code !== null) {
            //     $material = new Material();
            //     $material->kd_material = $item_code;
            //     $material->nama_material = $item_name;
            //     $material->satuan = $unit;
            //     $material->jumlah = $qty;
            //     $material->save();
            // }

            $material = new Material();
                $material->kd_material = $item_code;
                $material->nama_material = $item_name;
                $material->satuan = $unit;
                $material->jumlah = $qty;

                $cekMaterial = Material::where('kd_material', $item_code)->exists();
                if ($cekMaterial) {
                    return redirect()->back()->withInput()->withErrors(['error' => 'Terdapat id material yang sudah ada']);
                }

                $material->save();
        }
        return redirect('/Material/IndexMaterial');
        // /Material/IndexMaterial
    }
    
    public function destroy()
    {
        Material::query()->delete();

        return redirect()->back();
    }

}