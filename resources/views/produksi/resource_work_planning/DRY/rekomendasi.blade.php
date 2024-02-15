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
                        </div>

                    </form>
                </div>
                <div class="table-responsive">
                    <div id="datatable_wrapper" class="dataTables_wrapper">
                        <table id="datatable" class="table data-table table-striped dataTable" role="grid"
                            aria-describedby="datatable_info" data-ordering="false">
                            <thead class="text-center ">
                                <tr>
                                    {{-- <th rowspan="2" style="width: 150px; vertical-align: middle;">Tanggal</th> --}}
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
                                @foreach ($data['woDry'] as $woDry)
                                    @foreach ($data['namaMP'] as $namaMP)
                                        <tr>
                                            <th>{{ $woDry }}</th>
                                            <th>{{ $namaMP }}</th>
                                        </tr>
                                    @endforeach
                                @endforeach


                                {{-- <tr> --}}
                                {{-- @foreach ($data['proses'] as $gpaDry)
                                        <th>{{ $gpaDry->wo->standardize_work->dry_cast_resin->nomor_so }}</th>
                                    @endforeach --}}
                                {{-- <th> {{ $data['woDry'] }}</th>
                                    <th> {{ $data['namaMP'] }}</th>



                                </tr> --}}
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
            // Fungsi untuk menangani perubahan pada kedua inputan
            $('#workcenterSelect_rekomendasi, #periodeDrySelect').change(function() {
                // Menyimpan nilai kedua inputan ke dalam local storage
                var selectedWorkcenterValue = $('#workcenterSelect_rekomendasi').val();
                var selectedPeriodeValue = $('#periodeDrySelect').val();
                localStorage.setItem('selectedWorkcenter_rekomendasi', selectedWorkcenterValue);
                localStorage.setItem('selectedPeriodeDry', selectedPeriodeValue);
                // Mengirimkan form
                $('#workcenterForm_rekomendasi').submit();
            });

            // Memeriksa apakah nilai sudah disimpan sebelumnya dan mengembalikannya
            var storedWorkcenterValue = localStorage.getItem('selectedWorkcenter_rekomendasi');
            var storedPeriodeValue = localStorage.getItem('selectedPeriodeDry');
            if (storedWorkcenterValue && storedPeriodeValue) {
                $('#workcenterSelect_rekomendasi').val(storedWorkcenterValue);
                $('#periodeDrySelect').val(storedPeriodeValue);
            }
        });
    </script>
@endsection
