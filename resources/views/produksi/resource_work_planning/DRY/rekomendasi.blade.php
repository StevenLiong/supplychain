@extends('produksi.resource_work_planning.template.bar')
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center">
                <div class="header-title">
                    <h4 class="card-title">Rekomendasi Man Power dan Mesin</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4 align-items-center px-4">
                    <form action="{{ route('process.workcenter_rekomendasi') }}" method="post" class="ml-2"
                        id="workcenterForm_rekomendasi">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-md-auto">
                                <label for="workcenterSelect_rekomendasi">Pilih Work Center:</label>
                                <select class="custom-select" name="Workcenter_rekomendasi"
                                    id="workcenterSelect_rekomendasi">
                                    <i class="ri-arrow-down-s-line ml-2 mr-0"></i>
                                    <option value="1">Coil Making LV</option>
                                    <option value="2">Coil Making HV</option>
                                    <option value="3">Mould & Casting</option>
                                    <option value="4">Core & Assembly</option>
                                </select>
                            </div>
                            <div class="col-md-auto">
                                <label for="prosesSelect">Pilih Priode:</label>
                                <select class="custom-select" name="periodeDry" id="periodeDrySelect">
                                    <option value="1">Hari ini</option>
                                    <option value="2">Besok</option>
                                    <option value="3">Minggu sekarang</option>
                                    <option value="4">Minggu Depan</option>
                                </select>
                            </div>
                            <div class="col-md-auto">
                                <label for="shiftSelect">Shift:</label>
                                <select class="custom-select" name="shiftDry" id="shiftDrySelect">
                                    <option value="1">1 Shift</option>
                                    <option value="2">2 Shift</option>
                                    <option value="3">3 Shift</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="table-responsive">
                    <div id="datatable_wrapper" class="dataTables_wrapper">
                        <table id="datatable" class="table data-table table-striped dataTable" role="grid"
                            aria-describedby="datatable_info" data-ordering="false">
                            <thead class="text-center ">
                                <tr>
                                    <th rowspan="2" style="width: 200px; vertical-align: middle;">Tanggal / Waktu</th>
                                    <th colspan="3">{{ $data['workcenterLabel'] }}</th>
                                    {{-- <th colspan="3">Coil HV</th> --}}
                                </tr>
                                <tr>
                                    <th>WO</th>
                                    {{-- <th>Mesin</th> --}}
                                    <th>Operator</th>
                                    {{-- <th>WO</th>
                                    <th>Mesin</th>
                                    <th>Operator</th> --}}
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                {{-- @foreach ($data['manpowerNames'] as $manpowerName) --}}
                                {{-- <tr> --}}
                                {{-- Kolom yang ingin di-merge dengan baris sebelumnya --}}
                                {{-- <th>04/04/2002</th> --}}
                                {{-- {{-- <th>W1234567FA</th> --}}
                                {{-- {{-- <th>Honghua</th> --}}

                                {{-- Kolom dengan nama ManPower --}}
                                {{-- <th>{{ $manpowerName }}</th> --}}

                                {{-- Kolom tetap --}}
                                {{-- {{-- <th>W1234567FA</th> --}}
                                {{-- {{-- <th>Broomfield</th> --}}
                                {{-- <th>{{ $manpowerName }}</th> --}}
                                {{-- </tr> --}}
                                {{-- @endforeach --}}
                                <!-- $woDry -->
                                {{-- @foreach ($data['woDry'] as $woDry)
                                {{-- <tr>
                                    <th>{{ $woDry->deadline }}</th>
                                    <th>{{ $woDry->wo->id_wo }}</th>
                                    <th>{{ $hour }}</th>
                                    <th>{{ $data['namaMP'][0] }}</th>
                                </tr> --}}

                                @foreach ($data['woDry'] as $index => $woDry)
                                    @php
                                        $hour = $data['hour'][$index];
                                        $startTime = \Carbon\Carbon::parse($woDry->deadline)
                                            ->startOfDay()
                                            ->setHour(8)
                                            ->setMinute(0);
                                        $endOfWorkingHours = \Carbon\Carbon::parse($woDry->deadline)
                                            ->startOfDay()
                                            ->setHour(17)
                                            ->setMinute(0);
                                        $breakStart = \Carbon\Carbon::parse($woDry->deadline)
                                            ->startOfDay()
                                            ->setHour(12)
                                            ->setMinute(0);
                                        $breakEnd = \Carbon\Carbon::parse($woDry->deadline)
                                            ->startOfDay()
                                            ->setHour(13)
                                            ->setMinute(0);
                                        $breakDuration = 1;
                                        $endTime = $startTime->copy()->addHours($hour);
                                        if ($endTime->greaterThan($endOfWorkingHours)) {
                                            $endTime = $endOfWorkingHours;
                                        }
                                        $timeRange = $startTime->format('d-m-Y H:i') . ' - ' . $endTime->format(' H:i');
                                        $addNewRow = false;
                                        if ($hour > 8) {
                                            $addNewRow = true;
                                            $extraHours = $hour - 8;
                                            $endTime = $startTime->copy()->addHours(8);
                                        }
                                    @endphp
                                    <tr>
                                        <th>{{ $timeRange }} </th>
                                        <th>{{ $woDry->wo->id_wo }}</th>
                                        @isset($data['namaMP'][$index])
                                            <th>{{ $data['namaMP'][$index] }}</th>
                                        @endisset
                                    </tr>
                                    @if ($addNewRow)
                                        @php
                                            $extraHoursWithBreak = $extraHours + 1;
                                            $additionalRows = ceil($extraHoursWithBreak / 8);
                                            $nextDayStartTime = $startTime->copy();
                                            $nextDayStartTime->addDay();
                                            if ($nextDayStartTime->isWeekend()) {
                                                $nextDayStartTime->nextWeekday();
                                            }
                                            $nextDayStartTime->setHour(8)->setMinute(0)->setSecond(0);
                                            $nextEndTime = $nextDayStartTime->copy()->addHours(min($extraHoursWithBreak, 8));
                                            if ($extraHoursWithBreak > 8) {
                                                $nextEndTime->addHour();
                                            }
                                        @endphp
                                        @for ($i = 0; $i < $additionalRows; $i++)
                                            <tr>
                                                <th>{{ $nextDayStartTime->format('d-m-Y H:i') }} -
                                                    {{ $nextEndTime->format('H:i') }}</th>
                                                <th>{{ $woDry->wo->id_wo }}</th>
                                            </tr>
                                            @php
                                                $nextDayStartTime = $nextDayStartTime->copy()->addDay();
                                                if ($nextDayStartTime->isWeekend()) {
                                                    $nextDayStartTime->nextWeekday();
                                                }
                                                $nextEndTime = $nextDayStartTime->copy()->addHours(min($extraHoursWithBreak - ($i + 1) * 8, 9));
                                            @endphp
                                        @endfor
                                    @endif
                                @endforeach
                                {{-- @foreach ($data['woDry'] as $woDry)
                                    @php
                                        $hour = $woDry->wo->standardize_work->dry_cast_resin->hour_coil_lv;

                                    @endphp
                                    {{-- @foreach ($data['namaMP'] as $namaMP)
                                        <tr>
                                            <th>{{ $woDry->deadline->format('d-m-Y H:i H:i') }}</th>
                                            <th>{{ $woDry->wo->id_wo }}</th>
                                          <th>{{ $namaMP }}</th>
                                        </tr>
                                        @if ($addNewRow)
                                            <tr>
                                                <th>{{ $woDry->deadline->format('d-m-Y H:i') }}</th>
                                                <th>{{ $woDry->wo->id_wo }}</th>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach --}}
                                {{-- @foreach ($data['woDry'] as $woDry)
                                    @php
                                        $hour = $woDry->wo->standardize_work->dry_cast_resin->hour_coil_lv;
                                        $startTime = \Carbon\Carbon::parse('08:00');
                                        $endOfWorkingHours = \Carbon\Carbon::parse('17:00');
                                        $endTime = $startTime->copy()->addHours($hour);

                                        // Jika waktu selesai lebih dari jam kerja, atur waktu selesai menjadi jam 17:00
                                        if ($endTime->greaterThan($endOfWorkingHours)) {
                                            $endTime = $endOfWorkingHours;
                                        }

                                        // Format waktu mulai dan waktu selesai dalam satu string
                                        $timeRange = $startTime->format('d-m-Y H:i') . ' - ' . $endTime->format(' H:i');

                                        // Jika waktu lebih dari 8 jam, tambahkan tabel tambahan
                                        $addNewRow = false;
                                        if ($hour > 8) {
                                            $addNewRow = true;
                                            $extraHours = $hour - 8;
                                            $endTime = $startTime->copy()->addHours(8);
                                        }
                                    @endphp

                                    <tr>
                                        <th>{{ $timeRange }}</th>
                                        <th>{{ $woDry->wo->id_wo }}</th>
                                    </tr>

                                    @if ($addNewRow)
                                        @php
                                            // Hitung waktu mulai untuk baris tambahan
                                            $nextDayStartTime = $startTime->copy()->addDay()->setHour(8)->setMinute(0)->setSecond(0);
                                            $nextDayEndTime = $nextDayStartTime->copy()->addHours($extraHours);
                                            // Format waktu mulai dan waktu selesai untuk baris tambahan
                                            $nextDayTimeRange = $nextDayStartTime->format('d-m-Y H:i') . ' - ' . $nextDayEndTime->format(' H:i');
                                        @endphp
                                        <tr>
                                            <th>{{ $nextDayTimeRange }}</th>
                                            <th>{{ $woDry->wo->id_wo }}</th>
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach ($data['woDry'] as $woDry)
                                    @php
                                        $hour = $woDry->wo->standardize_work->dry_cast_resin->hour_coil_lv;
                                        $startTime = \Carbon\Carbon::parse('08:00');
                                        $endOfWorkingHours = \Carbon\Carbon::parse('17:00');
                                        $endTime = $startTime->copy()->addHours($hour);

                                        // Jika waktu selesai lebih dari jam kerja, atur waktu selesai menjadi jam 17:00
                                        if ($endTime->greaterThan($endOfWorkingHours)) {
                                            $endTime = $endOfWorkingHours;
                                        }

                                        // Format waktu mulai dan waktu selesai dalam satu string
                                        $timeRange = $startTime->format('d-m-Y H:i') . ' - ' . $endTime->format(' H:i');

                                        // Hitung jumlah jam tambahan jika melebihi 8 jam
                                        $extraHours = 0;
                                        $addNewRow = false;
                                        if ($hour > 8) {
                                            $addNewRow = true;
                                            $extraHours = $hour - 8;
                                            $endTime = $endOfWorkingHours; // Waktu selesai diset ke akhir jam kerja
                                        }
                                    @endphp

                                    <tr>
                                        <td>{{ $timeRange }}</td>
                                        <td>{{ $woDry->wo->id_wo }}</td>
                                    </tr>


                                @endforeach --}}







                                {{-- <tr>
                                    <th>W1234567FA</th>
                                    <th>Honghua</th>
                                    <th>Widia</th>
                                    <th>W1234567FA
                                    </th>
                                    <th>Broomfield</th>
                                    <th>Nia</th>
                                </tr> --}}
                                {{-- <tr>
                                    <th rowspan="3">04/04/2002</th>
                                    <th>W1234567FA</th>
                                    <th>Honghua</th>
                                    <th>Widia</th>
                                    <th>W1234567FA</th>
                                    <th>Broomfield</th>
                                    <th>Nia</th>
                                </tr>
                                <tr>
                                    <th>W1234567FA</th>
                                    <th>Honghua</th>
                                    <th>Widia</th>
                                    <th>W1234567FA
                                    </th>
                                    <th>Broomfield</th>
                                    <th>Nia</th>
                                </tr>
                                <tr>
                                    <th>W1234567FA</th>
                                    <th>Honghua</th>
                                    <th>Widia</th>
                                    <th>W1234567FA
                                    </th>
                                    <th>Broomfield</th>
                                    <th>Nia</th>
                                </tr>
                                <tr>
                                    <th rowspan="3">04/04/2002</th>
                                    <th>W1234567FA</th>
                                    <th>Honghua</th>
                                    <th>Widia</th>
                                    <th>W1234567FA
                                    </th>
                                    <th>Broomfield</th>
                                    <th>Nia</th>
                                </tr>
                                <tr>
                                    <th>W1234567FA</th>
                                    <th>Honghua</th>
                                    <th>Widia</th>
                                    <th>W1234567FA
                                    </th>
                                    <th>Broomfield</th>
                                    <th>Nia</th>
                                </tr>
                                <tr>
                                    <th>W1234567FA</th>
                                    <th>Honghua</th>
                                    <th>Widia</th>
                                    <th>W1234567FA
                                    </th>
                                    <th>Broomfield</th>
                                    <th>Nia</th>
                                </tr> --}}

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#workcenterSelect_rekomendasi, #periodeDrySelect, #shiftDrySelect').change(function() {
                var selectedWorkcenterValue = $('#workcenterSelect_rekomendasi').val();
                var selectedPeriodeValue = $('#periodeDrySelect').val();
                var selectedShiftValue = $('#shiftDrySelect').val();
                localStorage.setItem('selectedWorkcenter_rekomendasi', selectedWorkcenterValue);
                localStorage.setItem('selectedPeriodeDry', selectedPeriodeValue);
                localStorage.setItem('selectedShiftDry', selectedShiftValue);
                $('#workcenterForm_rekomendasi').submit();
            });
            var storedWorkcenterValue = localStorage.getItem('selectedWorkcenter_rekomendasi');
            var storedPeriodeValue = localStorage.getItem('selectedPeriodeDry');
            var selectedShiftValue = localStorage.getItem('selectedShiftDry');
            if (storedWorkcenterValue && storedPeriodeValue && selectedShiftValue) {
                $('#workcenterSelect_rekomendasi').val(storedWorkcenterValue);
                $('#periodeDrySelect').val(storedPeriodeValue);
                $('#shiftDrySelect').val(selectedShiftValue);
            }
        });
    </script>
@endsection
