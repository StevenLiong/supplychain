<?php

namespace App\Http\Controllers\logistic;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class BpnbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('logistic.receiving.bpnb.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('logistic.receiving.bpnb.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function print (){
        // $filename = 'Report Sample' . time() . rand('9999', '999999') . Str::random('10') . '.pdf';
        // $pdfPath = public_path($filename);
        
        // $pdf = PDF::loadView('logistic.receiving.bpnb.printbpnb');
        // $pdf->save($pdfPath);

      

        // // Kembalikan respons PDF
        // return response()->download($pdfPath, $filename)->deleteFileAfterSend(true);
        return view('logistic.receiving.bpnb.printbpnb');
    }
}
