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
                        <d iv class="row align-items-center">
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
                            {{-- <div class="col-md-auto">
                                <label for="shiftSelect">Shift:</label>
                                <select class="custom-select" name="shiftDry" id="shiftDrySelect">
                                    <option value="1">1 Shift</option>
                                    <option value="2">2 Shift</option>
                                    <option value="3">3 Shift</option>
                                </select>
                            </div> --}}
                        </d>

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
                                    <th>Proses</th>
                                    <th>mesin</th>
                                    {{-- <th></th> --}}
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
                                        <th>{{ $hasil->nama_mp }}</th>
                                        <th>{{ $hasil->nama_proses }}</th>
                                        <th>{{ $hasil->mesin }}</th>
                                        {{-- <th>
                                            <button class="btn btn-sm btn-primary edit-mp"
                                                data-id="{{ $hasil->id }}">Edit</button>
                                        </th> --}}
                                    </tr>
                                @endforeach
                                {{-- <div class="modal fade" id="editMpModal" tabindex="-1" role="dialog"
                                    aria-labelledby="editMpModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editMpModalLabel">Edit Nama MP</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" id="mpId">
                                                <div class="form-group">
                                                    <label for="newMpName">Nama MP Baru:</label>
                                                    <select class="form-control" id="newMpName">
                                                        <option value="mp1">Nama MP 1</option>
                                                        <option value="mp2">Nama MP 2</option>
                                                        <option value="mp3">Nama MP 3</option>
                                                        <!--Tambahkan opsi sesuai dengan data yang Anda miliki-->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="confirmUpdateMpBtn">Save
                                                    changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Konfirmasi -->
                                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                    aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin akan menyimpan perubahan?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    id="cancelConfirmationBtn" data-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-primary"
                                                    id="confirmConfirmationBtn">Confirm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- Modal -->
                                {{-- <div class="modal fade" id="editMpModal" tabindex="-1"
                                    aria-labelledby="editNamaMpModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editNamaMpModalLabel">Edit Nama MP</h5>
                                            </div>
                                            <form action="{{ route('nama_mp.update', $hasil->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="nama_mp">Nama MP</label>
                                                        <input type="text" id="nama_mp" name="nama_mp" value="{{$hasil->nama_mp}}"></input>
                                                        <select class="form-select" id="nama_mp" name="nama_mp">
                                                            {{-- @foreach ($dataUntukSelectBox as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ $nama_mp->nama_mp == $item->nama_mp ? 'selected' : '' }}>
                                                                    {{ $item->nama_mp }}</option>
                                                            @endforeach
                                                         </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal" id="close">Close</button>
                                                    <button type="submit" class="btn btn-primary" id="save">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> --}}


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
        {{-- <script>
            $(document).ready(function() {
                $('.edit-mp').click(function() {
                    var id = $(this).data('id');
                    var nama_mp = $(this).closest('tr').find('.nama-mp').text();
                    $('#mpId').val(id);
                    $('#newMpName').val(nama_mp);
                    $('#editMpModal').modal('show');
                });

                $('#updateMpBtn').click(function() {
                    var id = $('#mpId').val();
                    var newMpName = $('#newMpName').val();

                    $.ajax({
                        url: 'resource_work_planning/Dry/Rekomendasi/update-mp',
                        method: 'POST',
                        data: {
                            id: id,
                            new_mp_name: newMpName,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#editMpModal').modal('hide');
                            $('th[data-id="' + id + '"] .nama-mp').text(newMpName);
                        }
                    });
                });

                $('#confirmUpdateMpBtn').click(function() {
                    $('#confirmationModal').modal('show');
                    $('#editMpModal').modal('hide');
                });

                $('#cancelConfirmationBtn').click(function() {
                    $('#editMpModal').modal('show');
                    $('#confirmationModal').modal('hide');
                });

                $('#confirmConfirmationBtn').click(function() {
                    $('#updateMpBtn').trigger(
                    'click'); // Memanggil fungsi yang sudah ada untuk melakukan update
                    $('#confirmationModal').modal('hide');
                });
            });
        </script> --}}
    {{-- <script>
        $(document).ready(function() {
            $('.edit-mp').click(function() {
                    $('#editMpModal').modal('show');
                });
                $('#close').click(function() {
                    $('#editMpModal').modal('hide');
                });
        });
    </script> --}}
@endsection
