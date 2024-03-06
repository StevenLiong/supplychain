<?php

namespace App\Http\Controllers\planner;

use Carbon\Carbon;
use App\Models\planner\Mps2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\planner\KapasitasProduksi;

class Mps2Controller extends Controller
{
    public function index(){
        $endDate = Carbon::create(2024, 1, 31); // Tanggal akhir yang Anda inginkan
        $kapasitasPL2 = KapasitasProduksi::whereDate('tanggal', '<=', $endDate)
                                          ->pluck('pl2', 'tanggal')
                                          ->toArray();
        $kapasitasPL3 = KapasitasProduksi::whereDate('tanggal', '<=', $endDate)
                                          ->pluck('pl3', 'tanggal')
                                          ->toArray();
        $kapasitasDrytype = KapasitasProduksi::whereDate('tanggal', '<=', $endDate)
                                          ->pluck('drytype', 'tanggal')
                                          ->toArray();
        // Ubah format tanggal menjadi hanya tanggal (day)
        $tanggalHeaders = KapasitasProduksi::whereDate('tanggal', '<=', $endDate)
                                          ->pluck('tanggal')
                                          ->toArray();

        $mps2s = Mps2::all();
        
        return view('planner.MPS2.gantt', compact('kapasitasPL2', 'kapasitasPL3', 'kapasitasDrytype', 'tanggalHeaders', 'mps2s'));
    }  

    public function store(Request $request){
        $mps2 = new Mps2();
        $mps2->id_wo = $request->get('id_wo');
        $mps2->line = $request->get('line');
        $mps2->project = $request->get('project');
        $mps2->deadline = Carbon::createFromFormat('d-M-y', $request->get('deadline'))->format('Y-m-d');
        $mps2->kva = $request->get('kva');
        $mps2->qty_trafo = $request->get('qty_trafo');
        $mps2->save();
        
        // Validasi input untuk memastikan tidak ada input yang kosong
        $request->validate([
            'work_order' => 'required', // Pastikan work_order tidak kosong
        ]);
    
        // Ambil semua input yang dikirimkan dari formulir
        $inputs = $request->all();
    
        // Ambil tanggal dari header
        $tanggalHeaders = KapasitasProduksi::pluck('tanggal')->toArray();
    
        // Loop melalui input untuk menyimpan data ke dalam tabel mps2s
        foreach ($inputs as $key => $value) {
            // Periksa apakah kunci input berisi "jan_"
            if (strpos($key, 'jan_') !== false && $value !== null) {
                // Dapatkan indeks tanggal dari kunci input
                $tanggalIndex = (int)str_replace('jan_', '', $key) - 1;
    
                // Dapatkan tanggal dari indeks tanggal
                $tanggal = $tanggalHeaders[$tanggalIndex];
    
                // Simpan data ke dalam model Mps2
                Mps2::create([
                    'id_wo' => $inputs['work_order'],
                    'qty_trafo' => $value, // Simpan nilai input sebagai qty_trafo
                    'deadline' => $tanggal, // Simpan tanggal sesuai dengan header sebagai deadline
                ]);
            }
        }
    
        // Redirect ke halaman yang sesuai dan beri pesan sukses
        return redirect()->route('mps2-index')->with('success', 'Data berhasil disimpan.');
    }
    
}