<?php

namespace App\Http\Controllers\planner;

use Carbon\Carbon;
use App\Models\planner\Mps2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\produksi\DryCastResin;
use App\Models\planner\KapasitasProduksi;

class Mps2Controller extends Controller
{
    public function index(){
        $startDate = Carbon::create(2024, 3, 1); // Tanggal awal yang Anda inginkan
        $endDate = Carbon::create(2024, 4, 30); // Tanggal akhir yang Anda inginkan
        // Ambil nama bulan dari tanggal startdate atau enddate
        $monthName = ucfirst($startDate->translatedFormat('F')); // Ambil nama bulan dari startdate
        $monthName2 = ucfirst($endDate->translatedFormat('F')); // Ambil nama bulan dari startdate
        $kapasitasPL2 = KapasitasProduksi::whereBetween('tanggal', [$startDate, $endDate])
                                          ->pluck('pl2', 'tanggal')
                                          ->toArray();
        $kapasitasPL3 = KapasitasProduksi::whereBetween('tanggal', [$startDate, $endDate])
                                          ->pluck('pl3', 'tanggal')
                                          ->toArray();
        $kapasitasDrytype = KapasitasProduksi::whereBetween('tanggal', [$startDate, $endDate])
                                          ->pluck('drytype', 'tanggal')
                                          ->toArray();
        // Ubah format tanggal menjadi hanya tanggal (day)
        $tanggalHeaders = KapasitasProduksi::whereBetween('tanggal', [$startDate, $endDate])
                                          ->pluck('tanggal')
                                          ->toArray();

        $mps2s = Mps2::all();
        
        return view('planner.MPS2.gantt', compact('kapasitasPL2', 'kapasitasPL3', 'kapasitasDrytype', 'tanggalHeaders', 'mps2s', 'monthName', 'monthName2'));
    }  

    public function store(Request $request){
        // Mendapatkan nilai id_wo dari formulir
        $id_wo = $request->input('id_wo');

        // Membuat format id_so dari id_wo
        $id_so = preg_replace('/(\D)(\d{1})(\d{2})(\d+)/', 'S$2/$3/$4', $id_wo);
        
        // Mencari nilai manhour_code dari tabel dry_cast_resin berdasarkan id_so dan kva
        $manhour_code = DryCastResin::where('nomor_so', $id_so)
                                      ->where('ukuran_kapasitas', $request->input('kva'))
                                      ->value('kd_manhour');
        
        $mps2 = new Mps2();
        $mps2->id_wo = $id_wo;
        $mps2->id_so = $id_so;
        $mps2->line = $request->get('line');
        $mps2->project = $request->get('project');
        $mps2->deadline = $request->get('deadline');
        $mps2->kva = $request->get('kva');
        $mps2->qty_trafo = $request->get('qty_trafo');
        $mps2->kd_manhour = $manhour_code;

        $mps2->save();
        
        // Validasi input untuk memastikan tidak ada input yang kosong
        $request->validate([
            'id_wo' => 'required', // Pastikan work_order tidak kosong
        ]);
    
        // Ambil semua input yang dikirimkan dari formulir
        $inputs = $request->all();

        // Inisialisasi array untuk menyimpan data yang akan disimpan
        $mps2 = [];
        // dd($mps2);
    
        // Ambil tanggal dari header
        $tanggalHeaders = KapasitasProduksi::pluck('tanggal')->toArray();
        
        // Loop melalui input untuk menyimpan data ke dalam tabel mps2s
        foreach ($inputs as $key => $value) {
            // Periksa apakah kunci input berisi "jan_"
            if (strpos($key, 'jan_') !== false && $value !== null) {
                // Dapatkan hari dan bulan dari kunci input
                $dayMonth = substr($key, 4); // Menghapus "jan_" dari kunci input
                $day = substr($dayMonth, 0, 2); // Ambil 2 karakter pertama untuk hari
                $month = substr($dayMonth, 2); // Ambil sisa karakter untuk bulan
                
                // Buat tanggal dari hari dan bulan
                $tanggal = Carbon::createFromDate(null, $month, $day); // Tahun diabaikan untuk pembuatan objek Carbon
        
                // Simpan data ke dalam model Mps2
                Mps2::create([
                    'id_wo' => $inputs['id_wo'],
                    'line' => $inputs['line'], // Ambil nilai line dari input
                    'project' => $inputs['project'], // Ambil nilai project dari input
                    'kva' => $inputs['kva'], // Ambil nilai kva dari input
                    'qty_trafo' => $value, // Simpan nilai input sebagai qty_trafo
                    'deadline' => $tanggal, // Simpan tanggal sesuai dengan header sebagai deadline
                    'manhour_code' => $manhour_code, // Simpan nilai manhour_code yang sudah ditemukan
                ]);
            }
        }

        // Simpan semua data dalam satu operasi ke database
        Mps2::insert($mps2);
    
        // Redirect ke halaman yang sesuai dan beri pesan sukses
        return redirect()->route('mps2-index')->with('success', 'Data berhasil disimpan.');
    }
    
}