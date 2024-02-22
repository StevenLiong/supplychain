<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Models\planner\GPADry;
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
        $periode = $request->post('periodeDryKebutuhan', null);
        if ($periode === null || !in_array($periode, [1, 2, 3, 4])) {
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

        $gpadry = GPADry::where('production_line', 'Drytype');

        $gpadryfilterLV = clone $gpadry;
        $gpadryfilterHV = clone $gpadry;
        $gpadryfilterMoulding = clone $gpadry;
        $gpadryfilterCCASusun = clone $gpadry;
        $gpadryfilterCCAFinishing = clone $gpadry;
        $gpadryfilterCCAConect = clone $gpadry;


        $request->session()->put('selectedPeriodeDryKebutuhan', $periode);

        $woDryLV = $gpadryfilterLV->pluck('id_wo');
        $woDryHV = $gpadryfilterHV->pluck('id_wo');
        $woDryMould = $gpadryfilterMoulding->pluck('id_wo');
        $woDrySusun = $gpadryfilterCCASusun->pluck('id_wo');
        $woDryFinishing = $gpadryfilterCCAFinishing->pluck('id_wo');
        $woDryConect = $gpadryfilterCCAConect->pluck('id_wo');

        $jumlahtotalHourCoil_Making_HV =  $gpadryfilterHV->where('nama_workcenter', 'HV Windling')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDryHV)
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
        $jumlahtotalHourCoil_Making_LV = $gpadryfilterLV->where('nama_workcenter', 'LV Windling')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDryLV)
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

        $jumlahtotalHourMould_Casting = $gpadryfilterMoulding->where('nama_workcenter', 'Moulding')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDryMould)
            ->get()
            ->sum(function ($item) {
                $workData = $item->wo->standardize_work->dry_cast_resin ?? $item->wo->standardize_work->dry_non_resin;

                if ($workData) {
                    $totalHourMouldCasting = $workData->totalHour_MouldCasting ?? 0;
                    return $totalHourMouldCasting * $item->qty_trafo;
                } else {
                    return 0;
                }
            });
        $jumlahtotalHourCCASusun = $gpadryfilterCCASusun->where('nama_workcenter', 'Susun Core')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDrySusun)
            ->get()
            ->sum(function ($item) {
                $workData = $item->wo->standardize_work->dry_cast_resin ?? $item->wo->standardize_work->dry_non_resin;

                if ($workData) {
                    $hour_type_susun_core = $workData->hour_type_susun_core ?? 0;
                    return $hour_type_susun_core * $item->qty_trafo;
                } else {
                    return 0;
                }
            });

        $jumlahtotalHourCCAFinishing = $gpadryfilterCCAFinishing->where('nama_workcenter', 'Finishing')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDryFinishing)
            ->get()
            ->sum(function ($item) {
                $workData = $item->wo->standardize_work->dry_cast_resin ?? $item->wo->standardize_work->dry_non_resin;

                if ($workData) {
                    $hour_wiring = $workData->hour_wiring ?? 0;
                    $hour_instal_housing = $workData->hour_instal_housing ?? 0;
                    $hour_bongkar_housing = $workData->hour_bongkar_housing ?? 0;
                    $hour_pembuatan_cu_link = $workData->hour_pembuatan_cu_link ?? 0;
                    $hour_accesories = $workData->hour_accesories ?? 0;
                    return ($hour_wiring +
                        $hour_instal_housing +
                        $hour_bongkar_housing +
                        $hour_pembuatan_cu_link +
                        $hour_accesories) * $item->qty_trafo;
                } else {
                    return 0;
                }
            });

        $jumlahtotalHourCCAConect = $gpadryfilterCCAConect->where('nama_workcenter', 'Connection & Final Assembly')
            ->whereBetween('deadline', $deadlineDate)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDryConect)
            ->get()
            ->sum(function ($item) {
                $workData = $item->wo->standardize_work->dry_cast_resin ?? $item->wo->standardize_work->dry_non_resin;

                if ($workData) {
                    $hour_others = $workData->hour_others ?? 0;
                    $hour_potong_isolasi_fiver = $workData->hour_potong_isolasi_fiber ?? 0;
                    return ($hour_others +
                        $hour_potong_isolasi_fiver) * $item->qty_trafo;
                } else {
                    return 0;
                }
            });
        switch ($periode) {
            case 1:
                $kebutuhanMPCoil_Making_HV = $jumlahtotalHourCoil_Making_HV / (173  * 0.93);
                $kebutuhanMPCoil_Making_LV = $jumlahtotalHourCoil_Making_LV / (173  * 0.93);
                $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (173  * 0.93);
                $kebutuhanMPCCASusun = $jumlahtotalHourCCASusun / (173  * 0.93);
                $kebutuhanMPCCAFinishing = $jumlahtotalHourCCAFinishing / (173  * 0.93);
                $kebutuhanMPCCAConect = $jumlahtotalHourCCAConect / (173  * 0.93);
                break;
            case 2:
                $kebutuhanMPCoil_Making_HV = $jumlahtotalHourCoil_Making_HV / (40  * 0.93);
                $kebutuhanMPCoil_Making_LV = $jumlahtotalHourCoil_Making_LV / (40  * 0.93);
                $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (40  * 0.93);
                $kebutuhanMPCCASusun = $jumlahtotalHourCCASusun / (40  * 0.93);
                $kebutuhanMPCCAFinishing = $jumlahtotalHourCCAFinishing / (40  * 0.93);
                $kebutuhanMPCCAConect = $jumlahtotalHourCCAConect / (40  * 0.93);
                break;
            case 3:
                $kebutuhanMPCoil_Making_HV = $jumlahtotalHourCoil_Making_HV / (40  * 0.93);
                $kebutuhanMPCoil_Making_LV = $jumlahtotalHourCoil_Making_LV / (40  * 0.93);
                $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (40  * 0.93);
                $kebutuhanMPCCASusun = $jumlahtotalHourCCASusun / (40  * 0.93);
                $kebutuhanMPCCAFinishing = $jumlahtotalHourCCAFinishing / (40  * 0.93);
                $kebutuhanMPCCAConect = $jumlahtotalHourCCAConect / (40  * 0.93);
                break;
            case 4:
                $kebutuhanMPCoil_Making_HV = $jumlahtotalHourCoil_Making_HV / (173  * 0.93);
                $kebutuhanMPCoil_Making_LV = $jumlahtotalHourCoil_Making_LV / (173  * 0.93);
                $kebutuhanMPMould_Casting = $jumlahtotalHourMould_Casting / (173  * 0.93);
                $kebutuhanMPCCASusun = $jumlahtotalHourCCASusun / (173  * 0.93);
                $kebutuhanMPCCAFinishing = $jumlahtotalHourCCAFinishing / (173  * 0.93);
                $kebutuhanMPCCAConect = $jumlahtotalHourCCAConect / (173  * 0.93);
                break;
        }

        $selisihMPCoil_Making_HV = $kebutuhanMPCoil_Making_HV - $totalManPower;
        $selisihMPCoil_Making_LV = $kebutuhanMPCoil_Making_LV - $totalManPower;
        $selisihMPMould_Casting = $kebutuhanMPMould_Casting - $totalManPower;
        $selisihMPCCASusun = $kebutuhanMPCCASusun - $totalManPower;
        $selisihMPCCAFinishing = $kebutuhanMPCCAFinishing - $totalManPower;
        $selisihMPCCAConect = $kebutuhanMPCCAConect - $totalManPower;

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
        if ($kebutuhanMPCCASusun != 0) {
            $presentaseKurangMPCCASusun = ($selisihMPCCASusun / $kebutuhanMPCCASusun) * 100;
        } else {
            $presentaseKurangMPCCASusun = 0;
        }
        if ($kebutuhanMPCCAFinishing != 0) {
            $presentaseKurangMPCCAFinishing = ($selisihMPCCAFinishing / $kebutuhanMPCCAFinishing) * 100;
        } else {
            $presentaseKurangMPCCAFinishing = 0;
        }
        if ($kebutuhanMPCCAConect != 0) {
            $presentaseKurangMPCCAConect = ($selisihMPCCAConect / $kebutuhanMPCCAConect) * 100;
        } else {
            $presentaseKurangMPCCAConect = 0;
        }

        $ketersediaanMPCoil_Making_HV = $kebutuhanMPCoil_Making_HV - ($kebutuhanMPCoil_Making_HV * $presentaseKurangMPCoil_Making_HV) / 100;
        $ketersediaanMPCoil_Making_LV = $kebutuhanMPCoil_Making_LV - ($kebutuhanMPCoil_Making_LV * $presentaseKurangMPCoil_Making_LV) / 100;
        $ketersediaanMPMould_Casting = $kebutuhanMPMould_Casting - ($kebutuhanMPMould_Casting * $presentaseKurangMPMould_Casting) / 100;
        $ketersediaanMPCCASusun = $kebutuhanMPCCASusun - ($kebutuhanMPCCASusun * $presentaseKurangMPCCASusun) / 100;
        $ketersediaanMPCCAFinishing = $kebutuhanMPCCAFinishing - ($kebutuhanMPCCAFinishing * $presentaseKurangMPCCAFinishing) / 100;
        $ketersediaanMPCCAConect = $kebutuhanMPCCAConect - ($kebutuhanMPCCAConect * $presentaseKurangMPCCAConect) / 100;
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
        if ($kebutuhanMPCCASusun <= $ketersediaanMPCCASusun) {
            $selisihMPCCASusun = 0;
            $ketersediaanMPCCASusun = $kebutuhanMPCCASusun;
        }
        if ($kebutuhanMPCCAFinishing <= $ketersediaanMPCCAFinishing) {
            $selisihMPCCAFinishing = 0;
            $ketersediaanMPCCAFinishing = $kebutuhanMPCCAFinishing;
        }
        if ($kebutuhanMPCCAConect <= $ketersediaanMPCCAConect) {
            $selisihMPCCAConect = 0;
            $ketersediaanMPCCAConect = $kebutuhanMPCCAConect;
        }

        session(['ketersediaanMPCoil_Making_LV' => $ketersediaanMPCoil_Making_LV]);
        session(['ketersediaanMPCoil_Making_HV' => $ketersediaanMPCoil_Making_HV]);
        session(['ketersediaanMPMould_Casting' => $ketersediaanMPMould_Casting]);
        session(['ketersediaanMPCCASusun' => $ketersediaanMPCCASusun]);
        session(['ketersediaanMPCCAFinishing' => $ketersediaanMPCCAFinishing]);
        session(['ketersediaanMPCCAConect' => $ketersediaanMPCCAConect]);

        $wc_Coil_Making_HV =  'Coil Making HV';
        $wc_Coil_Making_LV =  'Coil Making LV';
        $wc_Mould_Casting =  'Mould & Casting';
        $wc_CCASusun =  'Susun Core';
        $wc_CCAFinishing =  'Finishing';
        $wc_CCAConect =  'Connection & Final Assembly';

        $data = [
            'jumlahtotalHourCoil_Making_LV' => $jumlahtotalHourCoil_Making_LV,
            'jumlahtotalHourCoil_Making_HV' => $jumlahtotalHourCoil_Making_HV,
            'jumlahtotalHourMould_Casting' => $jumlahtotalHourMould_Casting,
            'jumlahtotalHourCCASusun' => $jumlahtotalHourCCASusun,
            'jumlahtotalHourCCAFinishing' => $jumlahtotalHourCCAFinishing,
            'jumlahtotalHourCCAConect' => $jumlahtotalHourCCAConect,
            'selisihMPCoil_Making_HV' => $selisihMPCoil_Making_HV,
            'selisihMPCoil_Making_LV' => $selisihMPCoil_Making_LV,
            'selisihMPMould_Casting' => $selisihMPMould_Casting,
            'selisihMPCCASusun' => $selisihMPCCASusun,
            'selisihMPCCAFinishing' => $selisihMPCCAFinishing,
            'selisihMPCCAConect' => $selisihMPCCAConect,
            'totalManPower;' => $totalManPower,
            'kebutuhanMPCoil_Making_HV' => $kebutuhanMPCoil_Making_HV,
            'kebutuhanMPCoil_Making_LV' => $kebutuhanMPCoil_Making_LV,
            'kebutuhanMPMould_Casting' => $kebutuhanMPMould_Casting,
            'kebutuhanMPCCASusun' => $kebutuhanMPCCASusun,
            'kebutuhanMPCCAFinishing' => $kebutuhanMPCCAFinishing,
            'kebutuhanMPCCAConect' => $kebutuhanMPCCAConect,
            'wc_Coil_Making_HV' => $wc_Coil_Making_HV,
            'wc_Coil_Making_LV' => $wc_Coil_Making_LV,
            'wc_Mould_Casting' => $wc_Mould_Casting,
            'wc_CCASusun' => $wc_CCASusun,
            'wc_CCAFinishing' => $wc_CCAFinishing,
            'wc_CCAConect' => $wc_CCAConect,
            'ketersediaanMPCoil_Making_HV' => $ketersediaanMPCoil_Making_HV,
            'ketersediaanMPCoil_Making_LV' => $ketersediaanMPCoil_Making_LV,
            'ketersediaanMPMould_Casting' => $ketersediaanMPMould_Casting,
            'ketersediaanMPCCASusun' => $ketersediaanMPCCASusun,
            'ketersediaanMPCCAFinishing' => $ketersediaanMPCCAFinishing,
            'ketersediaanMPCCAConect' => $ketersediaanMPCCAConect,
            'title1' => $title1,
            'kapasitas' => $kapasitas,
            'PL' => $PL,
            'deadlineDate' => $deadlineDate,
        ];
        return view('produksi.resource_work_planning.DRY.kebutuhan', ['data' => $data]);
    }
    public function dryRekomendasi(Request $request)
    {
        $title1 = 'Dry - Rekomendasi';

        $selectedWorkcenter_rekomendasi = $request->input('Workcenter_rekomendasi', null);
        $selectedPeriode = $request->input('periodeDry', null);
        $selectedShift = $request->input('shiftDry', null);
        if ($selectedWorkcenter_rekomendasi === null || !in_array($selectedWorkcenter_rekomendasi, [1, 2, 3, 4])) {
            $storedValue = $request->session()->get('selectedWorkcenter_rekomendasi');
            $selectedWorkcenter_rekomendasi = ($storedValue && in_array($storedValue, [1, 2, 3, 4])) ? $storedValue : 1;
        }
        if ($selectedPeriode === null || !in_array($selectedPeriode, [1, 2, 3, 4])) {
            $storedPeriodeValue = $request->session()->get('selectedPeriodeDry');
            $selectedPeriode = ($storedPeriodeValue && in_array($storedPeriodeValue, [1, 2, 3, 4])) ? $storedPeriodeValue : 1;
        }

        if ($selectedShift === null || !in_array($selectedShift, [1, 2, 3])) {
            $storedShiftValue = $request->session()->get('selectedShiftDry');
            $selectedShift = ($storedShiftValue && in_array($storedShiftValue, [1, 2, 3, 4])) ? $storedShiftValue : 1;
        }
        switch ($selectedPeriode) {
            case 1:
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
                $hour = $gpadryfilterLV->pluck('wo.standardize_work.dry_cast_resin.hour_coil_lv');
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
                $namaMP = [];
                $coilHv = $gpadryfilterHV->pluck('wo.standardize_work.dry_cast_resin.coil_hv');
                $hour = $gpadryfilterHV->pluck('wo.standardize_work.dry_cast_resin.hour_coil_hv');
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'DRY')
                        ->where('nama_workcenter', 'COIL MAKING HV')
                        ->where('proses', 'COIL HV')
                        ->whereIn('tipe_proses', $coilHv)
                        ->where('skill', 4)
                        ->pluck('nama_mp')
                        ->toArray();
                    if (!empty($namaMP_currentSkill)) {
                        $namaMP = array_merge($namaMP, $namaMP_currentSkill);
                    }
                    if (count($namaMP) >= ceil(session('ketersediaanMPCoil_Making_HV'))) {
                        break;
                    }
                }
                $jumlahNamaMP = ceil(session('ketersediaanMPCoil_Making_HV'));
                $namaMP = array_slice($namaMP, 0, $jumlahNamaMP);
                break;
                // case 3:
                //     $workcenterLabel = 'Mould & Casting';
                //     $woDry = $gpadryfilterMoulding;

                //     $hvmoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_moulding');
                //     $namaMP_hvmoulding = $manpower->where('production_line', 'DRY')
                //         ->where('nama_workcenter', 'MOULD & CASTING')
                //         ->where('proses', 'HV MOULDING')
                //         ->whereIn('tipe_proses', $hvmoulding)
                //         ->where('skill', 4)
                //         ->pluck('nama_mp')->toArray();

                //     $hvcasting = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_casting');
                //     $namaMP_lvmoulding = $manpower->where('production_line', 'DRY')
                //         ->where('nama_workcenter', 'MOULD & CASTING')
                //         ->where('proses', 'HV CASTING')
                //         ->whereIn('tipe_proses', $hvcasting)
                //         ->where('skill', 4)
                //         ->pluck('nama_mp')->toArray();

                //     $hvdemoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_demoulding');
                //     $namaMP_hvdemoulding = $manpower->where('production_line', 'DRY')
                //         ->where('nama_workcenter', 'MOULD & CASTING')
                //         ->where('proses', 'HV DEMOULDING')
                //         ->whereIn('tipe_proses', $hvdemoulding)
                //         ->where('skill', 4)
                //         ->pluck('nama_mp')->toArray();

                //     $lvbobbin = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.lv_bobbin');
                //     $namaMP_lvbobbin = $manpower->where('production_line', 'DRY')
                //         ->where('nama_workcenter', 'MOULD & CASTING')
                //         ->where('proses', 'LV BOBBIN')
                //         ->whereIn('tipe_proses', $lvbobbin)
                //         ->where('skill', 4)
                //         ->pluck('nama_mp')->toArray();

                //     $touch_up = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.touch_up');
                //     $namaMP_touch_up = $manpower->where('production_line', 'DRY')
                //         ->where('nama_workcenter', 'MOULD & CASTING')
                //         ->where('proses', 'TOUCH UP')
                //         ->whereIn('tipe_proses', $touch_up)
                //         ->where('skill', 4)
                //         ->pluck('nama_mp')->toArray();

                //     $lv_mouldingArray = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.lv_moulding');
                //     $namaMP_lv_moulding = [];
                //     foreach ($lv_mouldingArray as $lv_moulding) {
                //         $isolasiValues = explode(',', $lv_moulding);
                //         foreach ($isolasiValues as $lv_moulding) {
                //             $namaMP_lv_moulding = array_merge($namaMP_lv_moulding, $manpower->where('production_line', 'DRY')
                //                 ->where('nama_workcenter', 'MOULD & CASTING')
                //                 ->where('proses', 'LV MOULDING')
                //                 ->where('tipe_proses', $lv_moulding)
                //                 ->where('skill', 4)
                //                 ->pluck('nama_mp')->toArray());
                //         }
                //     }

                //     $namaMP = array_merge($namaMP_hvmoulding, $namaMP_lvmoulding, $namaMP_hvdemoulding, $namaMP_lvbobbin, $namaMP_lv_moulding, $namaMP_touch_up);
                //     $namaMP = array_unique($namaMP);
                //     break;
            case 3:
                $workcenterLabel = 'Mould & Casting';
                $woDry = $gpadryfilterMoulding;

                $hvmoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_moulding');
                $hvcasting = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_casting');
                $hvdemoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_demoulding');
                $lvbobbin = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.lv_bobbin');
                $touch_up = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.touch_up');
                $lv_mouldingArray = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.lv_moulding');
                $hour = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.totalHour_MouldCasting');


                $namaMP = [];
                // dd($hour )

                for ($i = ceil(session('ketersediaanMPMould_Casting')); $i > 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'DRY')
                        ->where('nama_workcenter', 'MOULD & CASTING')
                        ->where('skill', 4)
                        ->whereIn('tipe_proses', array_merge($hvmoulding->toArray(), $hvcasting->toArray(), $hvdemoulding->toArray(), $lvbobbin->toArray(), $lv_mouldingArray->toArray(), $touch_up->toArray()))
                        ->pluck('nama_mp')->toArray();

                    if (!empty($namaMP_currentSkill)) {
                        $namaMP = array_merge($namaMP, $namaMP_currentSkill);
                    }

                    if (count($namaMP) >= ceil(session('ketersediaanMPMould_Casting'))) {
                        break;
                    }
                }
                // dd($namaMP);

                $jumlahNamaMP = ceil(session('ketersediaanMPMould_Casting'));
                $namaMP = array_slice($namaMP, 0, $jumlahNamaMP);
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

                $potong_isolasi_fiberArray = $gpadryfilterCCAConect->pluck('wo.standardize_work.dry_cast_resin.potong_isolasi_fiber');
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

                $othersArray = $gpadryfilterCCAConect->pluck('wo.standardize_work.dry_cast_resin.others');
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
            'hour' => $hour,
        ];
        return view('produksi.resource_work_planning.DRY.rekomendasi', ['data' => $data]);
    }
}
