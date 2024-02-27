<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Models\planner\GPADry;
use App\Models\produksi\ManPower;
use App\Models\produksi\MatriksSkill;
use App\Models\produksi\ResultRekomendasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResourceDryRekomendasiController extends Controller
{
    public function dryRekomendasi(Request $request)
    {
        $title1 = 'Dry - Rekomendasi';
        $manpower = MatriksSkill::all();
        $totalManPower = ManPower::count();
        $resultRekomendasi = ResultRekomendasi::all();


        $selectedWorkcenter_rekomendasi = $request->input('Workcenter_rekomendasi', null);
        $selectedPeriode = $request->input('periodeDry', null);
        $selectedShift = $request->input('shiftDry', null);
        if ($selectedWorkcenter_rekomendasi === null || !in_array($selectedWorkcenter_rekomendasi, [1, 2, 3, 4, 5, 6])) {
            $storedValue = $request->session()->get('selectedWorkcenter_rekomendasi');
            $selectedWorkcenter_rekomendasi = ($storedValue && in_array($storedValue, [1, 2, 3, 4, 5, 6])) ? $storedValue : 1;
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
        $gpadryfilterHV = clone $gpadry;
        $gpadryfilterMoulding = clone $gpadry;
        $gpadryfilterCCASusun = clone $gpadry;
        $gpadryfilterCCAFinishing = clone $gpadry;
        $gpadryfilterCCAConect = clone $gpadry;

        $woDryLV = $gpadryfilterLV->pluck('id_wo');
        $woDryHV = $gpadryfilterHV->pluck('id_wo');
        $woDryMould = $gpadryfilterMoulding->pluck('id_wo');
        $woDrySusun = $gpadryfilterCCASusun->pluck('id_wo');
        $woDryFinishing = $gpadryfilterCCAFinishing->pluck('id_wo');
        $woDryConect = $gpadryfilterCCAConect->pluck('id_wo');

        $jumlahtotalHourCoil_Making_HV =  $gpadryfilterHV->where('nama_workcenter', 'HV Windling')
            ->whereBetween('deadline', $getDay)
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
            ->whereBetween('deadline', $getDay)
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
            ->whereBetween('deadline', $getDay)
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
            ->whereBetween('deadline', $getDay)
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
            ->whereBetween('deadline', $getDay)
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
            ->whereBetween('deadline', $getDay)
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

        $KebutuhanLV = $jumlahtotalHourCoil_Making_LV / (40  * 0.93);
        $KebutuhanHV = $jumlahtotalHourCoil_Making_HV / (40  * 0.93);
        $KebutuhanMould = $jumlahtotalHourMould_Casting / (40  * 0.93);
        $KebutuhanSusun = $jumlahtotalHourCCASusun / (40  * 0.93);
        $KebutuhanConect = $jumlahtotalHourCCAConect / (40  * 0.93);
        $KebutuhanFinishing = $jumlahtotalHourCCAFinishing / (40  * 0.93);


        $selisihMPCoil_Making_HV = $KebutuhanLV - $totalManPower;
        $selisihMPCoil_Making_LV = $KebutuhanHV - $totalManPower;
        $selisihMPMould_Casting = $KebutuhanMould - $totalManPower;
        $selisihMPCCASusun = $KebutuhanSusun - $totalManPower;
        $selisihMPCCAFinishing = $KebutuhanFinishing - $totalManPower;
        $selisihMPCCAConect = $KebutuhanConect - $totalManPower;

        if ($KebutuhanLV != 0) {
            $presentaseKurangMPCoil_Making_HV = ($selisihMPCoil_Making_HV / $KebutuhanLV) * 100;
        } else {
            $presentaseKurangMPCoil_Making_HV = 0;
        }
        if ($KebutuhanHV != 0) {
            $presentaseKurangMPCoil_Making_LV = ($selisihMPCoil_Making_LV / $KebutuhanHV) * 100;
        } else {
            $presentaseKurangMPCoil_Making_LV = 0;
        }
        if ($KebutuhanMould != 0) {
            $presentaseKurangMPMould_Casting = ($selisihMPMould_Casting / $KebutuhanMould) * 100;
        } else {
            $presentaseKurangMPMould_Casting = 0;
        }
        if ($KebutuhanSusun != 0) {
            $presentaseKurangMPCCASusun = ($selisihMPCCASusun / $KebutuhanSusun) * 100;
        } else {
            $presentaseKurangMPCCASusun = 0;
        }
        if ($KebutuhanFinishing != 0) {
            $presentaseKurangMPCCAFinishing = ($selisihMPCCAFinishing / $KebutuhanFinishing) * 100;
        } else {
            $presentaseKurangMPCCAFinishing = 0;
        }
        if ($KebutuhanConect != 0) {
            $presentaseKurangMPCCAConect = ($selisihMPCCAConect / $KebutuhanConect) * 100;
        } else {
            $presentaseKurangMPCCAConect = 0;
        }

        $ketersediaanMPCoil_Making_LV = $KebutuhanLV - ($KebutuhanLV * $presentaseKurangMPCoil_Making_HV) / 100;
        $ketersediaanMPCoil_Making_HV = $KebutuhanHV - ($KebutuhanHV * $presentaseKurangMPCoil_Making_LV) / 100;
        $ketersediaanMPMould_Casting = $KebutuhanMould - ($KebutuhanMould * $presentaseKurangMPMould_Casting) / 100;
        $ketersediaanMPCCASusun = $KebutuhanSusun - ($KebutuhanSusun * $presentaseKurangMPCCASusun) / 100;
        $ketersediaanMPCCAFinishing = $KebutuhanFinishing - ($KebutuhanFinishing * $presentaseKurangMPCCAFinishing) / 100;
        $ketersediaanMPCCAConect = $KebutuhanConect - ($KebutuhanConect * $presentaseKurangMPCCAConect) / 100;
        if ($KebutuhanLV <= $ketersediaanMPCoil_Making_LV) {
            $selisihMPCoil_Making_LV = 0;
            $ketersediaanMPCoil_Making_LV = $KebutuhanLV;
        }
        if ($KebutuhanHV <= $ketersediaanMPCoil_Making_HV) {
            $selisihMPCoil_Making_HV = 0;
            $ketersediaanMPCoil_Making_HV = $KebutuhanHV;
        }
        if ($KebutuhanMould <= $ketersediaanMPMould_Casting) {
            $selisihMPMould_Casting = 0;
            $ketersediaanMPMould_Casting = $KebutuhanMould;
        }
        if ($KebutuhanSusun <= $ketersediaanMPCCASusun) {
            $selisihMPCCASusun = 0;
            $ketersediaanMPCCASusun = $KebutuhanSusun;
        }
        if ($KebutuhanFinishing <= $ketersediaanMPCCAFinishing) {
            $selisihMPCCAFinishing = 0;
            $ketersediaanMPCCAFinishing = $KebutuhanFinishing;
        }
        if ($KebutuhanConect <= $ketersediaanMPCCAConect) {
            $selisihMPCCAConect = 0;
            $ketersediaanMPCCAConect = $KebutuhanConect;
        }

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

                $hasil = ResultRekomendasi::where('nama_workcenter', 'LV Windling')
                    ->whereBetween('end', $getDay)
                    ->get();

                $gpadryfilterLV = $gpadryfilterLV->where('nama_workcenter', 'LV Windling')
                    ->whereBetween('deadline', $getDay)
                    ->get();

                $dateStrings = $gpadryfilterLV->pluck('deadline');
                $woIds = $gpadryfilterLV->pluck('wo.id_wo');
                $hour = $gpadryfilterLV->pluck('wo.standardize_work.dry_cast_resin.hour_coil_lv');
                $coilLv = $gpadryfilterLV->pluck('wo.standardize_work.dry_cast_resin.coil_lv');

                $ketersediaanMPLV = $ketersediaanMPCoil_Making_LV;
                $namaMP = [];
                // $unNamaMP = [];
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'DRY')
                        ->where('nama_workcenter', 'COIL MAKING LV')
                        ->where('proses', 'COIL LV')
                        ->whereIn('tipe_proses', $coilLv)
                        ->where('skill', $i)
                        ->pluck('nama_mp')->toArray();

                    // $namaMP_currentSkill = array_diff($namaMP_currentSkill, $unNamaMP);

                    if (!empty($namaMP_currentSkill)) {
                        $namaMP = array_merge($namaMP, $namaMP_currentSkill);
                    }
                    if (count($namaMP) >= ceil($ketersediaanMPLV)) {
                        break;
                    }
                }

                $jumlahNamaMP = ceil($ketersediaanMPLV);
                $namaMP = array_slice($namaMP, 0, $jumlahNamaMP);

                $newDates = collect();

                $hour->each(function ($hours, $time) use ($dateStrings, $woIds, $namaMP) {
                    $date = Carbon::parse($dateStrings[$time])->startOfDay()->setHour(8);
                    $remainingHours = $hours;
                    $currentDate = null;
                    $woId = $woIds[$time];
                    $nama = $namaMP[$time];
                    while ($remainingHours > 0) {
                        if ($date->isWeekend()) {
                            $date->nextWeekday();
                            continue;
                        }
                        $endTime = $date->copy()->addHours(min(8, $remainingHours));
                        $elapsedHours = min(8, $remainingHours);
                        $remainingHours -= $elapsedHours;

                        $currentDate = [
                            'end' => $endTime->format('Y-m-d'),
                            'hours' => $elapsedHours,
                            'wo_id' => $woId,
                            'nama_mp' => $nama,
                            'nama_workcenter' => 'LV Windling',
                            'nama_proses' => 'COIL LV',
                        ];

                        $existingRecord = ResultRekomendasi::where('end', $currentDate['end'])
                            ->where('hours', $currentDate['hours'])
                            ->where('wo_id', $currentDate['wo_id'])
                            // ->where('nama_mp', $currentDate['nama_mp'])
                            ->where('nama_workcenter', $currentDate['nama_workcenter'])
                            ->where('nama_proses', $currentDate['nama_proses'])
                            ->first();

                        if (!$existingRecord) {
                            ResultRekomendasi::create($currentDate);
                        }
                        $date = $date->copy()->addDay();
                    }
                });
                break;
            case 2:
                $workcenterLabel = 'Coil Making HV';

                $hasil = ResultRekomendasi::where('nama_workcenter', 'HV Windling')
                    ->whereBetween('end', $getDay)
                    ->get();

                $gpadryfilterHV = $gpadryfilterHV->where('nama_workcenter', 'HV Windling')
                    ->whereBetween('deadline', $getDay)
                    ->get();

                // $woDry = $gpadryfilterHV;
                $namaMP = [];
                $dateStrings = $gpadryfilterHV->pluck('deadline');
                $woIds = $gpadryfilterHV->pluck('wo.id_wo');
                $coilHv = $gpadryfilterHV->pluck('wo.standardize_work.dry_cast_resin.coil_hv');
                $hour = $gpadryfilterHV->pluck('wo.standardize_work.dry_cast_resin.hour_coil_hv');

                $ketersediaanMPHV = $ketersediaanMPCoil_Making_HV;
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'DRY')
                        ->where('nama_workcenter', 'COIL MAKING HV')
                        ->where('proses', 'COIL HV')
                        ->whereIn('tipe_proses', $coilHv)
                        ->where('skill', $i)
                        ->pluck('nama_mp')
                        ->toArray();
                    if (!empty($namaMP_currentSkill)) {
                        $namaMP = array_merge($namaMP, $namaMP_currentSkill);
                    }
                    if (count($namaMP) >= ceil($ketersediaanMPHV)) {
                        break;
                    }
                }
                $jumlahNamaMP = ceil($ketersediaanMPHV);
                $namaMP = array_slice($namaMP, 0, $jumlahNamaMP);


                $newDates = collect();

                $hour->each(function ($hours, $time) use ($dateStrings, $woIds, $namaMP) {
                    $date = Carbon::parse($dateStrings[$time])->startOfDay()->setHour(8);
                    $remainingHours = $hours;
                    $currentDate = null;
                    $woId = $woIds[$time];
                    $nama = $namaMP[$time];
                    while ($remainingHours > 0) {
                        if ($date->isWeekend()) {
                            $date->nextWeekday();
                            continue;
                        }
                        $endTime = $date->copy()->addHours(min(8, $remainingHours));
                        $elapsedHours = min(8, $remainingHours);
                        $remainingHours -= $elapsedHours;

                        $currentDate = [
                            'end' => $endTime->format('Y-m-d'),
                            'hours' => $elapsedHours,
                            'wo_id' => $woId,
                            'nama_mp' => $nama,
                            'nama_workcenter' => 'HV Windling',
                            'nama_proses' => 'COIL HV',
                        ];

                        $existingRecord = ResultRekomendasi::where('end', $currentDate['end'])
                            ->where('hours', $currentDate['hours'])
                            ->where('wo_id', $currentDate['wo_id'])
                            // ->where('nama_mp', $currentDate['nama_mp'])
                            ->where('nama_workcenter', $currentDate['nama_workcenter'])
                            ->where('nama_proses', $currentDate['nama_proses'])
                            ->first();

                        if (!$existingRecord) {
                            ResultRekomendasi::create($currentDate);
                        }
                        $date = $date->copy()->addDay();
                    }
                });
                break;
            case 3:
                $workcenterLabel = 'Mould & Casting';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'Moulding')
                    ->whereBetween('end', $getDay)
                    ->get();

                $gpadryfilterMoulding = $gpadryfilterMoulding->where('nama_workcenter', 'Moulding')
                    ->whereBetween('deadline', $getDay)
                    ->get();


                $hvmoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_moulding');
                $hvcasting = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_casting');
                $hvdemoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_demoulding');
                $lvbobbin = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.lv_bobbin');
                $touch_up = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.touch_up');
                $lv_mouldingArray = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.lv_moulding');

                $dateStrings = $gpadryfilterMoulding->pluck('deadline');
                $woIds = $gpadryfilterMoulding->pluck('wo.id_wo');
                $hour = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.totalHour_MouldCasting');
                $ketersediaanMPMould = $ketersediaanMPMould_Casting;
                $namaMP = [];
                for ($i = 4; $i > 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'DRY')
                        ->where('nama_workcenter', 'MOULD & CASTING')
                        ->whereIn('tipe_proses', array_merge($hvmoulding->toArray(), $hvcasting->toArray(), $hvdemoulding->toArray(), $lvbobbin->toArray(), $lv_mouldingArray->toArray(), $touch_up->toArray()))
                        ->where('skill', $i)
                        ->pluck('nama_mp')->toArray();
                    if (!empty($namaMP_currentSkill)) {
                        $namaMP = array_merge($namaMP, $namaMP_currentSkill);
                    }
                    if (count($namaMP) >= ceil($ketersediaanMPMould)) {
                        break;
                    }
                }
                $jumlahNamaMP = ceil($ketersediaanMPMould);
                $namaMP = array_slice($namaMP, 0, $jumlahNamaMP);

                $newDates = collect();

                $hour->each(function ($hours, $time) use ($dateStrings, $woIds, $namaMP) {
                    $date = Carbon::parse($dateStrings[$time])->startOfDay()->setHour(8);
                    $remainingHours = $hours;
                    $currentDate = null;
                    $woId = $woIds[$time];
                    $nama = $namaMP[$time];

                    while ($remainingHours > 0) {
                        if ($date->isWeekend()) {
                            $date->nextWeekday();
                            continue;
                        }
                        $endTime = $date->copy()->addHours(min(8, $remainingHours));
                        $elapsedHours = min(8, $remainingHours);
                        $remainingHours -= $elapsedHours;

                        $currentDate = [
                            'end' => $endTime->format('Y-m-d'),
                            'hours' => $elapsedHours,
                            'wo_id' => $woId,
                            'nama_mp' => $nama,
                            'nama_workcenter' => 'Moulding',
                            'nama_proses' => '',
                        ];

                        $existingRecord = ResultRekomendasi::where('end', $currentDate['end'])
                            ->where('hours', $currentDate['hours'])
                            ->where('wo_id', $currentDate['wo_id'])
                            // ->where('nama_mp', $currentDate['nama_mp'])
                            ->where('nama_workcenter', $currentDate['nama_workcenter'])
                            ->where('nama_proses', $currentDate['nama_proses'])
                            ->first();

                        if (!$existingRecord) {
                            ResultRekomendasi::create($currentDate);
                        }
                        $date = $date->copy()->addDay();
                    }
                });
                break;

            case 4:
                $workcenterLabel = 'Susun Core';

                $hasil = ResultRekomendasi::where('nama_workcenter', 'Susun Core')
                    ->whereBetween('end', $getDay)
                    ->get();

                $gpadryfilterCCASusun = $gpadryfilterCCASusun->where('nama_workcenter', 'Susun Core')
                    ->whereBetween('deadline', $getDay)
                    ->get();

                $dateStrings = $gpadryfilterCCASusun->pluck('deadline');
                $woIds = $gpadryfilterCCASusun->pluck('wo.id_wo');
                $susun_core = $gpadryfilterCCASusun->pluck('wo.standardize_work.dry_cast_resin.type_susun_core');
                $hour = $gpadryfilterCCASusun->pluck('wo.standardize_work.dry_cast_resin.hour_type_susun_core');
                $ketersediaanMPSusun = $ketersediaanMPCCASusun;
                $namaMP = [];
                for ($i = 4; $i > 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'DRY')
                        ->where('nama_workcenter', 'CORE & ASSEMBLY')
                        ->where('proses', 'TYPE SUSUN CORE')
                        ->whereIn('tipe_proses', $susun_core)
                        ->where('skill', $i)
                        ->pluck('nama_mp')->toArray();
                    if (!empty($namaMP_currentSkill)) {
                        $namaMP = array_merge($namaMP, $namaMP_currentSkill);
                    }

                    if (count($namaMP) >= ceil($ketersediaanMPSusun)) {
                        break;
                    }
                }
                $jumlahNamaMP = ceil($ketersediaanMPSusun);
                $namaMP = array_slice($namaMP, 0, $jumlahNamaMP);

                $newDates = collect();

                $hour->each(function ($hours, $time) use ($dateStrings, $woIds, $namaMP) {
                    $date = Carbon::parse($dateStrings[$time])->startOfDay()->setHour(8);
                    $remainingHours = $hours;
                    $currentDate = null;
                    $woId = $woIds[$time];
                    $nama = $namaMP[$time];

                    while ($remainingHours > 0) {
                        if ($date->isWeekend()) {
                            $date->nextWeekday();
                            continue;
                        }
                        $endTime = $date->copy()->addHours(min(8, $remainingHours));
                        $elapsedHours = min(8, $remainingHours);
                        $remainingHours -= $elapsedHours;

                        $currentDate = [
                            'end' => $endTime->format('Y-m-d'),
                            'hours' => $elapsedHours,
                            'wo_id' => $woId,
                            'nama_mp' => $nama,
                            'nama_workcenter' => 'Susun Core',
                            'nama_proses' => 'TYPE SUSUN CORE',
                        ];

                        $existingRecord = ResultRekomendasi::where('end', $currentDate['end'])
                            ->where('hours', $currentDate['hours'])
                            ->where('wo_id', $currentDate['wo_id'])
                            // ->where('nama_mp', $currentDate['nama_mp'])
                            ->where('nama_workcenter', $currentDate['nama_workcenter'])
                            ->where('nama_proses', $currentDate['nama_proses'])
                            ->first();

                        if (!$existingRecord) {
                            ResultRekomendasi::create($currentDate);
                        }
                        $date = $date->copy()->addDay();
                    }
                });
                break;
            case 5:
                $workcenterLabel = 'Connection & Final Assembly';
                $gpadryfilterCCAConect = $gpadryfilterCCAConect->where('nama_workcenter', 'Connection & Final Assembly')
                    ->whereBetween('deadline', $getDay)
                    ->get();
                $woDry = $gpadryfilterCCAConect;
                $potong_isolasi_fiberArray = $gpadryfilterCCAConect->pluck('wo.standardize_work.dry_cast_resin.potong_isolasi_fiber');
                $othersArray = $gpadryfilterCCAConect->pluck('wo.standardize_work.dry_cast_resin.others');
                $hour = $gpadryfilterCCAConect->pluck('wo.standardize_work.dry_cast_resin.hour_others');
                $ketersediaanMPConect = $ketersediaanMPCCAConect;
                $namaMP = [];
                for ($i = 4; $i > 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'DRY')
                        ->where('nama_workcenter', 'CORE & ASSEMBLY')
                        ->whereIn('tipe_proses', array_merge($potong_isolasi_fiberArray->toArray(), $othersArray->toArray()))
                        ->where('skill', $i)
                        ->pluck('nama_mp')->toArray();
                    if (!empty($namaMP_currentSkill)) {
                        $namaMP = array_merge($namaMP, $namaMP_currentSkill);
                    }
                    if (count($namaMP) >= ceil($ketersediaanMPConect)) {
                        break;
                    }
                }
                $jumlahNamaMP = ceil($ketersediaanMPConect);
                $namaMP = array_slice($namaMP, 0, $jumlahNamaMP);
                break;
            case 6:
                $workcenterLabel = 'Finishing';
                $gpadryfilterCCAFinishing = $gpadryfilterCCAFinishing->where('nama_workcenter', 'Finishing')
                    ->whereBetween('deadline', $getDay)
                    ->get();
                $woDry = $gpadryfilterCCAFinishing;
                $wiring = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.wiring');
                $instal_housing = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.instal_housing');
                $bongkar_housing = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.bongkar_housing');
                $pembuatan_cu_link = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.pembuatan_cu_link');
                $accesories = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.accesories');
                $hour = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.totalHour_MouldCasting');
                $ketersediaanMPFinishing = $ketersediaanMPCCAFinishing;
                $namaMP = [];
                for ($i = 4; $i > 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'DRY')
                        ->where('nama_workcenter', 'CORE & ASSEMBLY')
                        ->whereIn('tipe_proses', array_merge($wiring->toArray(), $instal_housing->toArray(), $bongkar_housing->toArray(), $pembuatan_cu_link->toArray(), $accesories->toArray()))
                        ->where('skill', $i)
                        ->pluck('nama_mp')->toArray();

                    if (!empty($namaMP_currentSkill)) {
                        $namaMP = array_merge($namaMP, $namaMP_currentSkill);
                    }

                    if (count($namaMP) >= ceil($ketersediaanMPFinishing)) {
                        break;
                    }
                }

                $jumlahNamaMP = ceil($ketersediaanMPFinishing);
                $namaMP = array_slice($namaMP, 0, $jumlahNamaMP);
                break;

                dd($hour);
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
            'hasil' => $hasil,
            'namaMP' => $namaMP,
            'hour' => $hour,
            'newDates' => $newDates,
            'resultRekomendasi' => $resultRekomendasi,
        ];
        return view('produksi.resource_work_planning.DRY.rekomendasi', ['data' => $data]);
    }
}
