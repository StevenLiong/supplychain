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
                                    <option value="4">Susun Core</option>
                                    <option value="5">Connection & Final Assembly</option>
                                    <option value="6">Finishing</option>
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
                                    <th rowspan="2" style="width: 150px; vertical-align: middle;">Tanggal</th>
                                    <th rowspan="2" style="width: 100px; vertical-align: middle;">Jam</th>
                                    <th colspan="3">{{ $data['workcenterLabel'] }}</th>
                                    {{-- <th colspan="3">Coil HV</th> --}}
                                </tr>
                                <tr>
                                    {{-- <th>Jam</th> --}}
                                    <th>WO</th>
                                    {{-- <th>Mesin</th> --}}
                                    <th>Operator</th>
                                    {{-- @foreach ($data['newDates'] as $date)
                                    <th>{{ $date['end'] }}</th>
                                    <th>{{ $date['hours'] }}</th>
                                    <th>{{ $date['wo_id'] }}</th>
                                @endforeach --}}

                                    {{-- <th>WO</th>
                                    <th>Mesin</th>
                                    <th>Operator</th> --}}
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($data['hasil'] as $hasil)
                                    <tr>
                                        <th>{{ \Carbon\Carbon::parse($hasil->end)->format('d-m-Y') }}</th>
                                        <th>{{ $hasil->hours }}</th>
                                        <th>{{ $hasil->wo_id }}</th>
                                        <th>{{$hasil->nama_mp}}</th>
                                    </tr>
                                @endforeach

                                {{-- @foreach ($data['woDry'] as $index => $woDry)
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
                                        $endTime = $startTime->copy()->addHours($hour);
                                        if ($endTime->greaterThan($endOfWorkingHours)) {
                                            $endTime = $endOfWorkingHours;
                                        }

                                        $timeRange = $startTime->format('d-m-Y H:i') . ' - ' . $endTime->format('H:i');
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
                                @endforeach --}}
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
