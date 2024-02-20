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



    function dryKebutuhan(Request $request)
    {
        $totalManPower = ManPower::count();
        $title1 = 'Dry - Kebutuhan';
        $PL = ProductionLine::all();
        $kapasitas = Kapasitas::all();

        $mps = Mps::where('production_line', 'Drytype')->get();
        $ukuran_kapasitas = Kapasitas::value('ukuran_kapasitas');


        $periode = $request->post('periodeDryKebutuhan', null);
        if ($periode === null || !in_array($periode, [1, 2, 3, 4])) {
            // Mengambil nilai dari local storage jika ada
            $storedValue = $request->session()->get('selectedPeriodeDryKebutuhan');
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

        $request->session()->put('selectedPeriodeDryKebutuhan', $periode);

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

        session(['ketersediaanMPCoil_Making_LV' => $ketersediaanMPCoil_Making_LV]);
        session(['ketersediaanMPCoil_Making_HV' => $ketersediaanMPCoil_Making_HV]);
        session(['ketersediaanMPMould_Casting' => $ketersediaanMPMould_Casting]);
        session(['ketersediaanMPCore_Assembly' => $ketersediaanMPCore_Assembly]);

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
    public function dryRekomendasi(Request $request)
    {
        $title1 = 'Dry - Rekomendasi';

        $selectedWorkcenter_rekomendasi = $request->input('Workcenter_rekomendasi', null);
        $selectedPeriode = $request->input('periodeDry', null);
        $selectedShift = $request->input('shiftDry', null);

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

        if ($selectedShift === null || !in_array($selectedShift, [1, 2, 3])) {
            // Mengambil nilai dari local storage jika ada
            $storedShiftValue = $request->session()->get('selectedShiftDry');
            $selectedShift = ($storedShiftValue && in_array($storedShiftValue, [1, 2, 3, 4])) ? $storedShiftValue : 1;
        }
        switch ($selectedPeriode) {
            case 1:
                // Hari Ini
                $startOfDay = now()->startOfDay();
                $endOfDay = now()->endOfDay();
                while ($startOfDay->isWeekend()) {
                    $startOfDay->addDay();
                }
                while ($endOfDay->isWeekend()) {
                    $endOfDay->addDay();
                }
                $getDay = [
                    $startOfDay,
                    $endOfDay,
                ];
                break;
            case 2:
                // Besok
                $startOfDay = now()->addDay()->startOfDay();
                $endOfDay = now()->addDay()->endOfDay();
                while ($startOfDay->isWeekend()) {
                    $startOfDay->addDay();
                }
                while ($endOfDay->isWeekend()) {
                    $endOfDay->addDay();
                }
                $getDay = [
                    $startOfDay,
                    $endOfDay,
                ];
                break;
            case 3:
                // Minggu Sekarang (hanya hari kerja)
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                while ($startOfWeek->isWeekend()) {
                    $startOfWeek->addDay();
                }
                while ($endOfWeek->isWeekend()) {
                    $endOfWeek->subDay();
                }
                $getDay = [
                    $startOfWeek->startOfDay(),
                    $endOfWeek->endOfDay(),
                ];
                break;
            case 4:
                // Minggu Depan (hanya hari kerja)
                $startOfWeek = now()->startOfWeek()->addWeek();
                $endOfWeek = now()->endOfWeek()->addWeek();
                while ($startOfWeek->isWeekend()) {
                    $startOfWeek->addDay();
                }
                while ($endOfWeek->isWeekend()) {
                    $endOfWeek->subDay();
                }
                $getDay = [
                    $startOfWeek->startOfDay(),
                    $endOfWeek->endOfDay(),
                ];
                break;
        }



        $gpadry = GPADry::where('production_line', 'Drytype');

        $gpadryfilterLV = clone $gpadry;
        $gpadryfilterLV = $gpadryfilterLV->where('nama_workcenter', 'LV Windling')
            ->whereBetween('deadline', $getDay)
            ->get();
        $gpadryfilterHV = clone $gpadry;
        $gpadryfilterHV = $gpadryfilterHV->where('nama_workcenter', 'HV Windling')
            ->whereBetween('deadline', $getDay)
            ->get();

        $gpadryfilterMoulding = clone $gpadry;
        $gpadryfilterMoulding = $gpadryfilterMoulding->where('nama_workcenter', 'Moulding')
            ->whereBetween('deadline', $getDay)
            ->get();

        $gpadryfilterCCASusun = clone $gpadry;
        $gpadryfilterCCASusun = $gpadryfilterCCASusun->where('nama_workcenter', 'Susun Core')
            ->whereBetween('deadline', $getDay)
            ->get();

        $gpadryfilterCCAFinishing = clone $gpadry;
        $gpadryfilterCCAFinishing = $gpadryfilterCCAFinishing->where('nama_workcenter', 'Finishing')
            ->whereBetween('deadline', $getDay)
            ->get();


        $gpadryfilterCCAConect = clone $gpadry;
        $gpadryfilterCCAConect = $gpadryfilterCCAConect->where('nama_workcenter', 'Connection & Final Assembly')
            ->whereBetween('deadline', $getDay)
            ->get();


        // $gpadryfilterQC = clone $gpadry;
        // $gpadryfilterQC = $gpadryfilterQC->where('nama_workcenter', 'Quality Control')
        //     ->whereBetween('deadline', $getDay)
        //     ->get();

        // $gpadryfilterLV = clone $gpadry;
        // if ($getDay !== null) {
        //     $gpadryfilterLV = $gpadryfilterLV->where('nama_workcenter', 'LV Windling')
        //         ->whereBetween('deadline', $getDay)
        //         ->get();
        // } else {
        //     $gpadryfilterLV = collect();
        // }

        // Filter kedua untuk nama_workcenter 'HV Windling'
        // $gpadryfilterHV = clone $gpadry;
        // if ($getDay !== null) {
        //     $gpadryfilterHV = $gpadryfilterHV->where('nama_workcenter', 'HV Windling')
        //         ->whereBetween('deadline', $getDay)
        //         ->get();
        // } else {
        //     $gpadryfilterHV = collect();
        // }

        $manpower = MatriksSkill::all();

        switch ($selectedShift) {
            case 1:
                $shift = 8;
                break;
            case 2:
                $shift = 16;
                break;
            case 3:
                $shift = 24;
                break;
        }

        switch ($selectedWorkcenter_rekomendasi) {
            case 1:
                $workcenterLabel = 'Coil Making LV';
                $woDry = $gpadryfilterLV;
                $coilLv = $gpadryfilterLV->pluck('wo.standardize_work.dry_cast_resin.coil_lv');
                $namaMP = [];
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'DRY')
                        ->where('nama_workcenter', 'COIL MAKING LV')
                        ->where('proses', 'COIL LV')
                        ->whereIn('tipe_proses', $coilLv)
                        ->where('skill', $i)
                        ->pluck('nama_mp')->toArray();
                    if (!empty($namaMP_currentSkill)) {
                        $namaMP = array_merge($namaMP, $namaMP_currentSkill);
                    }
                    if (count($namaMP) >= ceil(session('ketersediaanMPCoil_Making_LV'))) {
                        break;
                    }
                }
                $jumlahNamaMP = ceil(session('ketersediaanMPCoil_Making_LV'));
                $namaMP = array_slice($namaMP, 0, $jumlahNamaMP);
                break;
            case 2:
                $workcenterLabel = 'Coil Making HV';
                $woDry = $gpadryfilterHV;
                // $woDryDeadline = $woDry->pluck('deadline')->toArray();
                $coilHv = $gpadryfilterHV->pluck('wo.standardize_work.dry_cast_resin.coil_hv');
                $hourcoilHv = $gpadryfilterHV->pluck('wo.standardize_work.dry_cast_resin.hour_coil_hv');
                $namaMP_coil_hv = [];
                foreach ($hourcoilHv as $hour) {
                    $count = intval($hour / $shift);
                    if ($count > 0) {
                        $namaMPs = $manpower->where('production_line', 'DRY')
                            ->where('nama_workcenter', 'COIL MAKING HV')
                            ->where('proses', 'COIL HV')
                            ->whereIn('tipe_proses', $coilHv)
                            ->where('skill', 4)
                            ->pluck('nama_mp')
                            ->toArray();
                        $namaMPs = array_unique($namaMPs);
                        $selectedMPs = array_slice($namaMPs, 0, $count);

                        $namaMP = array_merge($namaMP_coil_hv, $selectedMPs);

                    }
                }
                break;
            case 3:
                $workcenterLabel = 'Mould & Casting';
                $woDry = $gpadryfilterMoulding;
                $hvmoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_moulding');
                // hv moulding
                $namaMP_hvmoulding = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'MOULD & CASTING')
                    ->where('proses', 'HV MOULDING')
                    ->whereIn('tipe_proses', $hvmoulding)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();
                // hv casting
                $hvcasting = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_casting');
                $namaMP_lvmoulding = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'MOULD & CASTING')
                    ->where('proses', 'HV CASTING')
                    ->whereIn('tipe_proses', $hvcasting)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();

                $hvdemoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_demoulding');
                $namaMP_hvdemoulding = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'MOULD & CASTING')
                    ->where('proses', 'HV DEMOULDING')
                    ->whereIn('tipe_proses', $hvdemoulding)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();

                $lvbobbin = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.lv_bobbin');
                $namaMP_lvbobbin = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'MOULD & CASTING')
                    ->where('proses', 'LV BOBBIN')
                    ->whereIn('tipe_proses', $lvbobbin)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();

                $touch_up = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.touch_up');
                $namaMP_touch_up = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'MOULD & CASTING')
                    ->where('proses', 'TOUCH UP')
                    ->whereIn('tipe_proses', $touch_up)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();

                $lv_mouldingArray = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.lv_moulding');
                $namaMP_lv_moulding = [];
                foreach ($lv_mouldingArray as $lv_moulding) {
                    $isolasiValues = explode(',', $lv_moulding);
                    foreach ($isolasiValues as $lv_moulding) {
                        $namaMP_lv_moulding = array_merge($namaMP_lv_moulding, $manpower->where('production_line', 'DRY')
                            ->where('nama_workcenter', 'MOULD & CASTING')
                            ->where('proses', 'LV MOULDING')
                            ->where('tipe_proses', $lv_moulding)
                            ->where('skill', 4)
                            ->pluck('nama_mp')->toArray());
                    }
                }

                $namaMP = array_merge($namaMP_hvmoulding, $namaMP_lvmoulding, $namaMP_hvdemoulding, $namaMP_lvbobbin, $namaMP_lv_moulding, $namaMP_touch_up);
                $namaMP = array_unique($namaMP);
                break;
            case 4:
                $workcenterLabel = 'Core Coil Assembly';
                $woDryCCASusun = $gpadryfilterCCASusun;
                $woDryCCAFinishing = $gpadryfilterCCAFinishing;
                $woDryCCAConect = $gpadryfilterCCAConect;

                $woDry = $woDryCCASusun->union($woDryCCAFinishing)->union($woDryCCAConect);


                $susun_core = $gpadryfilterCCASusun->pluck('wo.standardize_work.dry_cast_resin.type_susun_core');
                $namaMP_susun_core = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'CORE & ASSEMBLY')
                    ->where('proses', 'TYPE SUSUN CORE')
                    ->whereIn('tipe_proses', $susun_core)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();

                $potong_isolasi_fiberArray = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.potong_isolasi_fiber');
                $namaMP_potong_isolasi_fiber = [];
                foreach ($potong_isolasi_fiberArray as $potong_isolasi_fiber) {
                    $isolasiValues = explode(',', $potong_isolasi_fiber);
                    foreach ($isolasiValues as $potong_isolasi_fiber) {
                        $namaMP_potong_isolasi_fiber = array_merge($namaMP_potong_isolasi_fiber, $manpower->where('production_line', 'DRY')
                            ->where('nama_workcenter', 'CORE & ASSEMBLY')
                            ->where('proses', 'POTONG ISOLASI FIBER')
                            ->whereIn('tipe_proses', $potong_isolasi_fiber)
                            ->where('skill', 4)
                            ->pluck('nama_mp')->toArray());
                    }
                }

                $wiring = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.wiring');
                $namaMP_wiring = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'CORE & ASSEMBLY')
                    ->where('proses', 'WIRING')
                    ->whereIn('tipe_proses', $wiring)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();

                $instal_housing = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.instal_housing');
                $namaMP_instal_housing = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'CORE & ASSEMBLY')
                    ->where('proses', 'INSTAL HOUSING')
                    ->whereIn('tipe_proses', $instal_housing)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();

                $bongkar_housing = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.bongkar_housing');
                $namaMP_bongkar_housing = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'CORE & ASSEMBLY')
                    ->where('proses', 'BONGKAR HOUSING')
                    ->whereIn('tipe_proses', $bongkar_housing)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();

                $pembuatan_cu_link = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.pembuatan_cu_link');
                $namaMP_pembuatan_cu_link = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'CORE & ASSEMBLY')
                    ->where('proses', 'PEMBUATAN CU LINK')
                    ->whereIn('tipe_proses', $pembuatan_cu_link)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();

                $pembuatan_cu_link = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.pembuatan_cu_link');
                $namaMP_pembuatan_cu_link = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'CORE & ASSEMBLY')
                    ->where('proses', 'PEMBUATAN CU LINK')
                    ->whereIn('tipe_proses', $pembuatan_cu_link)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();

                $accesories = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.accesories');
                $namaMP_accesories = $manpower->where('production_line', 'DRY')
                    ->where('nama_workcenter', 'CORE & ASSEMBLY')
                    ->where('proses', 'ACCESORIES')
                    ->whereIn('tipe_proses', $accesories)
                    ->where('skill', 4)
                    ->pluck('nama_mp')->toArray();

                $othersArray = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.others');
                $namaMP_others = [];
                foreach ($othersArray as $others) {
                    $isolasiValues = explode(',', $others);
                    foreach ($isolasiValues as $others) {
                        $namaMP_others = array_merge($namaMP_others, $manpower->where('production_line', 'DRY')
                            ->where('nama_workcenter', 'CORE & ASSEMBLY')
                            ->where('proses', 'OTHERS')
                            ->whereIn('tipe_proses', $others)
                            ->where('skill', 4)
                            ->pluck('nama_mp')->toArray());
                    }
                }


                $namaMP = array_merge($namaMP_wiring, $namaMP_potong_isolasi_fiber, $namaMP_susun_core, $namaMP_instal_housing, $namaMP_bongkar_housing, $namaMP_pembuatan_cu_link, $namaMP_accesories, $namaMP_others);
                $namaMP = array_unique($namaMP);
                break;
        }


        $request->session()->put('selectedWorkcenter_rekomendasi', $selectedWorkcenter_rekomendasi);
        $request->session()->put('selectedPeriodeDry', $selectedPeriode);
        $request->session()->put('selectedShiftDry', $selectedShift);



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
}
