<?php

namespace App\Http\Controllers\logistic;


use Illuminate\Support\Str;
use App\Models\purchaser\po;
use Illuminate\Http\Request;
use App\Models\logistic\Bpnb;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class BpnbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bpnb = Bpnb::latest()->get();
        return view('logistic.receiving.bpnb.index', compact('bpnb'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $po = po::all();
        return view('logistic.receiving.bpnb.create', compact('po'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Bpnb::create([
            'id_po' => $request->input('id_po'),
            'surat_jalan' => $request->input('surat_jalan'),
            'tgl_bpnb' => $request->input('tgl_bpnb'),
            'tgl_suratjalan' => $request->input('tgl_suratjalan'),
        ]);

        return redirect('receiving/bpnb')->with('success', 'BPNB berhasil di buat');
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

    public function print($no_bon)
    {
        $bpnb = Bpnb::where('no_bon', $no_bon)->first();
        return view('logistic.receiving.bpnb.printbpnb', compact('bpnb'));
    }
}
