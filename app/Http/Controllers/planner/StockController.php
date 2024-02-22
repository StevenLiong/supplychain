<?php

namespace App\Http\Controllers\planner;

use App\Imports\StockImport;
use App\Models\planner\Stock;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\MaterialPendingNotification;
use App\Models\logistic\Material;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function indexSt()
    {
        $detailStock = Stock::with('material')->get();
        // $stockMaterial = Material::whereIn('kd_material', $detailStock->pluck('item_code')->toArray())
        //                 ->select('kd_material', 'jumlah')
        //                 ->get();
        // dd($stockMaterial);

        foreach ($detailStock as $item) {
            $stock = $item;
            $stock->updateStockOnHand();
        }
        return view('planner.stock.index', compact('detailStock'));
    }
    public function formUpload()
    {
        return view('planner.stock.upload-stock');
    }

    public function upload(Request $request)
    {
        // Validate file
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            return redirect('/Stock/formUpload')
                ->withErrors($validator)
                ->withInput();
        }

        // Get the file from the request
        $file = $request->file('file');

        // Determine the chunk size
        $chunkSize = 1024 * 1024; // 1 MB

        // Process the file in chunks
        $chunks = [];
        $chunkIndex = 0;

        // Open the file for reading
        $fileHandler = fopen($file->getPathname(), 'r');

        // Loop throughpublic function upload(Request $request)
        {
            // Validate file
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:xls,xlsx',
            ]);

            if ($validator->fails()) {
                return redirect('/Stock/formUpload')
                    ->withErrors($validator)
                    ->withInput();
            }

            // Get the file from the request
            $file = $request->file('file');

            // Validate and import the entire file without chunks
            Excel::import(new StockImport(), $file);
            return redirect('/Stock/IndexStock');
        }
    }
    public function destroy()
    {
        // Hapus semua data dari tabel stock
        Stock::truncate();

        return redirect()->back();
    }
}