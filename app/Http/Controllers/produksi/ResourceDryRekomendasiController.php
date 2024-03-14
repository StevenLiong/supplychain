<?php

namespace App\Http\Controllers\produksi;

use App\Http\Controllers\Controller;
use App\Models\planner\GPADry;
use App\Models\planner\Holiday;
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
        $matrixSkil = MatriksSkill::all();
        $totalManPower = ManPower::count();
        $resultRekomendasi = ResultRekomendasi::all();

        $dataHoliday = Holiday::all();
        $holidayDates = $dataHoliday->pluck('date')->map(function ($date) {
            return Carbon::parse($date);
        });

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

        $gpadry = GPADry::where('production_line', 'Dry');

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

        $jumlahtotalHourCoil_Making_LV = $gpadryfilterLV->where('nama_workcenter', 'LV Windling')
        ->whereBetween('deadline', $getDay)
            ->with(['wo.standardize_work', 'wo.standardize_work.dry_cast_resin', 'wo.standardize_work.dry_non_resin'])
            ->whereIn('id_wo', $woDryLV)
            ->get()
            ->sum(function ($item) {
                $workData = $item->wo->standardize_work->dry_cast_resin ?? $item->wo->standardize_work->dry_non_resin;
                if ($workData) {
                    $hourCoilmakingLV = $workData->totalHour_coil_makinglv ?? 0;
                    return $hourCoilmakingLV  * $item->qty_trafo;
                } else {
                    return 0;
                }
            });
            dd($woDryLV);
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
        // proses pengambilan data nama MP pada workcenter coil making LV melalui gpa

        $gpadryfilterLV = $gpadryfilterLV->where('nama_workcenter', 'LV Windling')
        ->whereBetween('deadline', $getDay)
        ->get();
        // dd($gpadryfilterLV);

        $dateStrings = $gpadryfilterLV->pluck('deadline');

        $woIds = $gpadryfilterLV->pluck('wo.id_wo');
        $coilLv = $gpadryfilterLV->pluck('wo.standardize_work.dry_cast_resin.coil_lv');
        $potong_leadwire = $gpadryfilterLV->pluck('wo.standardize_work.dry_cast_resin.potong_leadwire');
        $potong_isolasi = $gpadryfilterLV->pluck('wo.standardize_work.dry_cast_resin.potong_isolasi');

        $ketersediaanMPLV = $ketersediaanMPCoil_Making_LV;
        $namaMP = [];
        // Mendapatkan namaMP
        for ($i = 4; $i >= 0; $i--) {
            $namaMP_currentSkillLV = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Coil Making')
                ->where('proses', 'COIL LV')
                ->whereIn('tipe_proses', $coilLv)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOBlv = [];
            foreach ($namaMP_currentSkillLV as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter',  ['LV Windling'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOBlv[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            $namaMP_currentSkill_leadwire = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Coil Making')
                ->where('proses', 'POTONG LEAD WIRE')
                ->whereIn('tipe_proses', $potong_leadwire)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_leadwire = [];
            foreach ($namaMP_currentSkill_leadwire as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter',  ['LV Windling'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOB_leadwire[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            $namaMP_currentSkill_isolasi = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Coil Making')
                ->where('proses', 'POTONG ISOLASI')
                ->whereIn('tipe_proses', $potong_isolasi)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB = [];
            foreach ($namaMP_currentSkill_isolasi as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter',  ['LV Windling'])
                        ->first();
                    if (!$existingMP) {
                        if ($tanggal_lahir) {
                            $namaMP_withDOB[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            if (!empty($namaMP_withDOBlv)) {
                usort($namaMP_withDOBlv, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOBlv[0]['nama_mp'];
            }
            if (!empty($namaMP_withDOB_leadwire)) {
                usort($namaMP_withDOB_leadwire, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_leadwire[0]['nama_mp'];
            }
            if (!empty($namaMP_withDOB_isolasi)) {
                usort($namaMP_withDOB_isolasi, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_isolasi[0]['nama_mp'];
            }
            $namaMP = array_unique($namaMP);
            if (count($namaMP) >= $ketersediaanMPLV) {
                break;
            }
        }
        $namaMP = array_slice($namaMP, 0, ceil($ketersediaanMPLV));
        foreach ($woIds as $time => $wo) {
            $start = Carbon::parse($dateStrings[$time])->startOfDay();

            // Proses COIL LV
            $hourLV = $gpadryfilterLV->pluck('wo.standardize_work.dry_cast_resin.hour_coil_lv', $wo)->sum();
            $qtyLV = $gpadryfilterLV->pluck('qty_trafo', $wo)->sum();
            $remainingHoursLV = $hourLV * $qtyLV;
            $namaLV = $namaMP[$time];
            $currentDateLV = [];

            while ($remainingHoursLV > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTimeLV = $start->copy()->addHours(min(8, $remainingHoursLV));
                $minhourdayLV = min(8, $remainingHoursLV);
                $existingDataLV = ResultRekomendasi::where([
                    'end' => $endTimeLV->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $namaLV,
                    'nama_workcenter' => 'LV Windling',
                    'nama_proses' => 'COIL LV',
                    ])->exists();

                if (!$existingDataLV) {
                    $currentDateLV[] = [
                        'end' => $endTimeLV->format('Y-m-d'),
                        'hours' => $minhourdayLV,
                        'wo_id' => $wo,
                        'nama_mp' => $namaLV,
                        'nama_workcenter' => 'LV Windling',
                        'nama_proses' => 'COIL LV',
                    ];
                }
                $start = $endTimeLV->copy()->addSeconds(1);
                $remainingHoursLV -= $minhourdayLV;
                $start->addDay();
            }
            if (!empty($currentDateLV)) {
                ResultRekomendasi::insert($currentDateLV);
            }

            // Proses POTONG LEAD WIRE
            $hourLeadWire = $gpadryfilterLV->pluck('wo.standardize_work.dry_cast_resin.hour_potong_leadwire', $wo)->sum();
            $qtyLeadWire = $gpadryfilterLV->pluck('qty_trafo', $wo)->sum();
            $remainingHoursLeadWire = $hourLeadWire * $qtyLeadWire;
            $namaLeadWire = $namaMP[$time];
            $currentDateLeadWire = [];

            while ($remainingHoursLeadWire > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTimeLeadWire = $start->copy()->addHours(min(8, $remainingHoursLeadWire));
                $minhourdayLeadWire = min(8, $remainingHoursLeadWire);
                $existingDataLeadWire = ResultRekomendasi::where([
                    'end' => $endTimeLeadWire->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $namaLeadWire,
                    'nama_workcenter' => 'LV Windling',
                    'nama_proses' => 'POTONG LEAD WIRE',
                ])->exists();

                if (!$existingDataLeadWire) {
                    $currentDateLeadWire[] = [
                        'end' => $endTimeLeadWire->format('Y-m-d'),
                        'hours' => $minhourdayLeadWire,
                        'wo_id' => $wo,
                        'nama_mp' => $namaLeadWire,
                        'nama_workcenter' => 'LV Windling',
                        'nama_proses' => 'POTONG LEAD WIRE',
                    ];
                }
                $start = $endTimeLeadWire->copy()->addSeconds(1);
                $remainingHoursLeadWire -= $minhourdayLeadWire;
                $start->addDay();
            }
            if (!empty($currentDateLeadWire)) {
                ResultRekomendasi::insert($currentDateLeadWire);
            }

            // Proses POTONG ISOLASI
            $hourIsolasi = $gpadryfilterLV->pluck('wo.standardize_work.dry_cast_resin.hour_potong_isolasi', $wo)->sum();
            $qtyIsolasi = $gpadryfilterLV->pluck('qty_trafo', $wo)->sum();
            $remainingHoursIsolasi = $hourIsolasi * $qtyIsolasi;
            $namaIsolasi = isset($namaMP[$time]) && !empty($namaMP[$time]) ? $namaMP[$time] : "tidak ada nama MP";
            $currentDateIsolasi = [];

            while ($remainingHoursIsolasi > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTimeIsolasi = $start->copy()->addHours(min(8, $remainingHoursIsolasi));
                $minhourdayIsolasi = min(8, $remainingHoursIsolasi);
                $existingDataIsolasi = ResultRekomendasi::where([
                    'end' => $endTimeIsolasi->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $namaIsolasi,
                    'nama_workcenter' => 'LV Windling',
                    'nama_proses' => 'POTONG ISOLASI',
                ])->exists();

                if (!$existingDataIsolasi) {
                    $currentDateIsolasi[] = [
                        'end' => $endTimeIsolasi->format('Y-m-d'),
                        'hours' => $minhourdayIsolasi,
                        'wo_id' => $wo,
                        'nama_mp' => $namaIsolasi,
                        'nama_workcenter' => 'LV Windling',
                        'nama_proses' => 'POTONG ISOLASI',
                    ];
                }
                $start = $endTimeIsolasi->copy()->addSeconds(1);
                $remainingHoursIsolasi -= $minhourdayIsolasi;
                $start->addDay();
            }
            if (!empty($currentDateIsolasi)) {
                ResultRekomendasi::insert($currentDateIsolasi);
            }
        }

        // proses pengambilan data nama MP pada workcenter coil making HV melalui gpa
        $gpadryfilterHV = $gpadryfilterHV->where('nama_workcenter', 'HV Windling')
        ->whereBetween('deadline', $getDay)
        ->get();

        $dateStrings = $gpadryfilterHV->pluck('deadline');
        $woIds = $gpadryfilterHV->pluck('wo.id_wo');
        $coilHv = $gpadryfilterHV->pluck('wo.standardize_work.dry_cast_resin.coil_hv');
        $ketersediaanMPHV = $ketersediaanMPCoil_Making_HV;
        $namaMP = [];

        // Mendapatkan namaMP
        for ($i = 4; $i >= 0; $i--) {
            $namaMP_currentSkill = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Coil Making')
                ->where('proses', 'COIL HV')
                ->whereIn('tipe_proses', $coilHv)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB = [];
            foreach ($namaMP_currentSkill as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter',  ['HV Windling'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOB[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            if (!empty($namaMP_withDOB)) {
                usort($namaMP_withDOB, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB[0]['nama_mp'];
            }
            if (count($namaMP) >= $ketersediaanMPHV) {
                break;
            }
        }
        $namaMP = array_slice($namaMP, 0, ceil($ketersediaanMPHV));
        foreach ($woIds as $time => $wo) {
            $start = Carbon::parse($dateStrings[$time])->startOfDay();
            $hourHV = $gpadryfilterHV->pluck('wo.standardize_work.dry_cast_resin.hour_coil_hv', $wo)->sum();
            $qty = $gpadryfilterHV->pluck('qty_trafo', $wo)->sum();
            $remainingHours = $hourHV * $qty;
            if (isset($namaMP[$time]) && !empty($namaMP[$time])) {
                $nama = $namaMP[$time];
            } else {
                $nama = "tidak ada nama MP";
            }
            $currentDateHv = [];

            while ($remainingHours > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTime = $start->copy()->addHours(min(8, $remainingHours));
                $minhourday = min(8, $remainingHours);
                $existingData = ResultRekomendasi::where([
                    'end' => $endTime->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $nama,
                    'nama_workcenter' => 'HV Windling',
                    'nama_proses' => 'COIL HV',
                ])->exists();

                if (!$existingData) {
                    $currentDateHv[] = [
                        'end' => $endTime->format('Y-m-d'),
                        'hours' => $minhourday,
                        'wo_id' => $wo,
                        'nama_mp' => $nama,
                        'nama_workcenter' => 'HV Windling',
                        'nama_proses' => 'COIL HV',
                    ];
                }
                $start = $endTime->copy()->addSeconds(1);
                $remainingHours -= $minhourday;
                $start->addDay();
            }
            if (!empty($currentDateHv)) {
                ResultRekomendasi::insert($currentDateHv);
            }
            // $currentDate = [];
        }

        // proses pengambilan data nama MP pada workcenter Mould & Casting melalui gpa

        $gpadryfilterMoulding = $gpadryfilterMoulding->where('nama_workcenter', 'Moulding')
            ->whereBetween('deadline', $getDay)
            ->get();

        $dateStrings = $gpadryfilterMoulding->pluck('deadline');
        $woIds = $gpadryfilterMoulding->pluck('wo.id_wo');

        $hvmoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_moulding');
        $hvcasting = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_casting');
        $hvdemoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hv_demoulding');
        $lvbobbin = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.lv_bobbin');
        $lv_moulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.lv_moulding');
        $touch_up = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.touch_up');
        $ketersediaanMPMould = $ketersediaanMPMould_Casting;
        $namaMP = [];
        // Mendapatkan namaMP
        for ($i = 4; $i >= 0; $i--) {
            $namaMP_currentSkill_hvmoulding = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Mould & Casting')
                ->where('proses', 'HV MOULDING')
                ->whereIn('tipe_proses', $hvmoulding)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_hvmoulding = [];
            foreach ($namaMP_currentSkill_hvmoulding as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Moulding'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOB_hvmoulding[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            $namaMP_currentSkill_casting = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Mould & Casting')
                ->where('proses', 'HV CASTING')
                ->whereIn('tipe_proses',  $hvcasting)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_casting = [];
            foreach ($namaMP_currentSkill_casting as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Moulding'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOB_casting[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            $namaMP_currentSkill_demoulding = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Mould & Casting')
                ->where('proses', 'HV DEMOULDING')
                ->whereIn('tipe_proses',  $hvdemoulding)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_demoulding = [];
            foreach ($namaMP_currentSkill_demoulding as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Moulding'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOB_demoulding[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            $namaMP_currentSkill_bobbin = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Mould & Casting')
                ->where('proses', 'LV BOBBIN')
                ->whereIn('tipe_proses',  $lvbobbin)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_bobbin = [];
            foreach ($namaMP_currentSkill_bobbin as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Moulding'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOB_bobbin[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            $namaMP_currentSkill_lvmoulding = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Mould & Casting')
                ->where('proses', 'LV MOULDING')
                ->whereIn('tipe_proses', $lv_moulding)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_lvmoulding = [];
            foreach ($namaMP_currentSkill_lvmoulding as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Moulding'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOB_lvmoulding[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            $namaMP_currentSkill_touchup = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Mould & Casting')
                ->where('proses', 'TOUCH UP')
                ->whereIn('tipe_proses', $touch_up)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_touchup = [];
            foreach ($namaMP_currentSkill_touchup as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Moulding'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOB_touchup[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }

            if (!empty($namaMP_withDOB_hvmoulding)) {
                usort($namaMP_withDOB_hvmoulding, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_hvmoulding[0]['nama_mp'];
            }
            if (!empty($namaMP_withDOB_casting)) {
                usort($namaMP_withDOB_casting, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_casting[0]['nama_mp'];
            }
            if (!empty($namaMP_withDOB_demoulding)) {
                usort($namaMP_withDOB_demoulding, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_demoulding[0]['nama_mp'];
            }
            if (!empty($namaMP_withDOB_bobbin)) {
                usort($namaMP_withDOB_bobbin, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_bobbin[0]['nama_mp'];
            }
            if (!empty($namaMP_withDOB_hvmoulding)) {
                usort($namaMP_withDOB_hvmoulding, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_hvmoulding[0]['nama_mp'];
            }
            if (!empty($namaMP_withDOB_touchup)) {
                usort($namaMP_withDOB_touchup, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_touchup[0]['nama_mp'];
            }
            if (count($namaMP) >= $ketersediaanMPMould) {
                break;
            }
        }
        $namaMP = array_slice($namaMP, 0, ceil($ketersediaanMPMould));

        foreach ($woIds as $time => $wo) {
            $start = Carbon::parse($dateStrings[$time])->startOfDay();
            // proses HV MOULDING
            $hourMould = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hour_hv_moulding', $wo)->sum();
            $qty = $gpadryfilterMoulding->pluck('qty_trafo', $wo)->sum();
            $remainingHours = $hourMould * $qty;
            if (isset($namaMP[$time]) && !empty($namaMP[$time])) {
                $nama = $namaMP[$time];
            } else {
                $nama = "tidak ada nama MP";
            }
            $currentDate_HvDemoulding = [];

            while ($remainingHours > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTime = $start->copy()->addHours(min(8, $remainingHours));
                $minhourday = min(8, $remainingHours);
                $existingData = ResultRekomendasi::where([
                    'end' => $endTime->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $nama,
                    'nama_workcenter' => 'Moulding',
                    'nama_proses' => 'HV MOULDING',
                ])->exists();

                if (!$existingData) {
                    $currentDate_HvDemoulding[] = [
                        'end' => $endTime->format('Y-m-d'),
                        'hours' => $minhourday,
                        'wo_id' => $wo,
                        'nama_mp' => $nama,
                        'nama_workcenter' => 'Moulding',
                        'nama_proses' => 'HV MOULDING',
                    ];
                }
                $start = $endTime->copy()->addSeconds(1);
                $remainingHours -= $minhourday;
                $start->addDay();
            }
            if (!empty($currentDate_HvDemoulding)) {
                ResultRekomendasi::insert($currentDate_HvDemoulding);
            }
            // proses HV MOULDING
            $hourCasting = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hour_hv_casting', $wo)->sum();
            $qty = $gpadryfilterMoulding->pluck('qty_trafo', $wo)->sum();
            $remainingHours = $hourCasting * $qty;
            if (isset($namaMP[$time]) && !empty($namaMP[$time])) {
                $nama = $namaMP[$time];
            } else {
                $nama = "tidak ada nama MP";
            }
            $currentDate_HvCasting = [];

            while ($remainingHours > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTime = $start->copy()->addHours(min(8, $remainingHours));
                $minhourday = min(8, $remainingHours);
                $existingData = ResultRekomendasi::where([
                    'end' => $endTime->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $nama,
                    'nama_workcenter' => 'Moulding',
                    'nama_proses' => 'HV CASTING',
                ])->exists();

                if (!$existingData) {
                    $currentDate_HvCasting[] = [
                        'end' => $endTime->format('Y-m-d'),
                        'hours' => $minhourday,
                        'wo_id' => $wo,
                        'nama_mp' => $nama,
                        'nama_workcenter' => 'Moulding',
                        'nama_proses' => 'HV CASTING',
                    ];
                }
                $start = $endTime->copy()->addSeconds(1);
                $remainingHours -= $minhourday;
                $start->addDay();
            }
            if (!empty($currentDate_HvCasting)) {
                ResultRekomendasi::insert($currentDate_HvCasting);
            }
            $hourDemoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hour_hv_demoulding', $wo)->sum();
            $qty = $gpadryfilterMoulding->pluck('qty_trafo', $wo)->sum();
            $remainingHours = $hourDemoulding * $qty;
            if (isset($namaMP[$time]) && !empty($namaMP[$time])) {
                $nama = $namaMP[$time];
            } else {
                $nama = "tidak ada nama MP";
            }
            $currentDate_hvDemoudling = [];

            while ($remainingHours > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTime = $start->copy()->addHours(min(8, $remainingHours));
                $minhourday = min(8, $remainingHours);
                $existingData = ResultRekomendasi::where([
                    'end' => $endTime->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $nama,
                    'nama_workcenter' => 'Moulding',
                    'nama_proses' => 'HV DEMOULDING',
                ])->exists();

                if (!$existingData) {
                    $currentDate_hvDemoudling[] = [
                        'end' => $endTime->format('Y-m-d'),
                        'hours' => $minhourday,
                        'wo_id' => $wo,
                        'nama_mp' => $nama,
                        'nama_workcenter' => 'Moulding',
                        'nama_proses' => 'HV DEMOULDING',
                    ];
                }
                $start = $endTime->copy()->addSeconds(1);
                $remainingHours -= $minhourday;
                $start->addDay();
            }
            if (!empty($currentDate_hvDemoudling)) {
                ResultRekomendasi::insert($currentDate_hvDemoudling);
            }
            $hourLvbobbin = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hour_lv_bobbin', $wo)->sum();
            $qty = $gpadryfilterMoulding->pluck('qty_trafo', $wo)->sum();
            $remainingHours = $hourLvbobbin * $qty;
            if (isset($namaMP[$time]) && !empty($namaMP[$time])) {
                $nama = $namaMP[$time];
            } else {
                $nama = "tidak ada nama MP";
            }
            $currentDate_Lvbobin = [];

            while ($remainingHours > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTime = $start->copy()->addHours(min(8, $remainingHours));
                $minhourday = min(8, $remainingHours);
                $existingData = ResultRekomendasi::where([
                    'end' => $endTime->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $nama,
                    'nama_workcenter' => 'Moulding',
                    'nama_proses' => 'LV BOBBIN',
                ])->exists();

                if (!$existingData) {
                    $currentDate_Lvbobin[] = [
                        'end' => $endTime->format('Y-m-d'),
                        'hours' => $minhourday,
                        'wo_id' => $wo,
                        'nama_mp' => $nama,
                        'nama_workcenter' => 'Moulding',
                        'nama_proses' => 'LV BOBBIN',
                    ];
                }
                $start = $endTime->copy()->addSeconds(1);
                $remainingHours -= $minhourday;
                $start->addDay();
            }
            if (!empty($currentDate_Lvbobin)) {
                ResultRekomendasi::insert($currentDate_Lvbobin);
            }
            $hourLvmoulding = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hour_lv_moulding', $wo)->sum();
            $qty = $gpadryfilterMoulding->pluck('qty_trafo', $wo)->sum();
            $remainingHours = $hourLvmoulding * $qty;
            if (isset($namaMP[$time]) && !empty($namaMP[$time])) {
                $nama = $namaMP[$time];
            } else {
                $nama = "tidak ada nama MP";
            }
            $currentDate_lvMoulding = [];

            while ($remainingHours > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTime = $start->copy()->addHours(min(8, $remainingHours));
                $minhourday = min(8, $remainingHours);
                $existingData = ResultRekomendasi::where([
                    'end' => $endTime->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $nama,
                    'nama_workcenter' => 'Moulding',
                    'nama_proses' => 'LV MOULDING',
                ])->exists();

                if (!$existingData) {
                    $currentDate_lvMoulding[] = [
                        'end' => $endTime->format('Y-m-d'),
                        'hours' => $minhourday,
                        'wo_id' => $wo,
                        'nama_mp' => $nama,
                        'nama_workcenter' => 'Moulding',
                        'nama_proses' => 'LV MOULDING',
                    ];
                }
                $start = $endTime->copy()->addSeconds(1);
                $remainingHours -= $minhourday;
                $start->addDay();
            }
            if (!empty($currentDate_lvMoulding)) {
                ResultRekomendasi::insert($currentDate_lvMoulding);
            }
            $hourTouchup = $gpadryfilterMoulding->pluck('wo.standardize_work.dry_cast_resin.hour_touch_up', $wo)->sum();
            $qty = $gpadryfilterMoulding->pluck('qty_trafo', $wo)->sum();
            $remainingHours = $hourTouchup * $qty;
            if (isset($namaMP[$time]) && !empty($namaMP[$time])) {
                $nama = $namaMP[$time];
            } else {
                $nama = "tidak ada nama MP";
            }
            $currentDate_touch_up = [];

            while ($remainingHours > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTime = $start->copy()->addHours(min(8, $remainingHours));
                $minhourday = min(8, $remainingHours);
                $existingData = ResultRekomendasi::where([
                    'end' => $endTime->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $nama,
                    'nama_workcenter' => 'Moulding',
                    'nama_proses' => 'TOUCH UP',
                ])->exists();

                if (!$existingData) {
                    $currentDate_touch_up[] = [
                        'end' => $endTime->format('Y-m-d'),
                        'hours' => $minhourday,
                        'wo_id' => $wo,
                        'nama_mp' => $nama,
                        'nama_workcenter' => 'Moulding',
                        'nama_proses' => 'TOUCH UP',
                    ];
                }
                $start = $endTime->copy()->addSeconds(1);
                $remainingHours -= $minhourday;
                $start->addDay();
            }
            if (!empty($currentDate_touch_up)) {
                ResultRekomendasi::insert($currentDate_touch_up);
            }
        }

        // proses pengambilan data nama MP pada workcenter Susun Core melalui gpa

        $gpadryfilterCCASusun = $gpadryfilterCCASusun->where('nama_workcenter', 'Susun Core')
            ->whereBetween('deadline', $getDay)
            ->get();

        $dateStrings = $gpadryfilterCCASusun->pluck('deadline');
        $woIds = $gpadryfilterCCASusun->pluck('wo.id_wo');

        $susun_core = $gpadryfilterCCASusun->pluck('wo.standardize_work.dry_cast_resin.type_susun_core');
        $potong_isolasi_fiber = $gpadryfilterCCASusun->pluck('wo.standardize_work.dry_cast_resin.potong_isolasi_fiber');

        $ketersediaanMPSusun = $ketersediaanMPCCASusun;
        $namaMP = [];
        // Mendapatkan namaMP
        for ($i = 4; $i >= 0; $i--) {
            $namaMP_currentSkill_susun = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Core Coil Assembly')
                ->where('proses', 'TYPE SUSUN CORE')
                ->whereIn('tipe_proses', $susun_core)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_susun = [];
            foreach ($namaMP_currentSkill_susun as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Susun Core'])
                        ->first();

                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');

                        if ($tanggal_lahir) {
                            $namaMP_withDOB_susun[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            $namaMP_currentSkill_potongFiber = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Core Coil Assembly')
                ->where('proses', 'POTONG ISOLASI FIBER')
                ->whereIn('tipe_proses', $potong_isolasi_fiber)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_potongFiber = [];
            foreach ($namaMP_currentSkill_potongFiber as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Susun Core'])
                        ->first();

                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');

                        if ($tanggal_lahir) {
                            $namaMP_withDOB_potongFiber[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }

            if (!empty($namaMP_withDOB_susun)) {
                usort($namaMP_withDOB_susun, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_susun[0]['nama_mp'];
            }
            if (!empty($namaMP_withDOB_potongFiber)) {
                usort($namaMP_withDOB_potongFiber, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_potongFiber[0]['nama_mp'];
            }

            if (count($namaMP) >= $ketersediaanMPSusun) {
                break;
            }
        }
        $namaMP = array_slice($namaMP, 0, ceil($ketersediaanMPSusun));

        foreach ($woIds as $time => $wo) {
            $start = Carbon::parse($dateStrings[$time])->startOfDay();
            // proses susun core
            $hourSusun = $gpadryfilterCCASusun->pluck('wo.standardize_work.dry_cast_resin.hour_type_susun_core', $wo)->sum();
            $qty = $gpadryfilterCCASusun->pluck('qty_trafo', $wo)->sum();
            $remainingHours = $hourSusun * $qty;
            if (isset($namaMP[$time]) && !empty($namaMP[$time])) {
                $nama = $namaMP[$time];
            } else {
                $nama = "tidak ada nama MP";
            }
            $currentDate_susun = [];
            while ($remainingHours > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTime = $start->copy()->addHours(min(8, $remainingHours));
                $minhourday = min(8, $remainingHours);
                $existingData = ResultRekomendasi::where([
                    'end' => $endTime->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $nama,
                    'nama_workcenter' => 'Susun Core',
                    'nama_proses' => 'TYPE SUSUN CORE',
                ])->exists();

                if (!$existingData) {
                    $currentDate_susun[] = [
                        'end' => $endTime->format('Y-m-d'),
                        'hours' => $minhourday,
                        'wo_id' => $wo,
                        'nama_mp' => $nama,
                        'nama_workcenter' => 'Susun Core',
                        'nama_proses' => 'TYPE SUSUN CORE',
                    ];
                }
                $start = $endTime->copy()->addSeconds(1);
                $remainingHours -= $minhourday;
                $start->addDay();
            }
            if (!empty($currentDate_susun)) {
                ResultRekomendasi::insert($currentDate_susun);
            }

            // proses potong isolasi fiber
            $hourIsolasiFiber = $gpadryfilterCCASusun->pluck('wo.standardize_work.dry_cast_resin.hour_potong_isolasi_fiber', $wo)->sum();
            $qty = $gpadryfilterCCASusun->pluck('qty_trafo', $wo)->sum();
            $remainingHours = $hourIsolasiFiber * $qty;
            if (isset($namaMP[$time]) && !empty($namaMP[$time])) {
                $nama = $namaMP[$time];
            } else {
                $nama = "tidak ada nama MP";
            }
            $currentDate_isolasi_fiber = [];

            while ($remainingHours > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTime = $start->copy()->addHours(min(8, $remainingHours));
                $minhourday = min(8, $remainingHours);
                $existingData = ResultRekomendasi::where([
                    'end' => $endTime->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $nama,
                    'nama_workcenter' => 'Susun Core',
                    'nama_proses' => 'POTONG ISOLASI FIBER',
                ])->exists();

                if (!$existingData) {
                    $currentDate_isolasi_fiber[] = [
                        'end' => $endTime->format('Y-m-d'),
                        'hours' => $minhourday,
                        'wo_id' => $wo,
                        'nama_mp' => $nama,
                        'nama_workcenter' => 'Susun Core',
                        'nama_proses' => 'POTONG ISOLASI FIBER',
                    ];
                }
                $start = $endTime->copy()->addSeconds(1);
                $remainingHours -= $minhourday;
                $start->addDay();
            }
            if (!empty($currentDate_isolasi_fiber)) {
                ResultRekomendasi::insert($currentDate_isolasi_fiber);
            }
        }
        // proses pengambilan data nama MP pada workcenter Connect & Final Assembly melalui gpa

        $gpadryfilterCCAConect = $gpadryfilterCCAConect->where('nama_workcenter', 'Connection & Final Assembly')
            ->whereBetween('deadline', $getDay)
            ->get();
        $dateStrings = $gpadryfilterCCAConect->pluck('deadline');
        $woIds = $gpadryfilterCCAConect->pluck('wo.id_wo');

        $others = $gpadryfilterCCAConect->pluck('wo.standardize_work.dry_cast_resin.others');
        $ketersediaanMPConect = $ketersediaanMPCCAConect;
        $namaMP = [];
        // Mendapatkan namaMP
        for ($i = 4; $i >= 0; $i--) {
            $namaMP_currentSkill_others = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Core Coil Assembly')
                ->where('proses', 'OTHERS')
                ->whereIn('tipe_proses', $others)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();


            $namaMP_withDOB_others = [];
            foreach ($namaMP_currentSkill_others as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Connection & Final Assembly'])
                        ->first();

                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');

                        if ($tanggal_lahir) {
                            $namaMP_withDOB_others[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }

            if (!empty($namaMP_withDOB_others)) {
                usort($namaMP_withDOB_others, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });

                $namaMP[] = $namaMP_withDOB_others[0]['nama_mp'];
            }
            $namaMP = array_unique($namaMP);

            if (count($namaMP) >= $ketersediaanMPConect) {
                break;
            }
        }
        $namaMP = array_slice($namaMP, 0, ceil($ketersediaanMPConect));
        // dd($ketersediaanMPCCAConect);

        foreach ($woIds as $time => $wo) {
            $start = Carbon::parse($dateStrings[$time])->startOfDay();
            $hourConect = $gpadryfilterCCAConect->pluck('wo.standardize_work.dry_cast_resin.hour_hour_others', $wo)->sum();
            $qty = $gpadryfilterCCAConect->pluck('qty_trafo', $wo)->sum();
            $remainingHours = $hourConect * $qty;
            if (isset($namaMP[$time]) && !empty($namaMP[$time])) {
                $nama = $namaMP[$time];
            } else {
                $nama = "tidak ada nama MP";
            }
            $currentDateConnect = [];

            while ($remainingHours > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTime = $start->copy()->addHours(min(8, $remainingHours));
                $minhourday = min(8, $remainingHours);
                $existingData = ResultRekomendasi::where([
                    'end' => $endTime->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $nama,
                    'nama_workcenter' => 'Connection & Final Assembly',
                    'nama_proses' => 'connect',
                ])->exists();

                if (!$existingData) {
                    $currentDateConnect[] = [
                        'end' => $endTime->format('Y-m-d'),
                        'hours' => $minhourday,
                        'wo_id' => $wo,
                        'nama_mp' => $nama,
                        'nama_workcenter' => 'Connection & Final Assembly',
                        'nama_proses' => 'connect',
                    ];
                }
                $start = $endTime->copy()->addSeconds(1);
                $remainingHours -= $minhourday;
                $start->addDay();
            }
            if (!empty($currentDateConnect)) {
                ResultRekomendasi::insert($currentDateConnect);
            }
            $currentDate = [];
        }
        // proses pengambilan data nama MP pada workcenter Finishing melalui gpa

        $gpadryfilterCCAFinishing = $gpadryfilterCCAFinishing->where('nama_workcenter', 'Finishing')
            ->whereBetween('deadline', $getDay)
            ->get();

        $dateStrings = $gpadryfilterCCAFinishing->pluck('deadline');
        $woIds = $gpadryfilterCCAFinishing->pluck('wo.id_wo');

        $wiring = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.wiring');
        $instal_housing = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.instal_housing');
        $bongkar_housing = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.bongkar_housing');
        $pembuatan_cu_link = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.pembuatan_cu_link');
        $accesories = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.accesories');

        $ketersediaanMPFinishing = $ketersediaanMPCCAFinishing;
        $namaMP = [];
        // Mendapatkan namaMP
        for ($i = 4; $i >= 0; $i--) {
            $namaMP_currentSkill_wiring = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Core Coil Assembly')
                ->where('proses', 'WIRING')
                ->whereIn('tipe_proses', $wiring)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_wiring = [];
            foreach ($namaMP_currentSkill_wiring as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Finishing'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOB_wiring[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            $namaMP_currentSkill_instalHousing = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Core Coil Assembly')
                ->where('proses', 'INSTAL HOUSING')
                ->whereIn('tipe_proses', $instal_housing)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_instalHosing = [];
            foreach ($namaMP_currentSkill_instalHousing as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Finishing'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOB_instalHosing[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            $namaMP_currentSkill_bongkarHousing = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Core Coil Assembly')
                ->where('proses', 'BONGKAR HOUSING')
                ->whereIn('tipe_proses', $bongkar_housing)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_bongkarHosing = [];
            foreach ($namaMP_currentSkill_bongkarHousing as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Finishing'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOB_bongkarHosing[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            $namaMP_currentSkill_pembuatanCU = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Core Coil Assembly')
                ->where('proses', 'PEMBUATAN CU LINK')
                ->whereIn('tipe_proses', $pembuatan_cu_link)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_pembuatanCU = [];
            foreach ($namaMP_currentSkill_pembuatanCU as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Finishing'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOB_pembuatanCU[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            $namaMP_currentSkill_accesoris = $matrixSkil->where('production_line', 'Dry Resin')
                ->where('nama_workcenter', 'Core Coil Assembly')
                ->where('proses', 'ACCESORIES')
                ->whereIn('tipe_proses', $accesories)
                ->where('skill', $i)
                ->whereNotIn('man_power.nama', $namaMP)
                ->pluck('man_power.nama')->toArray();
            $namaMP_withDOB_accesoris = [];
            foreach ($namaMP_currentSkill_accesoris as $nama_mp) {
                if (!in_array($nama_mp, $namaMP)) {
                    $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                        ->whereNotIn('nama_workcenter', ['Finishing'])
                        ->first();
                    if (!$existingMP) {
                        $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                        if ($tanggal_lahir) {
                            $namaMP_withDOB_accesoris[] = [
                                'nama_mp' => $nama_mp,
                                'tanggal_lahir' => $tanggal_lahir
                            ];
                        }
                    }
                }
            }
            if (!empty($namaMP_withDOB_wiring)) {
                usort($namaMP_withDOB_wiring, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_wiring[0]['nama_mp'];
            }
            if (!empty($namaMP_withDOB_instalHosing)) {
                usort($namaMP_withDOB_instalHosing, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_instalHosing[0]['nama_mp'];
            }
            if (!empty($namaMP_withDOB_bongkarHosing)) {
                usort($namaMP_withDOB_bongkarHosing, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_bongkarHosing[0]['nama_mp'];
            }
            if (!empty($namaMP_withDOB_pembuatanCU)) {
                usort($namaMP_withDOB_pembuatanCU, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_pembuatanCU[0]['nama_mp'];
            }
            if (!empty($namaMP_withDOB_accesoris)) {
                usort($namaMP_withDOB_accesoris, function ($a, $b) {
                    return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                });
                $namaMP[] = $namaMP_withDOB_accesoris[0]['nama_mp'];
            }
            $namaMP = array_unique($namaMP);

            if (count($namaMP) >= $ketersediaanMPFinishing) {
                break;
            }
        }
        $namaMP = array_slice($namaMP, 0, ceil($ketersediaanMPFinishing));

        foreach ($woIds as $time => $wo) {
            $start = Carbon::parse($dateStrings[$time])->startOfDay();
            $hourFinishing = $gpadryfilterCCAFinishing->pluck('wo.standardize_work.dry_cast_resin.totalHour_Finishing', $wo)->sum();
            $qty = $gpadryfilterCCAFinishing->pluck('qty_trafo', $wo)->sum();
            $remainingHours = $hourFinishing * $qty;
            if (isset($namaMP[$time]) && !empty($namaMP[$time])) {
                $nama = $namaMP[$time];
            } else {
                $nama = "tidak ada nama MP";
            }
            $currentDate = [];

            while ($remainingHours > 0) {
                if ($start->isWeekend() || $holidayDates->contains($start)) {
                    $start->nextWeekday();
                    continue;
                }
                $endTime = $start->copy()->addHours(min(8, $remainingHours));
                $minhourday = min(8, $remainingHours);
                $existingData = ResultRekomendasi::where([
                    'end' => $endTime->format('Y-m-d'),
                    'wo_id' => $wo,
                    'nama_mp' => $nama,
                    'nama_workcenter' => 'Finishing',
                    'nama_proses' => 'Finishing CCA',
                ])->exists();

                if (!$existingData) {
                    $currentDate[] = [
                        'end' => $endTime->format('Y-m-d'),
                        'hours' => $minhourday,
                        'wo_id' => $wo,
                        'nama_mp' => $nama,
                        'nama_workcenter' => 'Finishing',
                        'nama_proses' => 'Finishing CCA',
                    ];
                }
                $start = $endTime->copy()->addSeconds(1);
                $remainingHours -= $minhourday;
                $start->addDay();
            }
            if (!empty($currentDate)) {
                ResultRekomendasi::insert($currentDate);
            }
            $currentDate = [];
        }
        switch ($selectedWorkcenter_rekomendasi) {
            case 1:
                $workcenterLabel = 'Coil Making LV';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'LV Windling')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
            case 2:
                $workcenterLabel = 'Coil Making HV';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'HV Windling')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
            case 3:
                $workcenterLabel = 'Mould & Casting';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'Moulding')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
            case 4:
                $workcenterLabel = 'Susun Core';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'Susun Core')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
            case 5:
                $workcenterLabel = 'Connection & Final Assembly';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'Connection & Final Assembly')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
            case 6:
                $workcenterLabel = 'Finishing';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'Finishing')
                    ->whereBetween('end', $getDay)
                    ->get();
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
            'manpower' => $matrixSkil,
            'hasil' => $hasil,
            'namaMP' => $namaMP,
            // 'hour' => $hour,
            // // 'newDates' => $newDates,
            'resultRekomendasi' => $resultRekomendasi,
        ];
        return view('produksi.resource_work_planning.DRY.rekomendasi', ['data' => $data]);
    }
}
