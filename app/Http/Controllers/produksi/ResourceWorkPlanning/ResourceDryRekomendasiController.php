<?php

namespace App\Http\Controllers\produksi\ResourceWorkPlanning;

use App\Http\Controllers\Controller;
use App\Models\planner\GPADry;
use App\Models\planner\Holiday;
use App\Models\produksi\CompatibilityMesin;
use App\Models\produksi\ManPower;
use App\Models\produksi\MatriksSkill;
use App\Models\produksi\ResultRekomendasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResourceDryRekomendasiController extends Controller
{
    public function checkAndRun(Request $request)
    {

        $selectedWorkcenter_rekomendasi = $request->input('Workcenter_rekomendasi', null);
        $selectedPeriode = $request->input('periodeDry', null);
        $selectedShift = $request->input('shiftDry', null);
        if ($selectedWorkcenter_rekomendasi === null || !in_array($selectedWorkcenter_rekomendasi, [1, 2, 3, 4, 5, 6, 7])) {
            $storedValue = $request->session()->get('selectedWorkcenter_rekomendasi');
            $selectedWorkcenter_rekomendasi = ($storedValue && in_array($storedValue, [1, 2, 3, 4, 5, 6, 7])) ? $storedValue : 1;
        }

        if ($selectedPeriode === null || !in_array($selectedPeriode, [1, 2, 3, 4])) {
            $storedPeriodeValue = $request->session()->get('selectedPeriodeDry');
            $selectedPeriode = ($storedPeriodeValue && in_array($storedPeriodeValue, [1, 2, 3, 4])) ? $storedPeriodeValue : 1;
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
                $hasil = ResultRekomendasi::where('nama_workcenter', 'Connect')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
            case 6:
                $workcenterLabel = 'Finishing';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'Finishing')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
            case 7:
                $workcenterLabel = 'QC';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'QC')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
        }

        $request->session()->put('selectedWorkcenter_rekomendasi', $selectedWorkcenter_rekomendasi);
        $request->session()->put('selectedPeriodeDry', $selectedPeriode);
        $request->session()->put('selectedShiftDry', $selectedShift);

        $startOfMonth = now()->subMonths()->startOfMonth();
        // Dapatkan tanggal akhir bulan ini
        $endOfMonth = now()->addMonth()->endOfMonth();

        // Lakukan pengecekan apakah ada data di tabel gpa_dry untuk dua bulan terakhir
        $dataExists = GpaDry::whereBetween('deadline', [$startOfMonth, $endOfMonth])->exists();
        $data = [
            'workcenterLabel' => $workcenterLabel,
            'getDay' => $getDay,
            'hasil' => $hasil,
        ];

        if (!$dataExists) {
            return view('produksi.resource_work_planning.DRY.rekomendasi', ['data' => $data]);
        }

        // Jika ada data yang memenuhi kriteria, lanjutkan menjalankan fungsi dryRekomendasi
        return $this->dryRekomendasi($request);
    }
    public function dryRekomendasi(Request $request)
    {
        $title1 = 'Dry - Rekomendasi';
        $matrixSkil = MatriksSkill::all();
        $mesins = CompatibilityMesin::all();
        $totalManPower = ManPower::count();
        $resultRekomendasi = ResultRekomendasi::all();

        $dataHoliday = Holiday::all();
        $holidayDates = $dataHoliday->pluck('date')->map(function ($date) {
            return Carbon::parse($date);
        });

        $selectedWorkcenter_rekomendasi = $request->input('Workcenter_rekomendasi', null);
        $selectedPeriode = $request->input('periodeDry', null);
        $selectedShift = $request->input('shiftDry', null);
        if ($selectedWorkcenter_rekomendasi === null || !in_array($selectedWorkcenter_rekomendasi, [1, 2, 3, 4, 5, 6, 7])) {
            $storedValue = $request->session()->get('selectedWorkcenter_rekomendasi');
            $selectedWorkcenter_rekomendasi = ($storedValue && in_array($storedValue, [1, 2, 3, 4, 5, 6, 7])) ? $storedValue : 1;
        }

        if ($selectedPeriode === null || !in_array($selectedPeriode, [1, 2, 3, 4])) {
            $storedPeriodeValue = $request->session()->get('selectedPeriodeDry');
            $selectedPeriode = ($storedPeriodeValue && in_array($storedPeriodeValue, [1, 2, 3, 4])) ? $storedPeriodeValue : 1;
        }

        // if ($selectedShift === null || !in_array($selectedShift, [1, 2, 3])) {
        //     $storedShiftValue = $request->session()->get('selectedShiftDry');
        //     $selectedShift = ($storedShiftValue && in_array($storedShiftValue, [1, 2, 3, 4])) ? $storedShiftValue : 1;
        // }
        // switch ($selectedShift) {
        //     case 1:
        //         $shift = 8;
        //         break;
        //     case 2:
        //         $shift = 16;
        //         break;
        //     case 3:
        //         $shift = 24;
        //         break;
        // }
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
        $gpadryfilterCCAConect = clone $gpadry;
        $gpadryfilterCCAFinishing = clone $gpadry;
        $gpadryfilterQc = clone $gpadry;
        switch ($selectedWorkcenter_rekomendasi) {
            case 1:
                // proses data untuk mendapatkan rekomendasi
                $woDryLV = $gpadryfilterLV->pluck('id_wo');
                $jumlahtotalHourCoil_Making_LV = $gpadryfilterLV->whereBetween('start_wc5', $getDay)
                    ->with(['mps2.standardize_work', 'mps2.standardize_work.dry_cast_resin', 'mps2.standardize_work.dry_non_resin'])
                    ->whereIn('id_wo', $woDryLV)
                    ->get()
                    ->sum(function ($item) {
                        $workData = $item->mps2->standardize_work->dry_cast_resin ?? $item->mps2->standardize_work->dry_non_resin;
                        if ($workData) {
                            $hourCoilmakingLV = $workData->totalHour_coil_makinglv ?? 0;
                            return $hourCoilmakingLV  * $item->qty_trafo;
                        } else {
                            return 0;
                        }
                    });
                $KebutuhanLV = $jumlahtotalHourCoil_Making_LV / (40  * 0.93);
                $selisihMPCoil_Making_LV = $KebutuhanLV - $totalManPower;
                if ($KebutuhanLV != 0) {
                    $presentaseKurangMPCoil_Making_HV = ($selisihMPCoil_Making_LV / $KebutuhanLV) * 100;
                } else {
                    $presentaseKurangMPCoil_Making_HV = 0;
                }
                $ketersediaanMPLV = $KebutuhanLV - ($KebutuhanLV * $presentaseKurangMPCoil_Making_HV) / 100;
                if ($KebutuhanLV <= $ketersediaanMPLV) {
                    $selisihMPCoil_Making_LV = 0;
                    $ketersediaanMPLV = $KebutuhanLV;
                }
                $gpadryfilterLV = $gpadryfilterLV->whereBetween('start_wc5', $getDay)
                    ->get();
                $dateStrings = $gpadryfilterLV->pluck('start_wc5');

                $woIds = $gpadryfilterLV->pluck('mps2.id_wo');
                $coilLv = $gpadryfilterLV->pluck('mps2.standardize_work.dry_cast_resin.coil_lv');
                $potong_leadwire = $gpadryfilterLV->pluck('mps2.standardize_work.dry_cast_resin.potong_leadwire');
                $potong_isolasi = $gpadryfilterLV->pluck('mps2.standardize_work.dry_cast_resin.potong_isolasi');

                $namaMPLV = [];

                $nama_ms_lv = [];
                $nama_ms_leadwire = [];
                $nama_ms_isolasi = [];

                // Mendapatkan namaMP
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkillLV = $matrixSkil->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Coil Making')
                        ->where('proses', 'COIL LV')
                        ->whereIn('tipe_proses', $coilLv)
                        ->where('skill', $i)
                        ->whereNotIn('man_power.nama', $namaMPLV)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOBlv = [];
                    foreach ($namaMP_currentSkillLV as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPLV)) {
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
                        ->whereNotIn('man_power.nama', $namaMPLV)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_leadwire = [];
                    foreach ($namaMP_currentSkill_leadwire as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPLV)) {
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
                        ->whereNotIn('man_power.nama', $namaMPLV)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB = [];
                    foreach ($namaMP_currentSkill_isolasi as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPLV)) {
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
                        $namaMPLV[] = $namaMP_withDOBlv[0]['nama_mp'];
                    }
                    if (!empty($namaMP_withDOB_leadwire)) {
                        usort($namaMP_withDOB_leadwire, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMPLV[] = $namaMP_withDOB_leadwire[0]['nama_mp'];
                    }
                    if (!empty($namaMP_withDOB_isolasi)) {
                        usort($namaMP_withDOB_isolasi, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMPLV[] = $namaMP_withDOB_isolasi[0]['nama_mp'];
                    }
                    $namaMPLV = array_unique($namaMPLV);
                    if (count($namaMPLV) >= $ketersediaanMPLV) {
                        break;
                    }
                }
                $namaMPLV = array_slice($namaMPLV, 0, ceil($ketersediaanMPLV));
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Coil Making')
                            ->where('proses', 'COIL LV')
                            ->whereIn('tipe_proses', $coilLv)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_lv = array_merge($nama_ms_lv, $getMesin);
                        if (count($nama_ms_lv) >= $ketersediaanMPLV) {
                            break;
                        }
                    }
                }
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Coil Making')
                            ->where('proses', 'POTONG LEAD WIRE')
                            ->whereIn('tipe_proses', $potong_leadwire)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_leadwire = array_merge($nama_ms_leadwire, $getMesin);
                        if (count($nama_ms_leadwire) >= $ketersediaanMPLV) {
                            break;
                        }
                    }
                }
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Coil Making')
                            ->where('proses', 'POTONG ISOLASI')
                            ->whereIn('tipe_proses', $potong_isolasi)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_isolasi = array_merge($nama_ms_isolasi, $getMesin);
                        if (count($nama_ms_isolasi) >= $ketersediaanMPLV) {
                            break;
                        }
                    }
                }
                $nama_ms_lv = array_slice($nama_ms_lv, 0, ceil($ketersediaanMPLV));
                $nama_ms_leadwire = array_slice($nama_ms_leadwire, 0, ceil($ketersediaanMPLV));
                $nama_ms_isolasi = array_slice($nama_ms_isolasi, 0, ceil($ketersediaanMPLV));
                // dd($nama_ms_isolasi);

                foreach ($woIds as $time => $wo) {
                    $start = Carbon::parse($dateStrings[$time])->startOfDay();

                    // Proses COIL LV
                    $hourLV = $gpadryfilterLV->pluck('mps2.standardize_work.dry_cast_resin.hour_coil_lv', $wo)->sum();
                    $qtyLV = $gpadryfilterLV->pluck('qty_trafo', $wo)->sum();
                    $remainingHoursLV = $hourLV * $qtyLV;
                    if (isset($namaMPLV[$time]) && !empty($namaMPLV[$time])) {
                        $nama = $namaMPLV[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_lv[$time]) && !empty($nama_ms_lv[$time])) {
                        $mesin = $nama_ms_lv[$time];
                    } else {
                        $mesin = "tidak Memakai Mesin";
                    }
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
                            'nama_mp' => $nama,
                            'nama_workcenter' => 'LV Windling',
                            'nama_proses' => 'COIL LV',
                            'mesin' => $mesin
                        ])->exists();

                        if (!$existingDataLV) {
                            $currentDateLV[] = [
                                'end' => $endTimeLV->format('Y-m-d'),
                                'hours' => $minhourdayLV,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'LV Windling',
                                'nama_proses' => 'COIL LV',
                                'mesin' => $mesin
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
                    $hourLeadWire = $gpadryfilterLV->pluck('mps2.standardize_work.dry_cast_resin.hour_potong_leadwire', $wo)->sum();
                    $qtyLeadWire = $gpadryfilterLV->pluck('qty_trafo', $wo)->sum();
                    $remainingHoursLeadWire = $hourLeadWire * $qtyLeadWire;
                    if (isset($namaMPLV[$time]) && !empty($namaMPLV[$time])) {
                        $nama = $namaMPLV[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_leadwire[$time]) && !empty($nama_ms_leadwire[$time])) {
                        $mesin = $nama_ms_leadwire[$time];
                    } else {
                        $mesin = "tidak Memakai Mesin";
                    }
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
                            'nama_mp' => $nama,
                            'nama_workcenter' => 'LV Windling',
                            'nama_proses' => 'POTONG LEAD WIRE',
                            'mesin' => $mesin
                        ])->exists();

                        if (!$existingDataLeadWire) {
                            $currentDateLeadWire[] = [
                                'end' => $endTimeLeadWire->format('Y-m-d'),
                                'hours' => $minhourdayLeadWire,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'LV Windling',
                                'nama_proses' => 'POTONG LEAD WIRE',
                                'mesin' => $mesin
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
                    $hourIsolasi = $gpadryfilterLV->pluck('mps2.standardize_work.dry_cast_resin.hour_potong_isolasi', $wo)->sum();
                    $qtyIsolasi = $gpadryfilterLV->pluck('qty_trafo', $wo)->sum();
                    $remainingHoursIsolasi = $hourIsolasi * $qtyIsolasi;
                    if (isset($namaMPLV[$time]) && !empty($namaMPLV[$time])) {
                        $nama = $namaMPLV[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_isolasi[$time]) && !empty($nama_ms_isolasi[$time])) {
                        $mesin = $nama_ms_isolasi[$time];
                    } else {
                        $mesin = "tidak Memakai Mesin";
                    }
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
                            'nama_mp' => $nama,
                            'nama_workcenter' => 'LV Windling',
                            'nama_proses' => 'POTONG ISOLASI',
                            'mesin' => $mesin
                        ])->exists();

                        if (!$existingDataIsolasi) {
                            $currentDateIsolasi[] = [
                                'end' => $endTimeIsolasi->format('Y-m-d'),
                                'hours' => $minhourdayIsolasi,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'LV Windling',
                                'nama_proses' => 'POTONG ISOLASI',
                                'mesin' => $mesin
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
                //hasil proses di simpan di table ResultRekomendasi
                $workcenterLabel = 'Coil Making LV';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'LV Windling')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
            case 2:
                // proses data
                $woDryHV = $gpadryfilterHV->pluck('id_wo');
                $jumlahtotalHourCoil_Making_HV =  $gpadryfilterHV->whereBetween('start_wc6', $getDay)
                    ->with(['mps2.standardize_work', 'mps2.standardize_work.dry_cast_resin', 'mps2.standardize_work.dry_non_resin'])
                    ->whereIn('id_wo', $woDryHV)
                    ->get()
                    ->sum(function ($item) {
                        $workData = $item->mps2->standardize_work->dry_cast_resin ?? $item->mps2->standardize_work->dry_non_resin;
                        if ($workData) {
                            $totalHourCoil_making_HV = $workData->hour_coil_hv ?? 0;
                            return $totalHourCoil_making_HV * $item->qty_trafo;
                        } else {
                            return 0;
                        }
                    });
                $KebutuhanHV = $jumlahtotalHourCoil_Making_HV / (40  * 0.93);
                $selisihMPCoil_Making_HV = $KebutuhanHV - $totalManPower;
                if ($KebutuhanHV != 0) {
                    $presentaseKurangMPCoil_Making_LV = ($selisihMPCoil_Making_HV / $KebutuhanHV) * 100;
                } else {
                    $presentaseKurangMPCoil_Making_LV = 0;
                }
                $ketersediaanMPCoil_Making_HV = $KebutuhanHV - ($KebutuhanHV * $presentaseKurangMPCoil_Making_LV) / 100;
                if ($KebutuhanHV <= $ketersediaanMPCoil_Making_HV) {
                    $selisihMPCoil_Making_HV = 0;
                    $ketersediaanMPCoil_Making_HV = $KebutuhanHV;
                }
                // proses pengambilan data nama MP pada workcenter coil making HV melalui gpa
                $gpadryfilterHV = $gpadryfilterHV->whereBetween('start_wc6', $getDay)
                    ->get();

                $dateStrings = $gpadryfilterHV->pluck('start_wc6');
                $woIds = $gpadryfilterHV->pluck('mps2.id_wo');
                $coilHv = $gpadryfilterHV->pluck('mps2.standardize_work.dry_cast_resin.coil_hv');
                $ketersediaanMPHV = $ketersediaanMPCoil_Making_HV;
                $namaMPHv = [];
                $nama_ms_hv = [];

                // Mendapatkan namaMP
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill = $matrixSkil->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Coil Making')
                        ->where('proses', 'COIL HV')
                        ->whereIn('tipe_proses', $coilHv)
                        ->where('skill', $i)
                        ->whereNotIn('man_power.nama', $namaMPHv)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB = [];
                    foreach ($namaMP_currentSkill as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPHv)) {
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
                        $namaMPHv[] = $namaMP_withDOB[0]['nama_mp'];
                    }
                    if (count($namaMPHv) >= $ketersediaanMPHV) {
                        break;
                    }
                }
                $namaMPHv = array_slice($namaMPHv, 0, ceil($ketersediaanMPHV));
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Coil Making')
                            ->where('proses', 'COIL HV')
                            ->whereIn('tipe_proses', $coilHv)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_hv = array_merge($nama_ms_hv, $getMesin);
                        if (count($nama_ms_hv) >= $ketersediaanMPHV) {
                            break;
                        }
                    }
                }
                $nama_ms_hv = array_slice($nama_ms_hv, 0, ceil($ketersediaanMPHV));
                foreach ($woIds as $time => $wo) {
                    $start = Carbon::parse($dateStrings[$time])->startOfDay();
                    $hourHV = $gpadryfilterHV->pluck('mps2.standardize_work.dry_cast_resin.hour_coil_hv', $wo)->sum();
                    $qty = $gpadryfilterHV->pluck('qty_trafo', $wo)->sum();
                    $remainingHours = $hourHV * $qty;
                    if (isset($namaMPHv[$time]) && !empty($namaMPHv[$time])) {
                        $nama = $namaMPHv[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_hv[$time]) && !empty($nama_ms_hv[$time])) {
                        $mesin = $nama_ms_hv[$time];
                    } else {
                        $mesin = "tidak Memakai Mesin";
                    }
                    // dd($mesin);

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
                            'mesin' => $mesin,
                        ])->exists();

                        if (!$existingData) {
                            $currentDateHv[] = [
                                'end' => $endTime->format('Y-m-d'),
                                'hours' => $minhourday,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'HV Windling',
                                'nama_proses' => 'COIL HV',
                                'mesin' => $mesin,
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

                // hasil data yang di simpan di result rekomendasi
                $workcenterLabel = 'Coil Making HV';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'HV Windling')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
            case 3:
                $woDryMould = $gpadryfilterMoulding->pluck('id_wo');
                $jumlahtotalHourMould_Casting = $gpadryfilterMoulding->whereBetween('start_wc9', $getDay)
                    ->with(['mps2.standardize_work', 'mps2.standardize_work.dry_cast_resin', 'mps2.standardize_work.dry_non_resin'])
                    ->whereIn('id_wo', $woDryMould)
                    ->get()
                    ->sum(function ($item) {
                        $workData = $item->mps2->standardize_work->dry_cast_resin ?? $item->mps2->standardize_work->dry_non_resin;
                        if ($workData) {
                            $totalHourMouldCasting = $workData->totalHour_MouldCasting ?? 0;
                            return $totalHourMouldCasting * $item->qty_trafo;
                        } else {
                            return 0;
                        }
                    });
                $KebutuhanMould = $jumlahtotalHourMould_Casting / (40  * 0.93);
                $selisihMPMould_Casting = $KebutuhanMould - $totalManPower;
                if ($KebutuhanMould != 0) {
                    $presentaseKurangMPMould_Casting = ($selisihMPMould_Casting / $KebutuhanMould) * 100;
                } else {
                    $presentaseKurangMPMould_Casting = 0;
                }
                $ketersediaanMPMould_Casting = $KebutuhanMould - ($KebutuhanMould * $presentaseKurangMPMould_Casting) / 100;
                if ($KebutuhanMould <= $ketersediaanMPMould_Casting) {
                    $selisihMPMould_Casting = 0;
                    $ketersediaanMPMould_Casting = $KebutuhanMould;
                }
                $gpadryfilterMoulding = $gpadryfilterMoulding->whereBetween('start_wc9', $getDay)
                    ->get();

                $dateStrings = $gpadryfilterMoulding->pluck('start_wc9');
                $woIds = $gpadryfilterMoulding->pluck('mps2.id_wo');

                $hvmoulding = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.hv_moulding');
                $hvcasting = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.hv_casting');
                $hvdemoulding = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.hv_demoulding');
                $lvbobbin = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.lv_bobbin');
                $lv_moulding = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.lv_moulding');
                $touch_up = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.touch_up');
                $oven = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.oven');
                $namaMPMould = [];

                $nama_ms_hv_mould = [];
                $nama_ms_hv_casting = [];
                $nama_ms_hv_demoulding = [];
                $nama_ms_lv_bobbin = [];
                $nama_ms_lv_moulding = [];
                $nama_ms_touch_up = [];
                $nama_ms_oven = [];
                // Mendapatkan namaMP
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill_hvmoulding = $matrixSkil->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Coil Making')
                        ->where('proses', 'HV MOULDING')
                        ->whereIn('tipe_proses', $hvmoulding)
                        ->where('skill', $i)
                        ->whereNotIn('man_power.nama', $namaMPMould)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_hvmoulding = [];
                    foreach ($namaMP_currentSkill_hvmoulding as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPMould)) {
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
                        ->where('nama_workcenter', 'Coil Making')
                        ->where('proses', 'HV CASTING')
                        ->whereIn('tipe_proses',  $hvcasting)
                        ->where('skill', $i)
                        ->whereNotIn('man_power.nama', $namaMPMould)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_casting = [];
                    foreach ($namaMP_currentSkill_casting as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPMould)) {
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
                        ->where('nama_workcenter', 'Coil Making')
                        ->where('proses', 'HV DEMOULDING')
                        ->whereIn('tipe_proses',  $hvdemoulding)
                        ->where('skill', $i)
                        ->whereNotIn('man_power.nama', $namaMPMould)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_demoulding = [];
                    foreach ($namaMP_currentSkill_demoulding as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPMould)) {
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
                        ->where('nama_workcenter', 'Coil Making')
                        ->where('proses', 'LV BOBBIN')
                        ->whereIn('tipe_proses',  $lvbobbin)
                        ->where('skill', $i)
                        ->whereNotIn('man_power.nama', $namaMPMould)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_bobbin = [];
                    foreach ($namaMP_currentSkill_bobbin as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPMould)) {
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
                        ->whereNotIn('man_power.nama', $namaMPMould)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_lvmoulding = [];
                    foreach ($namaMP_currentSkill_lvmoulding as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPMould)) {
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
                        ->whereNotIn('man_power.nama', $namaMPMould)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_touchup = [];
                    foreach ($namaMP_currentSkill_touchup as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPMould)) {
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
                    $namaMP_currentSkill_oven = $matrixSkil->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Mould & Casting')
                        ->where('proses', 'OVEN')
                        ->whereIn('tipe_proses', $oven)
                        ->where('skill', $i)
                        ->whereNotIn('man_power.nama', $namaMPMould)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_oven = [];
                    foreach ($namaMP_currentSkill_oven as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPMould)) {
                            $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                                ->whereNotIn('nama_workcenter', ['Moulding'])
                                ->first();
                            if (!$existingMP) {
                                $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');
                                if ($tanggal_lahir) {
                                    $namaMP_withDOB_oven[] = [
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
                        $namaMPMould[] = $namaMP_withDOB_hvmoulding[0]['nama_mp'];
                    }
                    if (!empty($namaMP_withDOB_casting)) {
                        usort($namaMP_withDOB_casting, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMPMould[] = $namaMP_withDOB_casting[0]['nama_mp'];
                    }
                    if (!empty($namaMP_withDOB_demoulding)) {
                        usort($namaMP_withDOB_demoulding, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMPMould[] = $namaMP_withDOB_demoulding[0]['nama_mp'];
                    }
                    if (!empty($namaMP_withDOB_bobbin)) {
                        usort($namaMP_withDOB_bobbin, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMPMould[] = $namaMP_withDOB_bobbin[0]['nama_mp'];
                    }
                    if (!empty($namaMP_withDOB_hvmoulding)) {
                        usort($namaMP_withDOB_hvmoulding, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMPMould[] = $namaMP_withDOB_hvmoulding[0]['nama_mp'];
                    }
                    if (!empty($namaMP_withDOB_touchup)) {
                        usort($namaMP_withDOB_touchup, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMPMould[] = $namaMP_withDOB_touchup[0]['nama_mp'];
                    }
                    if (!empty($namaMP_withDOB_oven)) {
                        usort($namaMP_withDOB_oven, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMPMould[] = $namaMP_withDOB_oven[0]['nama_mp'];
                    }
                    if (count($namaMPMould) >= $ketersediaanMPMould_Casting) {
                        break;
                    }
                }
                $namaMPMould = array_slice($namaMPMould, 0, ceil($ketersediaanMPMould_Casting));
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Mould & Casting')
                            ->where('proses', 'HV MOULDING')
                            ->whereIn('tipe_proses', $hvmoulding)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_hv_mould = array_merge($nama_ms_hv_mould, $getMesin);
                        if (count($nama_ms_hv_mould) >= $ketersediaanMPMould_Casting) {
                            break;
                        }
                    }
                }
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Mould & Casting')
                            ->where('proses', 'HV DEMOULDING')
                            ->whereIn('tipe_proses', $hvdemoulding)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_hv_demoulding = array_merge($nama_ms_hv_demoulding, $getMesin);
                        if (count($nama_ms_hv_demoulding) >= $ketersediaanMPMould_Casting) {
                            break;
                        }
                    }
                }
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Mould & Casting')
                            ->where('proses', 'HV CASTING')
                            ->whereIn('tipe_proses', $hvcasting)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_hv_casting = array_merge($nama_ms_hv_casting, $getMesin);
                        if (count($nama_ms_hv_casting) >= $ketersediaanMPMould_Casting) {
                            break;
                        }
                    }
                }
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Mould & Casting')
                            ->where('proses', 'HV MOULDING')
                            ->whereIn('tipe_proses', $lv_moulding)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_lv_moulding = array_merge($nama_ms_lv_moulding, $getMesin);
                        if (count($nama_ms_lv_moulding) >= $ketersediaanMPMould_Casting) {
                            break;
                        }
                    }
                }
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Mould & Casting')
                            ->where('proses', 'LV BOBBIN')
                            ->whereIn('tipe_proses', $lvbobbin)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_lv_bobbin = array_merge($nama_ms_lv_bobbin, $getMesin);
                        if (count($nama_ms_lv_bobbin) >= $ketersediaanMPMould_Casting) {
                            break;
                        }
                    }
                }
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Mould & Casting')
                            ->where('proses', 'TOUCH UP')
                            ->whereIn('tipe_proses', $touch_up)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_touch_up = array_merge($nama_ms_touch_up, $getMesin);
                        if (count($nama_ms_touch_up) >= $ketersediaanMPMould_Casting) {
                            break;
                        }
                    }
                }
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Mould & Casting')
                            ->where('proses', 'OVEN')
                            ->whereIn('tipe_proses', $oven)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_oven = array_merge($nama_ms_oven, $getMesin);
                        if (count($nama_ms_oven) >= $ketersediaanMPMould_Casting) {
                            break;
                        }
                    }
                }
                $nama_ms_hv_mould = array_slice($nama_ms_hv_mould, 0, ceil($ketersediaanMPMould_Casting));
                $nama_ms_hv_casting = array_slice($nama_ms_hv_casting, 0, ceil($ketersediaanMPMould_Casting));
                $nama_ms_hv_demoulding = array_slice($nama_ms_hv_demoulding, 0, ceil($ketersediaanMPMould_Casting));
                $nama_ms_lv_bobbin = array_slice($nama_ms_lv_bobbin, 0, ceil($ketersediaanMPMould_Casting));
                $nama_ms_lv_moulding = array_slice($nama_ms_lv_moulding, 0, ceil($ketersediaanMPMould_Casting));
                $nama_ms_touch_up = array_slice($nama_ms_touch_up, 0, ceil($ketersediaanMPMould_Casting));
                $nama_ms_oven = array_slice($nama_ms_oven, 0, ceil($ketersediaanMPMould_Casting));

                // dd($nama_ms);

                foreach ($woIds as $time => $wo) {
                    $start = Carbon::parse($dateStrings[$time])->startOfDay();
                    // proses HV MOULDING
                    $hourMould = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.hour_hv_moulding', $wo)->sum();
                    $qty = $gpadryfilterMoulding->pluck('qty_trafo', $wo)->sum();
                    $remainingHours = $hourMould * $qty;
                    if (isset($namaMPMould[$time]) && !empty($namaMPMould[$time])) {
                        $nama = $namaMPMould[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_hv_moud[$time]) && !empty($nama_ms_hv_moud[$time])) {
                        $mesin = $nama_ms_hv_moud[$time];
                    } else {
                        $mesin = "tidak Memakai Mesin";
                    }
                    // $mesin = $nama_ms[$time];
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
                            'mesin' => $mesin
                        ])->exists();

                        if (!$existingData) {
                            $currentDate_HvDemoulding[] = [
                                'end' => $endTime->format('Y-m-d'),
                                'hours' => $minhourday,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'Moulding',
                                'nama_proses' => 'HV MOULDING',
                                'mesin' => $mesin
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
                    $hourCasting = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.hour_hv_casting', $wo)->sum();
                    $qty = $gpadryfilterMoulding->pluck('qty_trafo', $wo)->sum();
                    $remainingHours = $hourCasting * $qty;
                    if (isset($namaMPMould[$time]) && !empty($namaMPMould[$time])) {
                        $nama = $namaMPMould[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_hv_casting[$time]) && !empty($nama_ms_hv_casting[$time])) {
                        $mesin = $nama_ms_hv_casting[$time];
                    } else {
                        $mesin = "tidak Memakai Mesin";
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
                            'mesin' => $mesin
                        ])->exists();

                        if (!$existingData) {
                            $currentDate_HvCasting[] = [
                                'end' => $endTime->format('Y-m-d'),
                                'hours' => $minhourday,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'Moulding',
                                'nama_proses' => 'HV CASTING',
                                'mesin' => $mesin
                            ];
                        }
                        $start = $endTime->copy()->addSeconds(1);
                        $remainingHours -= $minhourday;
                        $start->addDay();
                    }
                    if (!empty($currentDate_HvCasting)) {
                        ResultRekomendasi::insert($currentDate_HvCasting);
                    }
                    $hourDemoulding = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.hour_hv_demoulding', $wo)->sum();
                    $qty = $gpadryfilterMoulding->pluck('qty_trafo', $wo)->sum();
                    $remainingHours = $hourDemoulding * $qty;
                    if (isset($namaMPMould[$time]) && !empty($namaMPMould[$time])) {
                        $nama = $namaMPMould[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_hv_demoulding[$time]) && !empty($nama_ms_hv_demoulding[$time])) {
                        $mesin = $nama_ms_hv_demoulding[$time];
                    } else {
                        $mesin = "tidak Memakai Mesin";
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
                            'mesin' => $mesin
                        ])->exists();

                        if (!$existingData) {
                            $currentDate_hvDemoudling[] = [
                                'end' => $endTime->format('Y-m-d'),
                                'hours' => $minhourday,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'Moulding',
                                'nama_proses' => 'HV DEMOULDING',
                                'mesin' => $mesin
                            ];
                        }
                        $start = $endTime->copy()->addSeconds(1);
                        $remainingHours -= $minhourday;
                        $start->addDay();
                    }
                    if (!empty($currentDate_hvDemoudling)) {
                        ResultRekomendasi::insert($currentDate_hvDemoudling);
                    }
                    $hourLvbobbin = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.hour_lv_bobbin', $wo)->sum();
                    $qty = $gpadryfilterMoulding->pluck('qty_trafo', $wo)->sum();
                    $remainingHours = $hourLvbobbin * $qty;
                    if (isset($namaMPMould[$time]) && !empty($namaMPMould[$time])) {
                        $nama = $namaMPMould[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_lv_bobbin[$time]) && !empty($nama_ms_lv_bobbin[$time])) {
                        $mesin = $nama_ms_lv_bobbin[$time];
                    } else {
                        $mesin = "tidak Memakai Mesin";
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
                            'mesin' => $mesin
                        ])->exists();

                        if (!$existingData) {
                            $currentDate_Lvbobin[] = [
                                'end' => $endTime->format('Y-m-d'),
                                'hours' => $minhourday,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'Moulding',
                                'nama_proses' => 'LV BOBBIN',
                                'mesin' => $mesin
                            ];
                        }
                        $start = $endTime->copy()->addSeconds(1);
                        $remainingHours -= $minhourday;
                        $start->addDay();
                    }
                    if (!empty($currentDate_Lvbobin)) {
                        ResultRekomendasi::insert($currentDate_Lvbobin);
                    }
                    $hourLvmoulding = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.hour_lv_moulding', $wo)->sum();
                    $qty = $gpadryfilterMoulding->pluck('qty_trafo', $wo)->sum();
                    $remainingHours = $hourLvmoulding * $qty;
                    if (isset($namaMPMould[$time]) && !empty($namaMPMould[$time])) {
                        $nama = $namaMPMould[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_lv_moulding[$time]) && !empty($nama_ms_lv_moulding[$time])) {
                        $mesin = $nama_ms_lv_moulding[$time];
                    } else {
                        $mesin = "tidak Memakai Mesin";
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
                            'mesin' => $mesin
                        ])->exists();

                        if (!$existingData) {
                            $currentDate_lvMoulding[] = [
                                'end' => $endTime->format('Y-m-d'),
                                'hours' => $minhourday,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'Moulding',
                                'nama_proses' => 'LV MOULDING',
                                'mesin' => $mesin
                            ];
                        }
                        $start = $endTime->copy()->addSeconds(1);
                        $remainingHours -= $minhourday;
                        $start->addDay();
                    }
                    if (!empty($currentDate_lvMoulding)) {
                        ResultRekomendasi::insert($currentDate_lvMoulding);
                    }
                    $hourTouchup = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.hour_touch_up', $wo)->sum();
                    $qty = $gpadryfilterMoulding->pluck('qty_trafo', $wo)->sum();
                    $remainingHours = $hourTouchup * $qty;
                    if (isset($namaMPMould[$time]) && !empty($namaMPMould[$time])) {
                        $nama = $namaMPMould[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_touch_up[$time]) && !empty($nama_ms_touch_up[$time])) {
                        $mesin = $nama_ms_touch_up[$time];
                    } else {
                        $mesin = "tidak Memakai Mesin";
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
                            'mesin' => $mesin
                        ])->exists();

                        if (!$existingData) {
                            $currentDate_touch_up[] = [
                                'end' => $endTime->format('Y-m-d'),
                                'hours' => $minhourday,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'Moulding',
                                'nama_proses' => 'TOUCH UP',
                                'mesin' => $mesin
                            ];
                        }
                        $start = $endTime->copy()->addSeconds(1);
                        $remainingHours -= $minhourday;
                        $start->addDay();
                    }
                    if (!empty($currentDate_touch_up)) {
                        ResultRekomendasi::insert($currentDate_touch_up);
                    }
                    $hourOven = $gpadryfilterMoulding->pluck('mps2.standardize_work.dry_cast_resin.hour_oven', $wo)->sum();
                    $qty = $gpadryfilterMoulding->pluck('qty_trafo', $wo)->sum();
                    $remainingHours = $hourOven * $qty;
                    if (isset($namaMPMould[$time]) && !empty($namaMPMould[$time])) {
                        $nama = $namaMPMould[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_oven[$time]) && !empty($nama_ms_oven[$time])) {
                        $mesin = $nama_ms_oven[$time];
                    } else {
                        $mesin = "tidak Memakai Mesin";
                    }
                    $currentDate_oven = [];

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
                            'nama_proses' => 'OVEN',
                            'mesin' => $mesin
                        ])->exists();

                        if (!$existingData) {
                            $currentDate_oven[] = [
                                'end' => $endTime->format('Y-m-d'),
                                'hours' => $minhourday,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'Moulding',
                                'nama_proses' => 'OVEN',
                                'mesin' => $mesin
                            ];
                        }
                        $start = $endTime->copy()->addSeconds(1);
                        $remainingHours -= $minhourday;
                        $start->addDay();
                    }
                    if (!empty($currentDate_oven)) {
                        ResultRekomendasi::insert($currentDate_oven);
                    }
                }
                $workcenterLabel = 'Mould & Casting';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'Moulding')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
            case 4:
                $woDrySusun = $gpadryfilterCCASusun->pluck('id_wo');
                $jumlahtotalHourCCASusun = $gpadryfilterCCASusun->whereBetween('start_wc10', $getDay)
                    ->with(['mps2.standardize_work', 'mps2.standardize_work.dry_cast_resin', 'mps2.standardize_work.dry_non_resin'])
                    ->whereIn('id_wo', $woDrySusun)
                    ->get()
                    ->sum(function ($item) {
                        $workData = $item->mps2->standardize_work->dry_cast_resin ?? $item->mps2->standardize_work->dry_non_resin;
                        if ($workData) {
                            $hour_type_susun_core = $workData->totalHour_SusunCore ?? 0;
                            return $hour_type_susun_core * $item->qty_trafo;
                        } else {
                            return 0;
                        }
                    });
                $KebutuhanSusun = $jumlahtotalHourCCASusun / (40  * 0.93);
                $selisihMPCCASusun = $KebutuhanSusun - $totalManPower;
                if ($KebutuhanSusun != 0) {
                    $presentaseKurangMPCCASusun = ($selisihMPCCASusun / $KebutuhanSusun) * 100;
                } else {
                    $presentaseKurangMPCCASusun = 0;
                }
                $ketersediaanMPCCASusun = $KebutuhanSusun - ($KebutuhanSusun * $presentaseKurangMPCCASusun) / 100;

                if ($KebutuhanSusun <= $ketersediaanMPCCASusun) {
                    $selisihMPCCASusun = 0;
                    $ketersediaanMPCCASusun = $KebutuhanSusun;
                }
                // proses pengambilan data nama MP pada workcenter Susun Core melalui gpa

                $gpadryfilterCCASusun = $gpadryfilterCCASusun->whereBetween('start_wc10', $getDay)
                    ->get();

                $dateStrings = $gpadryfilterCCASusun->pluck('start_wc10');
                $woIds = $gpadryfilterCCASusun->pluck('mps2.id_wo');

                $susun_core = $gpadryfilterCCASusun->pluck('mps2.standardize_work.dry_cast_resin.type_susun_core');
                $potong_isolasi_fiber = $gpadryfilterCCASusun->pluck('mps2.standardize_work.dry_cast_resin.potong_isolasi_fiber');

                $namaMPsusun = [];
                $nama_ms_susun = [];
                $nama_ms_potong_fiber = [];
                // Mendapatkan namaMP
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill_susun = $matrixSkil->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Core Coil Assembly')
                        ->where('proses', 'TYPE SUSUN CORE')
                        ->whereIn('tipe_proses', $susun_core)
                        ->where('skill', $i)
                        ->whereNotIn('man_power.nama', $namaMPsusun)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_susun = [];
                    foreach ($namaMP_currentSkill_susun as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPsusun)) {
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
                        ->whereNotIn('man_power.nama', $namaMPsusun)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_potongFiber = [];
                    foreach ($namaMP_currentSkill_potongFiber as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPsusun)) {
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
                        $namaMPsusun[] = $namaMP_withDOB_susun[0]['nama_mp'];
                    }
                    if (!empty($namaMP_withDOB_potongFiber)) {
                        usort($namaMP_withDOB_potongFiber, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMPsusun[] = $namaMP_withDOB_potongFiber[0]['nama_mp'];
                    }

                    if (count($namaMPsusun) >= $ketersediaanMPCCASusun) {
                        break;
                    }
                }
                $namaMPsusun = array_slice($namaMPsusun, 0, ceil($ketersediaanMPCCASusun));
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Core Coil Assembly')
                            ->where('proses', 'TYPE SUSUN CORE')
                            ->whereIn('tipe_proses', $susun_core)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_susun = array_merge($nama_ms_susun, $getMesin);
                        if (count($nama_ms_susun) >= $ketersediaanMPCCASusun) {
                            break;
                        }
                    }
                }
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Core Coil Assembly')
                            ->where('proses', 'POTONG ISOLASI FIBER')
                            ->whereIn('tipe_proses', $potong_isolasi_fiber)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_potong_fiber = array_merge($nama_ms_potong_fiber, $getMesin);
                        if (count($nama_ms_potong_fiber) >= $ketersediaanMPCCASusun) {
                            break;
                        }
                    }
                }
                $nama_ms_susun = array_slice($nama_ms_susun, 0, ceil($ketersediaanMPCCASusun));
                $nama_ms_potong_fiber = array_slice($nama_ms_potong_fiber, 0, ceil($ketersediaanMPCCASusun));
                // dd($nama_ms);

                foreach ($woIds as $time => $wo) {
                    $start = Carbon::parse($dateStrings[$time])->startOfDay();
                    // proses susun core
                    $hourSusun = $gpadryfilterCCASusun->pluck('mps2.standardize_work.dry_cast_resin.hour_type_susun_core', $wo)->sum();
                    $qty = $gpadryfilterCCASusun->pluck('qty_trafo', $wo)->sum();
                    $remainingHours = $hourSusun * $qty;
                    if (isset($namaMPsusun[$time]) && !empty($namaMPsusun[$time])) {
                        $nama = $namaMPsusun[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_susun[$time]) && !empty($nama_ms_susun[$time])) {
                        $mesin = $nama_ms_susun[$time];
                    } else {
                        $mesin = "tidak ada mesin";
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
                            'nama_proses' => 'SUSUN CORE',
                            'mesin' => $mesin,
                        ])->exists();

                        if (!$existingData) {
                            $currentDate_susun[] = [
                                'end' => $endTime->format('Y-m-d'),
                                'hours' => $minhourday,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'Susun Core',
                                'nama_proses' => 'SUSUN CORE',
                                'mesin' => $mesin,

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
                    $hourIsolasiFiber = $gpadryfilterCCASusun->pluck('mps2.standardize_work.dry_cast_resin.hour_potong_isolasi_fiber', $wo)->sum();
                    $qty = $gpadryfilterCCASusun->pluck('qty_trafo', $wo)->sum();
                    $remainingHours = $hourIsolasiFiber * $qty;
                    if (isset($namaMPsusun[$time]) && !empty($namaMPsusun[$time])) {
                        $nama = $namaMPsusun[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_potong_fiber[$time]) && !empty($nama_ms_potong_fiber[$time])) {
                        $mesin = $nama_ms_potong_fiber[$time];
                    } else {
                        $mesin = "tidak ada mesin";
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
                            'mesin' => $mesin
                        ])->exists();

                        if (!$existingData) {
                            $currentDate_isolasi_fiber[] = [
                                'end' => $endTime->format('Y-m-d'),
                                'hours' => $minhourday,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'Susun Core',
                                'nama_proses' => 'POTONG ISOLASI FIBER',
                                'mesin' => $mesin
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
                $workcenterLabel = 'Susun Core';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'Susun Core')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
            case 5:
                $woDryConect = $gpadryfilterCCAConect->pluck('id_wo');
                $jumlahtotalHourCCAConect = $gpadryfilterCCAConect->whereBetween('start_wc12', $getDay)
                    ->with(['mps2.standardize_work', 'mps2.standardize_work.dry_cast_resin', 'mps2.standardize_work.dry_non_resin'])
                    ->whereIn('id_wo', $woDryConect)
                    ->get()
                    ->sum(function ($item) {
                        $workData = $item->mps2->standardize_work->dry_cast_resin ?? $item->mps2->standardize_work->dry_non_resin;
                        if ($workData) {
                            $totalHour_Connection_Final_Assembly = $workData->totalHour_Connection_Final_Assembly ?? 0;
                            return $totalHour_Connection_Final_Assembly * $item->qty_trafo;
                        } else {
                            return 0;
                        }
                    });

                $KebutuhanConect = $jumlahtotalHourCCAConect / (40  * 0.93);
                $selisihMPCCAConect = $KebutuhanConect - $totalManPower;
                if ($KebutuhanConect != 0) {
                    $presentaseKurangMPCCAConect = ($selisihMPCCAConect / $KebutuhanConect) * 100;
                } else {
                    $presentaseKurangMPCCAConect = 0;
                }
                $ketersediaanMPCCAConect = $KebutuhanConect - ($KebutuhanConect * $presentaseKurangMPCCAConect) / 100;
                if ($KebutuhanConect <= $ketersediaanMPCCAConect) {
                    $selisihMPCCAConect = 0;
                    $ketersediaanMPCCAConect = $KebutuhanConect;
                }
                $gpadryfilterCCAConect = $gpadryfilterCCAConect->whereBetween('start_wc12', $getDay)
                    ->get();

                $dateStrings = $gpadryfilterCCAConect->pluck('start_wc12');
                $woIds = $gpadryfilterCCAConect->pluck('mps2.id_wo');

                $conect = $gpadryfilterCCAConect->pluck('mps2.standardize_work.dry_cast_resin.others');
                $namaMP_conect = [];
                $nama_ms_conect = [];

                // Mendapatkan namaMP_conect
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill_conect = $matrixSkil->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Core Coil Assembly')
                        ->where('proses', 'OTHERS')
                        ->whereIn('tipe_proses', $conect)
                        ->where('skill', $i)
                        ->whereNotIn('man_power.nama', $namaMP_conect)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_conect = [];
                    foreach ($namaMP_currentSkill_conect as $nama_mp) {
                        if (!in_array($nama_mp, $namaMP_conect)) {
                            $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                                ->whereNotIn('nama_workcenter', ['Connection & Final Assembly'])
                                ->first();

                            if (!$existingMP) {
                                $tanggal_lahir = ManPower::where('nama', $nama_mp)->value('tanggal_lahir');

                                if ($tanggal_lahir) {
                                    $namaMP_withDOB_conect[] = [
                                        'nama_mp' => $nama_mp,
                                        'tanggal_lahir' => $tanggal_lahir
                                    ];
                                }
                            }
                        }
                    }


                    if (!empty($namaMP_withDOB_conect)) {
                        usort($namaMP_withDOB_conect, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMP_conect[] = $namaMP_withDOB_conect[0]['nama_mp'];
                    }


                    if (count($namaMP_conect) >= $ketersediaanMPCCAConect) {
                        break;
                    }
                }
                $namaMP_conect = array_slice($namaMP_conect, 0, ceil($ketersediaanMPCCAConect));
                dd($namaMP_conect);
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Core Coil Assembly')
                            ->where('proses', 'OTHERS')
                            ->whereIn('tipe_proses', $conect)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_conect = array_merge($nama_ms_conect, $getMesin);
                        if (count($nama_ms_conect) >= $ketersediaanMPCCAConect) {
                            break;
                        }
                    }
                }

                $nama_ms_conect = array_slice($nama_ms_conect, 0, ceil($ketersediaanMPCCAConect));

                foreach ($woIds as $time => $wo) {
                    $start = Carbon::parse($dateStrings[$time])->startOfDay();
                    $hourConect = $gpadryfilterCCAConect->pluck('mps2.standardize_work.dry_cast_resin.hour_others', $wo)->sum();
                    $qty = $gpadryfilterCCAConect->pluck('qty_trafo', $wo)->sum();
                    $remainingHours = $hourConect * $qty;
                    if (isset($namaMP_conect[$time]) && !empty($namaMP_conect[$time])) {
                        $nama = $namaMP_conect[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_conect[$time]) && !empty($nama_ms_conect[$time])) {
                        $mesin = $nama_ms_conect[$time];
                    } else {
                        $mesin = "tidak ada mesin";
                    }
                    $currentDate_conect = [];

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
                            'nama_workcenter' => 'Connect',
                            'nama_proses' => 'Connect',
                            'mesin' => $mesin,
                        ])->exists();

                        if (!$existingData) {
                            $currentDate_conect[] = [
                                'end' => $endTime->format('Y-m-d'),
                                'hours' => $minhourday,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'Connect',
                                'nama_proses' => 'Connect',
                                'mesin' => $mesin,

                            ];
                        }
                        $start = $endTime->copy()->addSeconds(1);
                        $remainingHours -= $minhourday;
                        $start->addDay();
                    }
                    if (!empty($currentDate_conect)) {
                        ResultRekomendasi::insert($currentDate_conect);
                    }
                }


                $workcenterLabel = 'Connection & Final Assembly';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'Connect')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
            case 6:
                $woDryFinishing = $gpadryfilterCCAFinishing->pluck('id_wo');
                $jumlahtotalHourCCAFinishing = $gpadryfilterCCAFinishing->whereBetween('start_wc13', $getDay)
                    ->with(['mps2.standardize_work', 'mps2.standardize_work.dry_cast_resin', 'mps2.standardize_work.dry_non_resin'])
                    ->whereIn('id_wo', $woDryFinishing)
                    ->get()
                    ->sum(function ($item) {
                        $workData = $item->mps2->standardize_work->dry_cast_resin ?? $item->mps2->standardize_work->dry_non_resin;
                        if ($workData) {
                            $totalHourFinishing = $workData->totalHour_Finishing ?? 0;
                            return $totalHourFinishing  * $item->qty_trafo;
                        } else {
                            return 0;
                        }
                    });
                $KebutuhanFinishing = $jumlahtotalHourCCAFinishing / (40  * 0.93);
                $selisihMPCCAFinishing = $KebutuhanFinishing - $totalManPower;
                if ($KebutuhanFinishing != 0) {
                    $presentaseKurangMPCCAFinishing = ($selisihMPCCAFinishing / $KebutuhanFinishing) * 100;
                } else {
                    $presentaseKurangMPCCAFinishing = 0;
                }
                $ketersediaanMPCCAFinishing = $KebutuhanFinishing - ($KebutuhanFinishing * $presentaseKurangMPCCAFinishing) / 100;
                if ($KebutuhanFinishing <= $ketersediaanMPCCAFinishing) {
                    $selisihMPCCAFinishing = 0;
                    $ketersediaanMPCCAFinishing = $KebutuhanFinishing;
                }
                $gpadryfilterCCAFinishing = $gpadryfilterCCAFinishing->whereBetween('start_wc13', $getDay)
                    ->get();

                $dateStrings = $gpadryfilterCCAFinishing->pluck('start_wc13');
                $woIds = $gpadryfilterCCAFinishing->pluck('mps2.id_wo');

                $wiring = $gpadryfilterCCAFinishing->pluck('mps2.standardize_work.dry_cast_resin.wiring');
                $instal_housing = $gpadryfilterCCAFinishing->pluck('mps2.standardize_work.dry_cast_resin.instal_housing');
                $bongkar_housing = $gpadryfilterCCAFinishing->pluck('mps2.standardize_work.dry_cast_resin.bongkar_housing');
                $pembuatan_cu_link = $gpadryfilterCCAFinishing->pluck('mps2.standardize_work.dry_cast_resin.pembuatan_cu_link');
                $accesories = $gpadryfilterCCAFinishing->pluck('mps2.standardize_work.dry_cast_resin.accesories');
                $namaMPFinishing = [];

                $nama_ms_wiring = [];
                $nama_ms_instal_housing = [];
                $nama_ms_bongkar_housing = [];
                $nama_ms_wiring_cu_link = [];
                $nama_ms_accessories = [];
                // Mendapatkan namaMP
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill_wiring = $matrixSkil->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Core Coil Assembly')
                        ->where('proses', 'WIRING')
                        ->whereIn('tipe_proses', $wiring)
                        ->where('skill', $i)
                        ->whereNotIn('man_power.nama', $namaMPFinishing)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_wiring = [];
                    foreach ($namaMP_currentSkill_wiring as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPFinishing)) {
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
                        ->whereNotIn('man_power.nama', $namaMPFinishing)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_instalHosing = [];
                    foreach ($namaMP_currentSkill_instalHousing as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPFinishing)) {
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
                        ->whereNotIn('man_power.nama', $namaMPFinishing)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_bongkarHosing = [];
                    foreach ($namaMP_currentSkill_bongkarHousing as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPFinishing)) {
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
                        ->whereNotIn('man_power.nama', $namaMPFinishing)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_pembuatanCU = [];
                    foreach ($namaMP_currentSkill_pembuatanCU as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPFinishing)) {
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
                        ->whereNotIn('man_power.nama', $namaMPFinishing)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB_accesoris = [];
                    foreach ($namaMP_currentSkill_accesoris as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPFinishing)) {
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
                        $namaMPFinishing[] = $namaMP_withDOB_wiring[0]['nama_mp'];
                    }
                    if (!empty($namaMP_withDOB_instalHosing)) {
                        usort($namaMP_withDOB_instalHosing, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMPFinishing[] = $namaMP_withDOB_instalHosing[0]['nama_mp'];
                    }
                    if (!empty($namaMP_withDOB_bongkarHosing)) {
                        usort($namaMP_withDOB_bongkarHosing, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMPFinishing[] = $namaMP_withDOB_bongkarHosing[0]['nama_mp'];
                    }
                    if (!empty($namaMP_withDOB_pembuatanCU)) {
                        usort($namaMP_withDOB_pembuatanCU, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMPFinishing[] = $namaMP_withDOB_pembuatanCU[0]['nama_mp'];
                    }
                    if (!empty($namaMP_withDOB_accesoris)) {
                        usort($namaMP_withDOB_accesoris, function ($a, $b) {
                            return strtotime($b['tanggal_lahir']) - strtotime($a['tanggal_lahir']);
                        });
                        $namaMPFinishing[] = $namaMP_withDOB_accesoris[0]['nama_mp'];
                    }
                    $namaMPFinishing = array_unique($namaMPFinishing);

                    if (count($namaMPFinishing) >= $ketersediaanMPCCAFinishing) {
                        break;
                    }
                }
                $namaMPFinishing = array_slice($namaMPFinishing, 0, ceil($ketersediaanMPCCAFinishing));
                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'Core Coil Assembly')
                            ->where('proses', 'WIRING')
                            ->whereIn('tipe_proses', $wiring)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_wiring = array_merge($nama_ms_wiring, $getMesin);
                        if (count($nama_ms_wiring) >= $ketersediaanMPCCAFinishing) {
                            break;
                        }
                    }
                }
                $nama_ms_wiring = array_slice($nama_ms_wiring, 0, ceil($ketersediaanMPCCAFinishing));

                foreach ($woIds as $time => $wo) {
                    $start = Carbon::parse($dateStrings[$time])->startOfDay();
                    $hourFinishing = $gpadryfilterCCAFinishing->pluck('mps2.standardize_work.dry_cast_resin.totalHour_Finishing', $wo)->sum();
                    $qty = $gpadryfilterCCAFinishing->pluck('qty_trafo', $wo)->sum();
                    $remainingHours = $hourFinishing * $qty;
                    if (isset($namaMPFinishing[$time]) && !empty($namaMPFinishing[$time])) {
                        $nama = $namaMPFinishing[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_wiring[$time]) && !empty($nama_ms_wiring[$time])) {
                        $mesin = $nama_ms_wiring[$time];
                    } else {
                        $mesin = "tidak ada mesin";
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
                            'mesin' => $mesin
                        ])->exists();

                        if (!$existingData) {
                            $currentDate[] = [
                                'end' => $endTime->format('Y-m-d'),
                                'hours' => $minhourday,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'Finishing',
                                'nama_proses' => 'Finishing CCA',
                                'mesin' => $mesin
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

                $workcenterLabel = 'Finishing';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'Finishing')
                    ->whereBetween('end', $getDay)
                    ->get();
                break;
            case 7:
                $woDryQc = $gpadryfilterQc->pluck('id_wo');
                $jumlahtotalHourQc = $gpadryfilterQc->whereBetween('start_wc14', $getDay)
                    ->with(['mps2.standardize_work', 'mps2.standardize_work.dry_cast_resin', 'mps2.standardize_work.dry_non_resin'])
                    ->whereIn('id_wo', $woDryQc)
                    ->get()
                    ->sum(function ($item) {
                        $workData = $item->mps2->standardize_work->dry_cast_resin ?? $item->mps2->standardize_work->dry_non_resin;

                        if ($workData) {
                            $totalHour_QCTest = $workData->totalHour_QCTest ?? 0;
                            return $totalHour_QCTest * $item->qty_trafo;
                        } else {
                            return 0;
                        }
                    });
                $KebutuhanQc = $jumlahtotalHourQc / (40  * 0.93);
                $selisihMPQc = $KebutuhanQc - $totalManPower;

                if ($KebutuhanQc != 0) {
                    $presentaseKurangMPQc = ($selisihMPQc / $KebutuhanQc) * 100;
                } else {
                    $presentaseKurangMPQc = 0;
                }
                $ketersediaanMPQc = $KebutuhanQc - ($KebutuhanQc * $presentaseKurangMPQc) / 100;
                if ($KebutuhanQc <= $ketersediaanMPQc) {
                    $selisihMPQc = 0;
                    $ketersediaanMPQc = $KebutuhanQc;
                }

                // proses pengambilan data nama MP pada workcenter Qc making HV melalui gpa
                $gpadryfilterQc = $gpadryfilterQc->whereBetween('start_wc14', $getDay)
                    ->get();


                $dateStrings = $gpadryfilterQc->pluck('start_wc14');
                $woIds = $gpadryfilterQc->pluck('mps2.id_wo');
                $qc = $gpadryfilterQc->pluck('mps2.standardize_work.dry_cast_resin.qc_testing');
                $namaMPQc = [];
                $nama_ms_qc = [];


                // Mendapatkan namaMP
                for ($i = 4; $i >= 0; $i--) {
                    $namaMP_currentSkill = $matrixSkil->where('production_line', 'Dry Resin')
                        ->where('nama_workcenter', 'Core Coil Assembly')
                        ->where('proses', 'QC TESTING')
                        ->whereIn('tipe_proses', $qc)
                        ->where('skill', $i)
                        ->whereNotIn('man_power.nama', $namaMPQc)
                        ->pluck('man_power.nama')->toArray();
                    $namaMP_withDOB = [];
                    foreach ($namaMP_currentSkill as $nama_mp) {
                        if (!in_array($nama_mp, $namaMPQc)) {
                            $existingMP = ResultRekomendasi::where('nama_mp', $nama_mp)
                                ->whereNotIn('nama_workcenter',  ['QC'])
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
                        $namaMPQc[] = $namaMP_withDOB[0]['nama_mp'];
                    }
                    if (count($namaMPQc) >= $ketersediaanMPQc) {
                        break;
                    }
                }
                $namaMPQc = array_slice($namaMPQc, 0, ceil($ketersediaanMPQc));

                for ($i = 2; $i >= 0; $i--) {
                    if ($i > 0) {
                        $getMesin = $mesins->where('production_line', 'Dry Resin')
                            ->where('nama_workcenter', 'QC')
                            ->where('proses', 'QC')
                            ->whereIn('tipe_proses', $qc)
                            ->where('skill', $i)
                            ->pluck('nama_ms')->toArray();
                        $nama_ms_qc = array_merge($nama_ms_qc, $getMesin);
                        if (count($nama_ms_qc) >= $ketersediaanMPQc) {
                            break;
                        }
                    }
                }
                $nama_ms_qc = array_slice($nama_ms_qc, 0, ceil($ketersediaanMPQc));
                //   dd($nama_ms_qc);
                foreach ($woIds as $time => $wo) {
                    $start = Carbon::parse($dateStrings[$time])->startOfDay();
                    $hourQc = $gpadryfilterQc->pluck('mps2.standardize_work.dry_cast_resin.totalHour_QCTest', $wo)->sum();
                    $qty = $gpadryfilterQc->pluck('qty_trafo', $wo)->sum();
                    $remainingHours = $hourQc * $qty;
                    if (isset($namaMPQc[$time]) && !empty($namaMPQc[$time])) {
                        $nama = $namaMPQc[$time];
                    } else {
                        $nama = "tidak ada nama MP";
                    }
                    if (isset($nama_ms_qc[$time]) && !empty($nama_ms_qc[$time])) {
                        $mesin = $nama_ms_qc[$time];
                    } else {
                        $mesin = "tidak ada Mesin";
                    }
                    // dd($mesin);

                    $currentDateQc = [];

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
                            'nama_workcenter' => 'QC',
                            'nama_proses' => 'QC',
                            'mesin' => $mesin,
                        ])->exists();

                        if (!$existingData) {
                            $currentDateQc[] = [
                                'end' => $endTime->format('Y-m-d'),
                                'hours' => $minhourday,
                                'wo_id' => $wo,
                                'nama_mp' => $nama,
                                'nama_workcenter' => 'QC',
                                'nama_proses' => 'QC',
                                'mesin' => $mesin,
                            ];
                        }
                        $start = $endTime->copy()->addSeconds(1);
                        $remainingHours -= $minhourday;
                        $start->addDay();
                    }
                    if (!empty($currentDateQc)) {
                        ResultRekomendasi::insert($currentDateQc);
                    }
                    // $currentDate = [];
                }

                $workcenterLabel = 'QC';
                $hasil = ResultRekomendasi::where('nama_workcenter', 'QC')
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
            'resultRekomendasi' => $resultRekomendasi,
        ];
        return view('produksi.resource_work_planning.DRY.rekomendasi', ['data' => $data]);
    }
    public function resetDatabase()
    {
        ResultRekomendasi::truncate();
        return redirect()->route('dashboard')->with('success', 'Deleted!');
    }
}
