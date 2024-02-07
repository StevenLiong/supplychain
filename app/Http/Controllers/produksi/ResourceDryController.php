<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Models\planner\Mps;
use App\Models\produksi\DryCastResin;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\ManPower;
use App\Models\produksi\MatriksSkill;
use App\Models\produksi\ProductionLine;
use Illuminate\Http\Request;
use Phpml\Classification\KNearestNeighbors;

class ResourceDryController extends Controller
{
    public function dryRekomendasi(Request $request)
    {
        $title1 = 'Dry - Rekomendasi';

        // Ambil data dari tabel matriks_skill
        $matrixSkills = MatriksSkill::all();
        $selectedWorkcenter_rekomendasi = $request->input('selectedWorkcenter_rekomendasi', 1);

        switch ($selectedWorkcenter_rekomendasi) {
            case 1:
                $workcenterLabel = 'Coil Making HV';
                $targetProses = 2; // Sesuaikan dengan proses yang diinginkan
                break;
            case 2:
                $workcenterLabel = 'Coil Making LV';
                $targetProses = 1; // Sesuaikan dengan proses yang diinginkan
                break;
            case 3:
                $workcenterLabel = 'Mould & Casting';
                // Sesuaikan dengan proses yang diinginkan untuk workcenter ini
                break;
            case 4:
                $workcenterLabel = 'Core Coil Assembly';
                // Sesuaikan dengan proses yang diinginkan untuk workcenter ini
                break;
        }

        // Siapkan data untuk PHP-ML
        $samples = [];
        $targets = [];

        foreach ($matrixSkills as $matrixSkill) {
            // Filter berdasarkan workcenter, kategori produk, dan proses yang diinginkan
            if (
                $matrixSkill->id_production_line == 5 &&
                $matrixSkill->id_kategori_produk == 4 &&
                $matrixSkill->id_proses == $targetProses
                // Sesuaikan dengan kondisi lainnya jika diperlukan
            ) {
                $samples[] = [
                    $matrixSkill->id_production_line,
                    $matrixSkill->id_kategori_produk,
                    $matrixSkill->id_proses,
                    $matrixSkill->id_tipe_proses
                ];
                $targets[] = $matrixSkill->skill;
            }
        }



        // Buat dan latih model Knn
        $model = new KNearestNeighbors();
        $model->train($samples, $targets);

        // Contoh ID manpower, Anda dapat menggantinya dengan ID yang sesuai dari request atau data lainnya
        $manpowerId = 5;

        // Ambil data manpower berdasarkan ID
        $manpower = ManPower::find($manpowerId);

        if (!$manpower) {
            return redirect()->route('home')->with('error', 'Manpower not found');
        }

        // Prediksi skill menggunakan model PHP-ML
        $predictedSkill = $model->predict([
            $manpower->id_production_line,
            $manpower->id_kategori_produk,
            $manpower->id_proses,
            $manpower->id_tipe_proses
        ]);

        // Mencari semua ID_MP yang sesuai dengan hasil prediksi
        $matchingManpowers = MatriksSkill::where('skill', '>=', $predictedSkill)->get();

        // Mendapatkan semua ID_MP dari hasil pencarian tanpa duplikasi
        $idMpsFromPrediction = $matchingManpowers->pluck('id_mp')->unique()->toArray();

        // Mendapatkan nama dari semua ID_MP yang sesuai dengan hasil prediksi tanpa duplikasi
        $manpowerNames = ManPower::whereIn('id', $idMpsFromPrediction)->pluck('nama')->toArray();

        $data = [
            'title1' => $title1,
            'workcenterLabel' => $workcenterLabel,
            'manpowerNames' => $manpowerNames,
        ];


        // Tampilkan atau lakukan apa pun yang Anda inginkan dengan $data
        return view('produksi.resource_work_planning.DRY.rekomendasi', ['data' => $data]);
    }


    function dryKebutuhan(Request $request)
    {
        $totalManPower = ManPower::count();
        $title1 = 'Dry - Kebutuhan';
        $PL = ProductionLine::all();
        $kapasitas = Kapasitas::all();
        $mps = Mps::where('production_line', 'Drytype')->get();
        // $drycastresin = DryCastResin::all();
        $ukuran_kapasitas = Kapasitas::value('ukuran_kapasitas');


        $periode = $request->post('periodeDry', null);
        if ($periode === null || !in_array($periode, [1, 2, 3, 4])) {
            // Mengambil nilai dari local storage jika ada
            $storedValue = $request->session()->get('selectedPeriodeDry');
            $periode = ($storedValue && in_array($storedValue, [1, 2, 3, 4])) ? $storedValue : 1;
        }
        switch ($periode) {
            case 1:
                $deadlineDate = [
                    now()->startOfMonth(),
                    now()->endOfMonth(),
                ];
                break;

            case 2:
                $deadlineDate = [
                    now()->startOfWeek(),
                    now()->endOfWeek(),
                ];
                break;

            case 3:
                $deadlineDate = [
                    now()->startOfWeek()->addWeek(),
                    now()->endOfWeek()->addWeek(),
                ];
                break;

            case 4:
                $deadlineDate = [
                    now()->addMonth()->startOfMonth(),
                    now()->addMonth()->endOfMonth(),
                ];
                break;
        }

        $request->session()->put('selectedPeriodeDry', $periode);

        //FILTER PL
        $filteredMpsDRY = $mps->where('production_line', 'Drytype');

        // //QTY PL
        $qtyDRY =  $filteredMpsDRY->whereBetween('deadline', $deadlineDate)->sum('qty_trafo');
        // dd($qtyDRY);
        $woDRY = Mps::where('production_line', 'Drytype')->pluck('id_wo');

        $jumlahtotalHourCoil_Making_HV = Mps::where('production_line', 'Drytype')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                // Ambil data berdasarkan jenisnya (dry_cast_resin atau dry_non_resin)
                $workData = $item->wo->standardize_work->dry_cast_resin ?? $item->wo->standardize_work->dry_non_resin;

                if ($workData) {
                    // Ambil nilai totalHour_CoreCoilAssembly dan dikali qty
                    $totalHourCoil_making_HV = $workData->hour_coil_hv ?? 0;

                    // Hitung total hour Core Coil Assembly
                    return $totalHourCoil_making_HV * $item->qty_trafo;
                } else {
                    // Handle jika tidak ada data yang sesuai
                    return 0;
                }
            });

        $jumlahtotalHourCoil_Making_LV = Mps::where('production_line', 'Drytype')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                // Ambil data berdasarkan jenisnya (dry_cast_resin atau dry_non_resin)
                $workData = $item->wo->standardize_work->dry_cast_resin ?? $item->wo->standardize_work->dry_non_resin;

                if ($workData) {
                    // Ambil nilai hour dan dikali qty
                    $hourCoilLV = $workData->hour_coil_lv ?? 0;
                    $hourPotongLeadwire = $workData->hour_potong_leadwire ?? 0;
                    $hourPotongIsolasi = $workData->hour_potong_isolasi ?? 0;

                    // Hitung total hour berdasarkan jenisnya
                    return ($hourCoilLV + $hourPotongLeadwire + $hourPotongIsolasi) * $item->qty_trafo;
                } else {
                    // Handle jika tidak ada data yang sesuai
                    return 0;
                }
            });

        $jumlahtotalHourMould_Casting = Mps::where('production_line', 'Drytype')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                // Ambil data berdasarkan jenisnya (dry_cast_resin atau dry_non_resin)
                $workData = $item->wo->standardize_work->dry_cast_resin ?? $item->wo->standardize_work->dry_non_resin;

                if ($workData) {
                    // Ambil nilai totalHour_MouldCasting dan dikali qty
                    $totalHourMouldCasting = $workData->totalHour_MouldCasting ?? 0;

                    // Hitung total hour Mould Casting
                    return $totalHourMouldCasting * $item->qty_trafo;
                } else {
                    // Handle jika tidak ada data yang sesuai
                    return 0;
                }
            });

        // dd($woDRY);
        $jumlahtotalHourCore_Assembly = Mps::where('production_line', 'Drytype')
            // ->where('kva', $ukuran_kapasitas)
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                // Ambil data berdasarkan jenisnya (dry_cast_resin atau dry_non_resin)
                $workData = $item->wo->standardize_work->dry_cast_resin ?? $item->wo->standardize_work->dry_non_resin;

                if ($workData) {
                    // Ambil nilai totalHour_CoreCoilAssembly dan dikali qty
                    $totalHourCoreCoilAssembly = $workData->totalHour_CoreCoilAssembly ?? 0;

                    // Hitung total hour Core Coil Assembly
                    return $totalHourCoreCoilAssembly * $item->qty_trafo;
                } else {
                    // Handle jika tidak ada data yang sesuai
                    return 0;
                }
            });
        // dd($jumlahtotalHourCore_Assembly);


        switch ($periode) {
            case 1:
                $kebutuhanMPCoil_Making_HV = $jumlahtotalHourCoil_Making_HV / (173  * 0.93);
                $kebutuhanMPCoil_Making_LV = $jumlahtotalHourCoil_Making_LV / (173  * 0.93);
                $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (173  * 0.93);
                $kebutuhanMPCore_Assembly = $jumlahtotalHourCore_Assembly / (173  * 0.93);
                break;
            case 2:
                $kebutuhanMPCoil_Making_HV = $jumlahtotalHourCoil_Making_HV / (40  * 0.93);
                $kebutuhanMPCoil_Making_LV = $jumlahtotalHourCoil_Making_LV / (40  * 0.93);
                $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (40  * 0.93);
                $kebutuhanMPCore_Assembly = $jumlahtotalHourCore_Assembly / (40  * 0.93);
                break;
            case 3:
                $kebutuhanMPCoil_Making_HV = $jumlahtotalHourCoil_Making_HV / (40  * 0.93);
                $kebutuhanMPCoil_Making_LV = $jumlahtotalHourCoil_Making_LV / (40  * 0.93);
                $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (40  * 0.93);
                $kebutuhanMPCore_Assembly = $jumlahtotalHourCore_Assembly / (40  * 0.93);
                break;
            case 4:
                $kebutuhanMPCoil_Making_HV = $jumlahtotalHourCoil_Making_HV / (173  * 0.93);
                $kebutuhanMPCoil_Making_LV = $jumlahtotalHourCoil_Making_LV / (173  * 0.93);
                $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (173  * 0.93);
                $kebutuhanMPCore_Assembly = $jumlahtotalHourCore_Assembly / (173  * 0.93);
                break;
        }



        $selisihMPCoil_Making_HV = $kebutuhanMPCoil_Making_HV - $totalManPower;
        $selisihMPCoil_Making_LV = $kebutuhanMPCoil_Making_LV - $totalManPower;
        $selisihMPMould_Casting = $kebutuhanMPMould_Casting - $totalManPower;
        $selisihMPCore_Assembly = $kebutuhanMPCore_Assembly - $totalManPower;

        if ($kebutuhanMPCoil_Making_HV != 0) {
            $presentaseKurangMPCoil_Making_HV = ($selisihMPCoil_Making_HV / $kebutuhanMPCoil_Making_HV) * 100;
        } else {
            $presentaseKurangMPCoil_Making_HV = 0;
        }
        if ($kebutuhanMPCoil_Making_LV != 0) {
            $presentaseKurangMPCoil_Making_LV = ($selisihMPCoil_Making_LV / $kebutuhanMPCoil_Making_LV) * 100;
        } else {
            $presentaseKurangMPCoil_Making_LV = 0;
        }
        if ($kebutuhanMPMould_Casting != 0) {
            $presentaseKurangMPMould_Casting = ($selisihMPMould_Casting / $kebutuhanMPMould_Casting) * 100;
        } else {
            $presentaseKurangMPMould_Casting = 0;
        }
        if ($kebutuhanMPCore_Assembly != 0) {
            $presentaseKurangMPCore_Assembly = ($selisihMPCore_Assembly / $kebutuhanMPCore_Assembly) * 100;
        } else {
            $presentaseKurangMPCore_Assembly = 0;
        }

        $ketersediaanMPCoil_Making_HV = $kebutuhanMPCoil_Making_HV - ($kebutuhanMPCoil_Making_HV * $presentaseKurangMPCoil_Making_HV) / 100;
        $ketersediaanMPCoil_Making_LV = $kebutuhanMPCoil_Making_LV - ($kebutuhanMPCoil_Making_LV * $presentaseKurangMPCoil_Making_LV) / 100;
        $ketersediaanMPMould_Casting = $kebutuhanMPMould_Casting - ($kebutuhanMPMould_Casting * $presentaseKurangMPMould_Casting) / 100;
        $ketersediaanMPCore_Assembly = $kebutuhanMPCore_Assembly - ($kebutuhanMPCore_Assembly * $presentaseKurangMPCore_Assembly) / 100;

        if ($kebutuhanMPCoil_Making_HV <= $ketersediaanMPCoil_Making_HV) {
            $selisihMPCoil_Making_HV = 0;
            $ketersediaanMPCoil_Making_HV = $kebutuhanMPCoil_Making_HV;
        }
        if ($kebutuhanMPCoil_Making_LV <= $ketersediaanMPCoil_Making_LV) {
            $selisihMPCoil_Making_LV = 0;
            $ketersediaanMPCoil_Making_LV = $kebutuhanMPCoil_Making_LV;
        }
        if ($kebutuhanMPMould_Casting <= $ketersediaanMPMould_Casting) {
            $selisihMPMould_Casting = 0;
            $ketersediaanMPMould_Casting = $kebutuhanMPMould_Casting;
        }
        if ($kebutuhanMPCore_Assembly <= $ketersediaanMPCore_Assembly) {
            $selisihMPCore_Assembly = 0;
            $ketersediaanMPCore_Assembly = $kebutuhanMPCore_Assembly;
        }

        $wc_Coil_Making_HV =  'Coil Making HV';
        $wc_Coil_Making_LV =  'Coil Making LV';
        $wc_Mould_Casting =  'Mould & Casting';
        $wc_Core_Assembly =  'Core & Assembly';

        $data = [
            'jumlahtotalHourCoil_Making_LV' => $jumlahtotalHourCoil_Making_LV,
            'jumlahtotalHourCoil_Making_HV' => $jumlahtotalHourCoil_Making_HV,
            'jumlahtotalHourMould_Casting' => $jumlahtotalHourMould_Casting,
            'jumlahtotalHourCore_Assembly' => $jumlahtotalHourCore_Assembly,
            'selisihMPCoil_Making_HV' => $selisihMPCoil_Making_HV,
            'selisihMPCoil_Making_LV' => $selisihMPCoil_Making_LV,
            'selisihMPMould_Casting' => $selisihMPMould_Casting,
            'selisihMPCore_Assembly' => $selisihMPCore_Assembly,
            'totalManPower;' => $totalManPower,
            'kebutuhanMPCoil_Making_HV' => $kebutuhanMPCoil_Making_HV,
            'kebutuhanMPCoil_Making_LV' => $kebutuhanMPCoil_Making_LV,
            'kebutuhanMPMould_Casting' => $kebutuhanMPMould_Casting,
            'kebutuhanMPCore_Assembly' => $kebutuhanMPCore_Assembly,
            'wc_Coil_Making_HV' => $wc_Coil_Making_HV,
            'wc_Coil_Making_LV' => $wc_Coil_Making_LV,
            'wc_Mould_Casting' => $wc_Mould_Casting,
            'wc_Core_Assembly' => $wc_Core_Assembly,
            'ketersediaanMPCoil_Making_HV' => $ketersediaanMPCoil_Making_HV,
            'ketersediaanMPCoil_Making_LV' => $ketersediaanMPCoil_Making_LV,
            'ketersediaanMPMould_Casting' => $ketersediaanMPMould_Casting,
            'ketersediaanMPCore_Assembly' => $ketersediaanMPCore_Assembly,
            'title1' => $title1,
            'mps' => $mps,
            'kapasitas' => $kapasitas,
            'PL' => $PL,
            'deadlineDate' => $deadlineDate,
            // 'drycastresin' => $drycastresin,
        ];
        return view('produksi.resource_work_planning.DRY.kebutuhan', ['data' => $data]);
    }
}
