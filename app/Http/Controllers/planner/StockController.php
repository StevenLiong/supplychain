<?php

namespace App\Http\Controllers\planner;

use App\Imports\StockImport;
use App\Models\planner\Stock;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function indexSt()
    {
        $detailStock = Stock::with('material')->get();
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
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            return redirect('/Stock/formUpload')
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('file');
        {
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:xls,xlsx',
            ]);

            if ($validator->fails()) {
                return redirect('/Stock/formUpload')
                    ->withErrors($validator)
                    ->withInput();
            }

            $file = $request->file('file');

            Excel::import(new StockImport(), $file);
            return redirect('/Stock/IndexStock');
        }
    }
    public function destroy()
    {
        Stock::truncate();

        return redirect()->back();
    }
}