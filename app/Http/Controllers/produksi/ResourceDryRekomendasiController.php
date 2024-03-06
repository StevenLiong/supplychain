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
                    $hour_type_susun_core = $workData->totalHour_SusunCore ?? 0;
                    return $hour_type_susun_core * $item->qty_trafo;
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
                    $totalHour_Connection_Final_Assembly = $workData->totalHour_Connection_Final_Assembly ?? 0;
                    return $totalHour_Connection_Final_Assembly * $item->qty_trafo;
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
                    $totalHourFinishing = $workData->totalHour_Finishing ?? 0;
                    return $totalHourFinishing  * $item->qty_trafo;
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
                // $namaMPAlternatif = [];

                // Mendapatkan namaMP
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Coil Making')
                        ->where('proses', 'COIL LV')
                        ->whereIn('tipe_proses', $coilLv)
                        ->where('skill', $i)
                        ->whereNotIn('nama_mp', $namaMP) // Memastikan nama_mp tidak sama dengan namaMP sebelumnya
                        ->pluck('nama_mp')->toArray();

                    foreach ($namaMP_currentSkill as $nama_mp) {
                        // Cek apakah nama_mp sudah ada sebelumnya
                        if (!in_array($nama_mp, $namaMP)) {
                            // Cek apakah nama_mp sudah ada di ResultRekomendasi
                            $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                                ->whereNotIn('nama_workcenter',  ['LV Windling'])
                                ->first();
                            if (!$existingMP) {
                                $namaMP[] = $nama_mp;
                            }
                        }
                    }

                    // Jika jumlah namaMP sudah mencukupi
                    if (count($namaMP) >= $ketersediaanMPLV) {
                        break; // Keluar dari loop setelah mencapai jumlah yang sesuai
                    }

                    // foreach ($namaMP_currentSkill as $nama_mp) {
                    //     $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                    //         ->whereNotIn('nama_workcenter', ['LV Winding'])
                    //         ->first();
                    //     if ($existingMP) {
                    //         continue;
                    //     } else {
                    //         $namaMP[] = $nama_mp;
                    //     }
                    // }

                    // if (!empty($namaMP)) {
                    //     break; // Keluar dari loop setelah menemukan namaMP
                    // }
                }

                $namaMP = array_slice($namaMP, 0, ceil($ketersediaanMPLV));

                $newDates = collect();

                $hour->each(
                    function ($hours, $time) use ($dateStrings, $woIds, $namaMP) {
                        $date = Carbon::parse($dateStrings[$time])->startOfDay()->setHour(8);
                        $remainingHours = $hours;
                        $currentDate = null;
                        $woId = $woIds[$time];
                        $nama = $namaMP[$time];
                        // dd($namaAlternatif);

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
                            if (!ResultRekomendasi::where([
                                'end' => $endTime->format('Y-m-d'),
                                'wo_id' => $woId,
                                'nama_workcenter' => 'LV Windling',
                                'nama_proses' => 'COIL LV',
                            ])->exists()) {
                                ResultRekomendasi::create($currentDate);
                            }
                            $date = $date->copy()->addDay();
                        }
                    }
                );
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
                $dateStrings = $gpadryfilterHV->pluck('deadline');
                $woIds = $gpadryfilterHV->pluck('wo.id_wo');
                $coilHv = $gpadryfilterHV->pluck('wo.standardize_work.dry_cast_resin.coil_hv');
                $hour = $gpadryfilterHV->pluck('wo.standardize_work.dry_cast_resin.hour_coil_hv');
                $ketersediaanMPHV = $ketersediaanMPCoil_Making_HV;
                $namaMP = [];

                // Mendapatkan namaMP
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Coil Making')
                        ->where('proses', 'COIL HV')
                        ->whereIn('tipe_proses', $coilHv)
                        ->where('skill', $i)
                        ->whereNotIn('nama_mp', $namaMP) // Memastikan nama_mp tidak sama dengan namaMP sebelumnya
                        ->pluck('nama_mp')->toArray();
                    foreach ($namaMP_currentSkill as $nama_mp) {
                        // Cek apakah nama_mp sudah ada sebelumnya
                        if (!in_array($nama_mp, $namaMP)) {
                            // Cek apakah nama_mp sudah ada di ResultRekomendasi
                            $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                                ->whereNotIn('nama_workcenter',  ['HV Windling'])
                                ->first();
                            if (!$existingMP) {
                                $namaMP[] = $nama_mp;
                            }
                        }
                    }

                    // Jika jumlah namaMP sudah mencukupi
                    if (count($namaMP) >= $ketersediaanMPHV) {
                        break; // Keluar dari loop setelah mencapai jumlah yang sesuai
                    }

                    // foreach ($namaMP_currentSkill as $nama_mp) {
                    //     $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                    //         ->whereNotIn('nama_workcenter', ['HV Windling'])
                    //         ->first();
                    //     if ($existingMP) {
                    //         continue;
                    //     } else {
                    //         $namaMP[] = $nama_mp;
                    //     }
                    // }

                    // if (!empty($namaMP)) {
                    //     break; // Keluar dari loop setelah menemukan namaMP
                    // }
                }

                $namaMP = array_slice($namaMP, 0, ceil($ketersediaanMPHV));

                $newDates = collect();
                $hour->each(function ($hours, $time) use ($dateStrings, $woIds, $namaMP) {
                    $date = Carbon::parse($dateStrings[$time])->startOfDay()->setHour(8);
                    $remainingHours = $hours;
                    $currentDate = null;
                    $woId = $woIds[$time];
                    $nama = $namaMP[$time];
                    // $namaAlternatif = $namaMPAlternatif[$time];

                    // dd($namaMPAlternatif);
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
                        if (!ResultRekomendasi::where([
                            'end' => $endTime->format('Y-m-d'),
                            'wo_id' => $woId,
                            'nama_workcenter' => 'HV Windling',
                            'nama_proses' => 'COIL HV',
                        ])->exists()) {
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

                $dateStrings = $gpadryfilterMoulding->pluck('deadline');
                $woIds = $gpadryfilterMoulding->pluck('wo.id_wo');

                $hvmoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_moulding');
                $hvcasting = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_casting');
                $hvdemoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_demoulding');
                $lvbobbin = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.lv_bobbin');

                $lvbobbin_values = explode(",", $lvbobbin);

                $lvbobbin1 = isset($lvbobbin_values[0]) ? trim($lvbobbin_values[0], " \t\n\r\0\x0B\"'[]") : null;
                $lvbobbin2 = isset($lvbobbin_values[1]) ? trim($lvbobbin_values[1], " \t\n\r\0\x0B\"'[]") : null;

                $lv_moulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.lv_moulding');
                $lvmoulding_values = explode(",", $lv_moulding);

                $lvmoulding1 = isset($lvmoulding_values[0]) ? trim($lvmoulding_values[0], " \t\n\r\0\x0B\"'[]") : null;
                $lvmoulding2 = isset($lvmoulding_values[1]) ? trim($lvmoulding_values[1], " \t\n\r\0\x0B\"'[]") : null;
                $lvmoulding3 = isset($lvmoulding_values[2]) ? trim($lvmoulding_values[2], " \t\n\r\0\x0B\"'[]") : null;
                $lvmoulding4 = isset($lvmoulding_values[3]) ? trim($lvmoulding_values[3], " \t\n\r\0\x0B\"'[]") : null;

                $touch_up = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.touch_up');
                $touch_up_values = explode(",", $touch_up);

                $touch_up1 = isset($touch_up_values[0]) ? trim($touch_up_values[0], " \t\n\r\0\x0B\"'[]") : null;
                $touch_up2 = isset($touch_up_values[1]) ? trim($touch_up_values[1], " \t\n\r\0\x0B\"'[]") : null;

                $hour = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.totalHour_MouldCasting');

                $ketersediaanMPMould = $ketersediaanMPMould_Casting;
                $namaMP = [];
                // Mendapatkan namaMP
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Mould & Casting')
                        // ->where('proses', 'HV MOULDING')
                        ->whereIn('tipe_proses', [$hvmoulding, $hvcasting, $hvdemoulding, $lvbobbin1, $lvbobbin2, $lvmoulding1, $lvmoulding2, $lvmoulding3, $lvmoulding4, $touch_up1, $touch_up2])
                        ->where('skill', $i)
                        ->whereNotIn('nama_mp', $namaMP) // Memastikan nama_mp tidak sama dengan namaMP sebelumnya
                        ->pluck('nama_mp')->toArray();

                    foreach ($namaMP_currentSkill as $nama_mp) {
                        // Cek apakah nama_mp sudah ada sebelumnya
                        if (!in_array($nama_mp, $namaMP)) {
                            // Cek apakah nama_mp sudah ada di ResultRekomendasi
                            $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                                ->whereNotIn('nama_workcenter', ['Moulding'])
                                ->first();
                            if (!$existingMP) {
                                $namaMP[] = $nama_mp;
                            }
                        }
                    }

                    // Jika jumlah namaMP sudah mencukupi
                    if (count($namaMP) >= $ketersediaanMPMould) {
                        break; // Keluar dari loop setelah mencapai jumlah yang sesuai
                    }

                    // foreach ($namaMP_currentSkill as $nama_mp) {
                    //     $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                    //         ->whereNotIn('nama_workcenter', ['Moulding'])
                    //         ->first();
                    //     if ($existingMP) {
                    //         continue;
                    //     } else {
                    //         $namaMP[] = $nama_mp;
                    //     }
                    // }

                    // if (!empty($namaMP)) {
                    //     break; // Keluar dari loop setelah menemukan namaMP
                    // }
                }
                $namaMP = array_slice($namaMP, 0, ceil($ketersediaanMPMould));

                $newDates = collect();

                $hour->each(function ($hours, $time) use ($dateStrings, $woIds, $namaMP) {
                    $date = Carbon::parse($dateStrings[$time])->startOfDay()->setHour(8);
                    $remainingHours = $hours;
                    $currentDate = null;
                    $woId = $woIds[$time];
                    $nama = $namaMP[$time];

                    if ($remainingHours <= 0) {
                        return;
                    }
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
                            'nama_proses' => 'Moulding & casting',
                        ];

                        if (!ResultRekomendasi::where([
                            'end' => $endTime->format('Y-m-d'),
                            'wo_id' => $woId,
                            'nama_workcenter' => 'Moulding',
                            'nama_proses' => 'Moulding & casting',
                        ])->exists()) {
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
                $potong_isolasi_fiber = $gpadryfilterCCASusun->pluck('wo.standardize_work.dry_cast_resin.potong_isolasi_fiber');

                $hour = $gpadryfilterCCASusun->pluck('wo.standardize_work.dry_cast_resin.totalHour_SusunCore');


                $potong_isolasi_fiber_values = explode(",", $potong_isolasi_fiber);

                $potong_isolasi_fiber1 = isset($potong_isolasi_fiber_values[0]) ? trim($potong_isolasi_fiber_values[0], " \t\n\r\0\x0B\"'[]") : null;
                $potong_isolasi_fiber2 = isset($potong_isolasi_fiber_values[1]) ? trim($potong_isolasi_fiber_values[1], " \t\n\r\0\x0B\"'[]") : null;

                $ketersediaanMPSusun = $ketersediaanMPCCASusun;
                $namaMP = [];
                // Mendapatkan namaMP
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Core Coil Assembly')
                        // ->where('proses', 'TYPE SUSUN CORE')
                        ->whereIn('tipe_proses', [$susun_core, $potong_isolasi_fiber1, $potong_isolasi_fiber2])
                        ->where('skill', $i)
                        ->whereNotIn('nama_mp', $namaMP) // Memastikan nama_mp tidak sama dengan namaMP sebelumnya
                        ->pluck('nama_mp')->toArray();

                    foreach ($namaMP_currentSkill as $nama_mp) {
                        // Cek apakah nama_mp sudah ada sebelumnya
                        if (!in_array($nama_mp, $namaMP)) {
                            // Cek apakah nama_mp sudah ada di ResultRekomendasi
                            $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                                ->whereNotIn('nama_workcenter', ['Susun Core'])
                                ->first();
                            if (!$existingMP) {
                                $namaMP[] = $nama_mp;
                            }
                        }
                    }

                    // Jika jumlah namaMP sudah mencukupi
                    if (count($namaMP) >= $ketersediaanMPSusun) {
                        break; // Keluar dari loop setelah mencapai jumlah yang sesuai
                    }

                    // foreach ($namaMP_currentSkill as $nama_mp) {
                    //     $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                    //         ->whereNotIn('nama_workcenter', ['Susun Core'])
                    //         ->first();
                    //     if ($existingMP) {
                    //         continue;
                    //     } else {
                    //         $namaMP[] = $nama_mp;
                    //     }
                    // }

                    // if (!empty($namaMP)) {
                    //     break; // Keluar dari loop setelah menemukan namaMP
                    // }
                }

                $namaMP = array_slice($namaMP, 0, ceil($ketersediaanMPSusun));

                // dd($namaMPAlternatif);
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
                        if (!ResultRekomendasi::where([
                            'end' => $endTime->format('Y-m-d'),
                            'wo_id' => $woId,
                            'nama_workcenter' => 'Susun Core',
                            'nama_proses' => 'TYPE SUSUN CORE',
                        ])->exists()) {
                            ResultRekomendasi::create($currentDate);
                        }

                        $date = $date->copy()->addDay();
                    }
                });
                break;
            case 5:
                $workcenterLabel = 'Connection & Final Assembly';

                $hasil = ResultRekomendasi::where('nama_workcenter', 'Connection & Final Assembly')
                    ->whereBetween('end', $getDay)
                    ->get();
                $gpadryfilterCCAConect = $gpadryfilterCCAConect->where('nama_workcenter', 'Connection & Final Assembly')
                    ->whereBetween('deadline', $getDay)
                    ->get();
                // $woDry = $gpadryfilterCCAConect;
                $dateStrings = $gpadryfilterCCAConect->pluck('deadline');
                $woIds = $gpadryfilterCCAConect->pluck('wo.id_wo');


                $others = $gpadryfilterCCAConect->pluck('wo.standardize_work.dry_cast_resin.others');
                $others_values = explode(",", $others);

                $others1 = isset($others_values[0]) ? trim($others_values[0], " \t\n\r\0\x0B\"'[]") : null;
                $others2 = isset($others_values[1]) ? trim($others_values[1], " \t\n\r\0\x0B\"'[]") : null;
                $others3 = isset($others_values[2]) ? trim($others_values[2], " \t\n\r\0\x0B\"'[]") : null;
                $others4 = isset($others_values[3]) ? trim($others_values[3], " \t\n\r\0\x0B\"'[]") : null;
                $others5 = isset($others_values[4]) ? trim($others_values[4], " \t\n\r\0\x0B\"'[]") : null;

                $hour = $gpadryfilterCCAConect->pluck('wo.standardize_work.dry_cast_resin.hour_others');

                $ketersediaanMPConect = $ketersediaanMPCCAConect;
                $namaMP = [];
                // Mendapatkan namaMP
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Core Coil Assembly')
                        ->where('proses', 'OTHERS')
                        ->whereIn('tipe_proses', [$others1, $others2, $others3, $others4, $others5])
                        ->where('skill', $i)
                        ->whereNotIn('nama_mp', $namaMP) // Memastikan nama_mp tidak sama dengan namaMP sebelumnya
                        ->pluck('nama_mp')->toArray();

                    foreach ($namaMP_currentSkill as $nama_mp) {
                        // Cek apakah nama_mp sudah ada sebelumnya
                        if (!in_array($nama_mp, $namaMP)) {
                            // Cek apakah nama_mp sudah ada di ResultRekomendasi
                            $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                                ->whereNotIn('nama_workcenter', ['Connection & Final Assembly'])
                                ->first();
                            if (!$existingMP) {
                                $namaMP[] = $nama_mp;
                            }
                        }
                    }

                    // Jika jumlah namaMP sudah mencukupi
                    if (count($namaMP) >= $ketersediaanMPConect) {
                        break; // Keluar dari loop setelah mencapai jumlah yang sesuai
                    }

                    // foreach ($namaMP_currentSkill as $nama_mp) {
                    //     $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                    //         ->whereNotIn('nama_workcenter', ['Connection & Final Assembly'])
                    //         ->first();
                    //     if ($existingMP) {
                    //         continue;
                    //     } else {
                    //         $namaMP[] = $nama_mp;
                    //     }
                    // }

                    // if (!empty($namaMP)) {
                    //     break; // Keluar dari loop setelah menemukan namaMP
                    // }
                }

                $namaMP = array_slice($namaMP, 0, ceil($ketersediaanMPConect));

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
                            'nama_workcenter' => 'Connection & Final Assembly',
                            'nama_proses' => 'connect',
                        ];
                        if (!ResultRekomendasi::where([
                            'end' => $endTime->format('Y-m-d'),
                            'wo_id' => $woId,
                            'nama_workcenter' => 'Connection & Final Assembly',
                            'nama_proses' => 'connect',
                        ])->exists()) {
                            ResultRekomendasi::create($currentDate);
                        }
                        $date = $date->copy()->addDay();
                    }
                });
                break;
            case 6:
                $workcenterLabel = 'Finishing';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'Finishing')
                    ->whereBetween('end', $getDay)
                    ->get();

                $gpadryfilterCCAFinishing = $gpadryfilterCCAFinishing->where('nama_workcenter', 'Finishing')
                    ->whereBetween('deadline', $getDay)
                    ->get();

                $dateStrings = $gpadryfilterCCAFinishing->pluck('deadline');

                // dd($dateStrings);
                $woIds = $gpadryfilterCCAFinishing->pluck('wo.id_wo');

                $wiring = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.wiring');
                $instal_housing = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.instal_housing');
                $bongkar_housing = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.bongkar_housing');
                $pembuatan_cu_link = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.pembuatan_cu_link');
                $accesories = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.accesories');

                $accesories_values = explode(",", $accesories);

                $accesories1 = isset($accesories_values[0]) ? trim($accesories_values[0], " \t\n\r\0\x0B\"'[]") : null;
                $accesories2 = isset($accesories_values[1]) ? trim($accesories_values[1], " \t\n\r\0\x0B\"'[]") : null;

                $hour = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.totalHour_Finishing');

                $ketersediaanMPFinishing = $ketersediaanMPCCAFinishing;
                $namaMP = [];
                // Mendapatkan namaMP
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill = $manpower->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Core Coil Assembly')
                        // ->where('proses', 'TYPE SUSUN CORE')
                        ->whereIn('tipe_proses', [$wiring, $instal_housing, $bongkar_housing, $pembuatan_cu_link, $accesories1, $accesories2])
                        ->where('skill', $i)
                        ->whereNotIn('nama_mp', $namaMP) // Memastikan nama_mp tidak sama dengan namaMP sebelumnya
                        ->pluck('nama_mp')->toArray();

                    foreach ($namaMP_currentSkill as $nama_mp) {
                        // Cek apakah nama_mp sudah ada sebelumnya
                        if (!in_array($nama_mp, $namaMP)) {
                            // Cek apakah nama_mp sudah ada di ResultRekomendasi
                            $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                                ->whereNotIn('nama_workcenter', ['Finishing'])
                                ->first();
                            if (!$existingMP) {
                                $namaMP[] = $nama_mp;
                            }
                        }
                    }

                    // Jika jumlah namaMP sudah mencukupi
                    if (count($namaMP) >= $ketersediaanMPFinishing) {
                        break; // Keluar dari loop setelah mencapai jumlah yang sesuai
                    }

                    // foreach ($namaMP_currentSkill as $nama_mp) {
                    //     $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                    //         ->whereNotIn('nama_workcenter', ['Finishing'])
                    //         ->first();
                    //     if ($existingMP) {
                    //         continue;
                    //     } else {
                    //         $namaMP[] = $nama_mp;
                    //     }
                    // }

                    // if (!empty($namaMP)) {
                    //     break; // Keluar dari loop setelah menemukan namaMP
                    // }
                }

                $namaMP = array_slice($namaMP, 0, ceil($ketersediaanMPFinishing));

                $newDates = collect();

                // $hour->each(function ($hours, $time) use ($dateStrings, $woIds, $namaMP) {
                //     $date = Carbon::parse($dateStrings[$time])->startOfDay()->setHour(8);
                //     $remainingHours = $hours;
                //     $currentDate = null;
                //     $woId = $woIds[$time];
                if ($hour !== 0) {
                    $hour->each(function ($hours, $time) use ($dateStrings, $woIds, $namaMP) {
                        $date = Carbon::parse($dateStrings[$time])->startOfDay()->setHour(8);
                        $remainingHours = $hours;
                        $currentDate = null;
                        $woId = $woIds[$time];
                        $nama = $namaMP[$time];

                        if ($remainingHours <= 0) {
                            return;
                        }
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
                                'nama_workcenter' => 'Finishing',
                                'nama_proses' => 'Finishing CCA',

                            ];

                            if (!ResultRekomendasi::where([
                                'end' => $endTime->format('Y-m-d'),
                                'wo_id' => $woId,
                                'nama_workcenter' => 'Finishing',
                                'nama_proses' => 'Finishing CCA',
                            ])->exists()) {
                                ResultRekomendasi::create($currentDate);
                            }

                            $date = $date->copy()->addDay();
                        }
                    });
                } else {
                    $currentDate = [
                        'end' => $dateStrings[0],
                        'hours' => 0,
                        'wo_id' => $woIds[0],
                        'nama_mp' => 'Tidak Menggunakan Finishing',
                        'nama_workcenter' => 'Finishing',
                        'nama_proses' => 'Finishing CCA',

                    ];
                    if (!ResultRekomendasi::where([
                        'end' => $dateStrings[0],
                        'wo_id' => $woIds[0],
                        'nama_workcenter' => 'Finishing',
                        'nama_proses' => 'Finishing CCA',
                    ])->exists()) {
                        ResultRekomendasi::create($currentDate);
                    }
                };
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
            'hasil' => $hasil,
            'namaMP' => $namaMP,
            'hour' => $hour,
            'newDates' => $newDates,
            'resultRekomendasi' => $resultRekomendasi,
        ];
        return view('produksi.resource_work_planning.DRY.rekomendasi', ['data' => $data]);
    }
}
