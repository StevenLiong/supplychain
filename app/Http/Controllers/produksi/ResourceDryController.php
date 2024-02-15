<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Models\planner\GPADry;
use App\Models\planner\Mps;
use App\Models\produksi\DryCastResin;
use App\Models\produksi\Kapasitas;
use App\Models\produksi\ManPower;
use App\Models\produksi\MatriksSkill;
use App\Models\produksi\ProductionLine;
use Illuminate\Http\Request;

class ResourceDryController extends Controller
{
    public function dryRekomendasi(Request $request)
    {
        $title1 = 'Dry - Rekomendasi';

        $selectedWorkcenter_rekomendasi = $request->input('Workcenter_rekomendasi', null);
        $selectedPeriode = $request->input('periodeDry', null);

        // Memeriksa nilai Workcenter yang dipilih
        if ($selectedWorkcenter_rekomendasi === null || !in_array($selectedWorkcenter_rekomendasi, [1, 2, 3, 4])) {
            // Mengambil nilai dari local storage jika ada
            $storedValue = $request->session()->get('selectedWorkcenter_rekomendasi');
            $selectedWorkcenter_rekomendasi = ($storedValue && in_array($storedValue, [1, 2, 3, 4])) ? $storedValue : 1;
        }

        // Memeriksa nilai Periode yang dipilih
        if ($selectedPeriode === null || !in_array($selectedPeriode, [1, 2, 3, 4])) {
            // Mengambil nilai dari local storage jika ada
            $storedPeriodeValue = $request->session()->get('selectedPeriodeDry');
            $selectedPeriode = ($storedPeriodeValue && in_array($storedPeriodeValue, [1, 2, 3, 4])) ? $storedPeriodeValue : 1;
        }

        // Logika untuk menentukan label berdasarkan workcenter yang dipilih

        switch ($selectedPeriode) {
            case 1:
                // Hari Ini
                $getDay = [
                    now()->startOfDay(),
                    now()->endOfDay(),
                ];
                break;
            case 2:
                // Besok
                $getDay = [
                    now()->startOfDay()->addDay(),
                    now()->endOfDay()->addDay(),
                ];
                break;
            case 3:
                // Minggu Sekarang
                $getDay = [
                    now()->startOfWeek()->addDay(),
                    now()->startOfWeek()->addDay(6)->endOfDay(),
                ];
                break;
            case 4:
                // Minggu Depan
                $getDay = [
                    now()->startOfWeek()->addWeek()->addDay(),
                    now()->endOfWeek()->addWeek()->addDay(5),
                ];
                break;
        }

        $gpadry = GPADry::where('production_line', 'Drytype');

        // Filter pertama untuk nama_workcenter 'LV Windling'
        $gpadryfilterLV = clone $gpadry;
        if ($getDay !== null) {
            $gpadryfilterLV = $gpadryfilterLV->where('nama_workcenter', 'LV Windling')
                ->whereBetween('deadline', $getDay)
                ->get();
        } else {
            $gpadryfilterLV = collect(); // Menghasilkan koleksi kosong jika $getDay adalah null
        }

        // Filter kedua untuk nama_workcenter 'HV Windling'
        $gpadryfilterHV = clone $gpadry;
        if ($getDay !== null) {
            $gpadryfilterHV = $gpadryfilterHV->where('nama_workcenter', 'HV Windling')
                ->whereBetween('deadline', $getDay)
                ->get();
        } else {
            $gpadryfilterHV = collect(); // Menghasilkan koleksi kosong jika $getDay adalah null
        }


        $manpower = MatriksSkill::all();


        switch ($selectedWorkcenter_rekomendasi) {
            case 1:
                $workcenterLabel = 'Coil Making LV';
                $woDry = $gpadryfilterLV->pluck('wo.id_wo');

                // Manpower untuk potong leadwire
                $coilLv = $gpadryfilterLV->pluck('wo.standardize_work.dry_cast_resin.coil_lv');
                $namaMP_coil_lv = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'COIL MAKING LV')
                    ->where('proses', 'COIL LV')
                    ->whereIn('tipe_proses', $coilLv)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();

                // Manpower untuk potong leadwire
                // $potongLeadWire = $gpadryfilterLV->pluck('wo.standardize_work.dry_cast_resin.potong_leadwire');
                // $namaMP_leadwire = $manpower->where('production_line', 'DRY')
                //     ->where('nama_workcenter', 'COIL MAKING LV')
                //     ->where('proses', 'POTONG LEAD WIRE')
                //     ->whereIn('tipe_proses', $potongLeadWire)
                //     ->where('skill', 4)
                //     ->pluck('nama_mp')->toArray();

                // Manpower untuk potong isolasi
                // $potongIsolasiArray = $gpadryfilterLV->pluck('wo.standardize_work.dry_cast_resin.potong_isolasi');
                // $namaMP_potongIsolasi = [];
                // foreach ($potongIsolasiArray as $potongIsolasi) {
                //     $isolasiValues = explode(',', $potongIsolasi);
                //     foreach ($isolasiValues as $isolasi) {
                //         $namaMP_potongIsolasi = array_merge($namaMP_potongIsolasi, $manpower->where('production_line', 'DRY')
                //             ->where('nama_workcenter', 'COIL MAKING LV')
                //             ->where('proses', 'POTONG ISOLASI')
                //             ->where('tipe_proses', $isolasi)
                //             ->where('skill', 4)
                //             ->pluck('nama_mp')->toArray());
                //     }
                // }
                // $namaMP_potongIsolasi = array_unique($namaMP_potongIsolasi);

                // $namaMP = array_merge($namaMP_coil_lv, $namaMP_potongIsolasi, namaMP_leadwire);
                $namaMP = array_merge($namaMP_coil_lv);
                $namaMP = array_unique($namaMP);
                break;
            case 2:
                $workcenterLabel = 'Coil Making HV';
                $woDry = $gpadryfilterHV->pluck('wo.id_wo');
                // Manpower untuk coil hv
                $coilHv = $gpadryfilterHV->pluck('wo.standardize_work.dry_cast_resin.coil_hv');
                $namaMP_coil_hv = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'COIL MAKING HV')
                    ->where('proses', 'COIL HV')
                    ->whereIn('tipe_proses', $coilHv)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();

                $namaMP = array_unique($namaMP_coil_hv);
                break;
            case 3:
                $workcenterLabel = 'Mould & Casting';
                $woDry = $gpadry->pluck('wo.id_wo');
                $coilLvs = $gpadry->pluck('wo.standardize_work.dry_cast_resin.coil_lv');
                $namaMP = $manpower->whereIn('tipe_proses', $coilLvs)
                    ->where('skill', 4)
                    ->pluck('nama_mp');
                break;
            case 4:
                $workcenterLabel = 'Core Coil Assembly';
                $woDry = $gpadry->pluck('wo.id_wo');
                $coilLvs = $gpadry->pluck('wo.standardize_work.dry_cast_resin.coil_lv');
                $namaMP = $manpower->whereIn('tipe_proses', $coilLvs)
                    ->where('skill', 4)
                    ->pluck('nama_mp');
                // dd($namaMP);
                break;
        }


        $request->session()->put('selectedWorkcenter_rekomendasi', $selectedWorkcenter_rekomendasi);
        $request->session()->put('selectedPeriodeDry', $selectedPeriode);



        $data = [
            'title1' => $title1,
            'workcenterLabel' => $workcenterLabel,
            'getDay' => $getDay,
            'gpadry' => $gpadry,
            'manpower' => $manpower,
            'woDry' => $woDry,
            'namaMP' => $namaMP,
        ];
        return view('produksi.resource_work_planning.DRY.rekomendasi', ['data' => $data]);
    }


    function dryKebutuhan(Request $request)
    {
        $totalManPower = ManPower::count();
        $title1 = 'Dry - Kebutuhan';
        $PL = ProductionLine::all();
        $kapasitas = Kapasitas::all();
        $mps = Mps::where('production_line', 'Drytype')->get();
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
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                $workData = $item->wo->standardize_work->dry_cast_resin ?? $item->wo->standardize_work->dry_non_resin;

                if ($workData) {
                    $totalHourCoil_making_HV = $workData->hour_coil_hv ?? 0;
                    return $totalHourCoil_making_HV * $item->qty_trafo;
                } else {
                    return 0;
                }
            });

        $jumlahtotalHourCoil_Making_LV = Mps::where('production_line', 'Drytype')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                $workData = $item->wo->standardize_work->dry_cast_resin ?? $item->wo->standardize_work->dry_non_resin;

                if ($workData) {
                    $hourCoilLV = $workData->hour_coil_lv ?? 0;
                    $hourPotongLeadwire = $workData->hour_potong_leadwire ?? 0;
                    $hourPotongIsolasi = $workData->hour_potong_isolasi ?? 0;
                    return ($hourCoilLV + $hourPotongLeadwire + $hourPotongIsolasi) * $item->qty_trafo;
                } else {
                    return 0;
                }
            });

        $jumlahtotalHourMould_Casting = Mps::where('production_line', 'Drytype')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                $workData = $item->wo->standardize_work->dry_cast_resin ?? $item->wo->standardize_work->dry_non_resin;

                if ($workData) {
                    // Ambil nilai totalHour_MouldCasting dan dikali qty
                    $totalHourMouldCasting = $workData->totalHour_MouldCasting ?? 0;

                    // Hitung total hour Mould Casting
                    return $totalHourMouldCasting * $item->qty_trafo;
                } else {
                    return 0;
                }
            });

        // dd($woDRY);
        $jumlahtotalHourCore_Assembly = Mps::where('production_line', 'Drytype')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDRY)
            ->get()
            ->sum(function ($item) {
                $workData = $item->wo->standardize_work->dry_cast_resin ?? $item->wo->standardize_work->dry_non_resin;

                if ($workData) {
                    $totalHourCoreCoilAssembly = $workData->totalHour_CoreCoilAssembly ?? 0;
                    return $totalHourCoreCoilAssembly * $item->qty_trafo;
                } else {
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
