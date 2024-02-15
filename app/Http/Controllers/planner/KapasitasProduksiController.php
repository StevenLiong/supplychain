<?php

namespace App\Http\Controllers\planner;

use App\Models\planner\Hitung_kapasitas;
use App\Models\planner\KapasitasProduksi as PlannerKapasitasProduksi;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Ramsey\Uuid\Type\Integer;
use Carbon\Carbon;

class KapasitasProduksiController extends Controller
{
    public function index(Request $request)
    {
        // $dataKapasitas = PlannerKapasitasProduksi::all();
        // $dataPerhitungan = Hitung_kapasitas::all();
        $currentDate = Carbon::now(); // Mendapatkan tanggal saat ini
        $currentYear = date('Y'); // Mendapatkan tahun saat ini
        // dd($currentDate);
        $periode = $request->post('periode', null);
        // dd($periode);
        if ($periode === null || !in_array($periode, [1, 2, 3, 4])) {
            // Mengambil nilai dari local storage jika ada
            $storedValue = $request->session()->get('selectedPeriode');
            $periode = ($storedValue && in_array($storedValue, [1, 2, 3, 4, 5,6,7,8,9,10,11,12])) ? $storedValue : 1;
        }

        switch ($periode) {
            case 1:
                    $startOfMonth = date("$currentYear-01-01"); // Tanggal awal bulan Januari
                    $endOfMonth = date("$currentYear-01-31"); // Tanggal akhir bulan Januari
                    // dd($startOfMonth, $endOfMonth);
                break;
            case 2:
                    $startOfMonth = date("$currentYear-02-01"); // Tanggal awal bulan Februari
                    $endOfMonth = date("$currentYear-02-28"); // Tanggal akhir bulan Februari
                break;
            case 3:
                    $startOfMonth = date("$currentYear-03-01");
                    $endOfMonth = date("$currentYear-03-31");
                break;
            case 4:
                    $startOfMonth = date("$currentYear-04-01");
                    $endOfMonth = date("$currentYear-04-31");
                break;
            case 5:
                    $startOfMonth = date("$currentYear-05-01");
                    $endOfMonth = date("$currentYear-05-31");
                break;
            case 6:
                    $startOfMonth = date("$currentYear-06-01");
                    $endOfMonth = date("$currentYear-06-31");
                break;
            case 7:
                    $startOfMonth = date("$currentYear-07-01");
                    $endOfMonth = date("$currentYear-07-31");
                break;
            case 8:
                    $startOfMonth = date("$currentYear-08-01");
                    $endOfMonth = date("$currentYear-08-31");
                break;
            case 9:
                    $startOfMonth = date("$currentYear-09-01");
                    $endOfMonth = date("$currentYear-09-31");
                break;
            case 10:
                    $startOfMonth = date("$currentYear-10-01");
                    $endOfMonth = date("$currentYear-10-31");
                break;
            case 11:
                    $startOfMonth = date("$currentYear-11-01");
                    $endOfMonth = date("$currentYear-11-31");
                break;
            case 12:
                    $startOfMonth = date("$currentYear-12-01");
                    $endOfMonth = date("$currentYear-12-31");
                break;
        }
        // dd($periode);
        $request->session()->put('selectedPeriode', $periode);

        $dataKapasitas = PlannerKapasitasProduksi::whereBetween('tanggal', [$startOfMonth, $endOfMonth])->get();

        return view('planner.kapasitas_produksi.index', compact('dataKapasitas'));
    }

    public function detailKapasitas(String $nama_pl): View
    {
        $dataKapasitas = PlannerKapasitasProduksi::where('nama_pl', $nama_pl)->first();

        return view('planner.kapasitas_produksi.detailPl', compact('dataWorkcenter','dataGpa'));
    }

    public function editData(String $id): View
    {
        $dataKp = PlannerKapasitasProduksi::where('id', $id)
        ->first();

        return view('planner.kapasitas_produksi.editPl', compact('dataKp'));
    }

    // public function updateData(Request $request, $id)
    // {
    //     try {
    //         $this->validate($request, [
    //             'kap_produksi_drytype' => 'required|integer',
    //             'kap_produksi_pl2' => 'required|integer',
    //             'kap_produksi_pl3' => 'required|integer',
    //         ]);

    //         $kapProduksiDrytype = $request->kap_produksi_drytype;
    //         dd($kapProduksiDrytype);
    //         $kapProduksiPl2 = $request->kap_produksi_pl2;
    //         $kapProduksiPl3 = $request->kap_produksi_pl3;

    //         $editKp = PlannerKapasitasProduksi::findOrFail($id);

    //         $editKp->update([
    //             'drytype' => $kapProduksiDrytype,
    //             'pl2' => $kapProduksiPl2,
    //             'pl3' => $kapProduksiPl3,
    //         ]);

    //         return redirect()->route('kp-index')->with('success', 'Data Kapasitas Produksi berhasil diperbarui');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }

    public function updateData(Request $request, $id){
        $this->validate($request, [
            //DryType Inputan
            'oee_drytype' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'output_drytype' => 'required|integer',
            'shift_kerja_drytype' => 'required|integer',
            'jam_kerja_drytype' => 'required|integer',

            //PL1 & PL2 Inputan
            'oee_pl2' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'output_pl2' => 'required|integer',
            'shift_kerja_pl2' => 'required|integer',
            'jam_kerja_pl2' => 'required|integer',

            //PL3 Inputan
            'oee_pl3' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'output_pl3' => 'required|integer',
            'shift_kerja_pl3' => 'required|integer',
            'jam_kerja_pl3' => 'required|integer',
        ]);

        //=================================DRYTYPE=======================================

        // Mendapatkan input dari request
        $oeeDryType = $request->input('oee_drytype');
        $outputDryType = $request->input('output_drytype');
        $shiftDryType = $request->input('shift_kerja_drytype');
        $jamDryType = $request->input('jam_kerja_drytype');
        $aktualOeeDryType = $request->input('aktual_oee_drytype');

        // Perhitungan untuk Dry Type
        $taktTimeDryType = $jamDryType / $outputDryType;
        $availableWorkTimeDryType = ($jamDryType * $shiftDryType) * $oeeDryType;
        $kapProduksiDryType = ceil($availableWorkTimeDryType / $taktTimeDryType);

        //=================================PL1 & PL2=======================================

        // Perhitungan untuk PL1 & PL2
        $oeePL2 = $request->input('oee_pl2');
        $outputPL2 = $request->input('output_pl2');
        $shiftPL2 = $request->input('shift_kerja_pl2');
        $jamPL2 = $request->input('jam_kerja_pl2');
        $aktualOeePL2 = $request->input('aktual_oee_pl2');

        $taktTimePL2 = $jamPL2 / $outputPL2;
        $availableWorkTimePL2 = ($jamPL2 * $shiftPL2) * $oeePL2;
        $kapProduksiPL2 = ceil($availableWorkTimePL2 / $taktTimePL2);

        //=================================PL3=======================================

        // Perhitungan untuk PL3
        $oeePL3 = $request->input('oee_pl3');
        $outputPL3 = $request->input('output_pl3');
        $shiftPL3 = $request->input('shift_kerja_pl3');
        $jamPL3 = $request->input('jam_kerja_pl3');
        $aktualOeePL3 = $request->input('aktual_oee_pl3');

        $taktTimePL3 = $jamPL3 / $outputPL3;
        $availableWorkTimePL3 = ($jamPL3 * $shiftPL3) * $oeePL3;
        $kapProduksiPL3 = ceil($availableWorkTimePL3 / $taktTimePL3);

        // dd($kapProduksiDryType, $kapProduksiPL2, $kapProduksiPL3);
    
        $editKp = PlannerKapasitasProduksi::findOrFail($id);
    
        $editKp->update([
            //DryType Update
            'oee_drytype' => $request->oee_drytype,
            'output_drytype' => $request->output_drytype,
            'shift_kerja_drytype' => $request->shift_kerja_drytype,
            'jam_kerja_drytype' => $request->jam_kerja_drytype,
            'drytype' => $kapProduksiDryType,

            //PL1 & PL2 Update
            'oee_pl2' => $request->oee_pl2,
            'output_pl2' => $request->output_pl2,
            'shift_kerja_pl2' => $request->shift_kerja_pl2,
            'jam_kerja_pl2' => $request->jam_kerja_pl2,
            'pl2' => $kapProduksiPL2,

            //PL3 Update
            'oee_pl3' => $request->oee_pl3,
            'output_pl3' => $request->output_pl3,
            'shift_kerja_pl3' => $request->shift_kerja_pl3,
            'jam_kerja_pl3' => $request->jam_kerja_pl3,
            'pl3' => $kapProduksiPL3,
        ]);
    
        return redirect()->route('kp-index');
    }

    
}
