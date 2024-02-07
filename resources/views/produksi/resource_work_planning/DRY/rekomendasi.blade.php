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
                                    <option value="1">Coil Making HV</option>
                                    <option value="2">Coil Making LV</option>
                                    <option value="3">Mould & Casting</option>
                                    <option value="4">Core & Assembly</option>
                                </select>
                            </div>
                            <div class="col-md-auto">
                                <label for="prosesSelect">Pilih Proses:</label>
                                <select class="custom-select" name="proses"
                                    id="prosesSelect">
                                    <i class="ri-arrow-down-s-line ml-2 mr-0"></i>
                                    <option value="1">Coil Making HV</option>
                                    <option value="2">Coil Making LV</option>
                                    <option value="3">Mould & Casting</option>
                                    <option value="4">Core & Assembly</option>
                                </select>
                            </div>
                            <div class="col-md-auto">
                                <label for="tipeprosesSelect">Pilih Tipe Proses:</label>
                                <select class="custom-select" name="tipeproses"
                                    id="tipeprosesSelect">
                                    <i class="ri-arrow-down-s-line ml-2 mr-0"></i>
                                    <option value="1">Coil Making HV</option>
                                    <option value="2">Coil Making LV</option>
                                    <option value="3">Mould & Casting</option>
                                    <option value="4">Core & Assembly</option>
                                </select>
                            </div>
                            <div class="col-md-auto ">
                                <label for="dateSelect">Pilih range tanggal :</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="dateSelect" name="date">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="table-responsive">
                    <div id="datatable_wrapper" class="dataTables_wrapper">
                        <table id="datatable" class="table data-table table-striped dataTable" role="grid"
                            aria-describedby="datatable_info">
                            <thead class="text-center ">
                                <tr>
                                    {{-- <th rowspan="2" style="width: 150px; vertical-align: middle;">Tanggal</th> --}}
                                    <th colspan="3">{{ $data['workcenterLabel'] }}</th>
                                    {{-- <th colspan="3">Coil HV</th> --}}
                                </tr>
                                <tr>
                                    <th>WO</th>
                                    <th>Mesin</th>
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

                                <tr>
                                    <th>W1234567FA</th>
                                    <th>Honghua</th>
                                    <th>Widia</th>


                                </tr>
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
            // Mendeteksi perubahan pada dropdown
            $('#workcenterSelect_rekomendasi').change(function() {
                // Mengambil nilai yang dipilih
                var selectedValue = $(this).val();

                // Menyimpan nilai yang dipilih dalam localStorage
                localStorage.setItem('selectedWorkcenter_rekomendasi', selectedValue);

                // Mengirimkan formulir secara otomatis
                $('#workcenterForm_rekomendasi').submit();
            });

            // Memeriksa apakah ada nilai yang disimpan dalam localStorage
            var storedValue = localStorage.getItem('selectedWorkcenter_rekomendasi');
            if (storedValue) {
                // Menetapkan nilai yang disimpan sebagai nilai awal dropdown
                $('#workcenterSelect_rekomendasi').val(storedValue);
            }
        });
    </script>
@endsection
