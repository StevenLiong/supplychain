@extends('produksi.resource_work_planning.template.bar')
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Jumlah Man Power dan Mesin</h4>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-4 align-items-center">
                    {{-- <div class="dropdown status-dropdown ml-2 dropdown-toggl" id="dropdownMenuButton03" data-toggle="dropdown"
                        aria-expanded="false">
                        <div class="btn btn-primary">Hour / Day<i class="ri-arrow-down-s-line ml-2 mr-0"></i></div>
                        <div class="dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuButton03">
                            <a class="dropdown-item" href="#"> 7 Jam</a>
                            <a class="dropdown-item" href="#"> 8 Jam</a>
                            <a class="dropdown-item" href="#"> 10 Jam</a>
                        </div>
                    </div>
                    <div class="dropdown status-dropdown ml-2 dropdown-toggl" id="dropdownMenuButton03"
                        data-toggle="dropdown" aria-expanded="false">
                        <div class="btn btn-primary">Shift<i class="ri-arrow-down-s-line ml-2 mr-0"></i></div>
                        <div class="dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuButton03">
                            <a class="dropdown-item" href="#"> 1 </a>
                            <a class="dropdown-item" href="#"> 2 </a>
                            <a class="dropdown-item" href="#"> 3 </a>
                        </div>
                    </div> --}}
                    <form action="{{ route('process.workcenter') }}" method="post" class="ml-2" id="workcenterForm">
                        @csrf
                        <select class="custom-select" name="selectedWorkcenter" id="workcenterSelect"><i
                                class="ri-arrow-down-s-line ml-2 mr-0"></i>
                            <option value="1">Coil Making</option>
                            <option value="2">Mould & Casting</option>
                            <option value="3">Core & Assembly</option>
                        </select>

                    </form>
                    <div class="ml-auto mr-3" style="align-items: d-flex right;">
                        <a href="#" class="btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i
                                class="mr-2 fa-solid fa-print"></i>Print</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <div id="datatable_wrapper" class="dataTables_wrapper">
                        <table id="datatable" class="table data-table table-striped dataTable" role="grid"
                            aria-describedby="datatable_info">
                            <thead class="text-center">
                                <tr>
                                    <th rowspan="2" style="width: 150px; vertical-align: middle;">Kapasitas</th>
                                    <th>Jumlah Man Power</th>
                                    <th>Jumlah Mesin</th>
                                </tr>
                                <tr>
                                    <th>{{ $data['selectedWorkcenterData']->nama_proses }}</th>
                                    <th>{{ $data['selectedWorkcenterData']->nama_proses }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($data['kapasitas'] as $kap)
                                    <tr>
                                        <th>
                                            @if ($kap->ukuran_kapasitas)
                                                {{ $kap->ukuran_kapasitas }}
                                            @endif
                                        </th>
                                        <th>
                                            @foreach ($data['kapasitas'] as $kap)
                                                @php
                                                    $kebutuhanMPDRY = $data['mps']
                                                        ->where($data['selectedWorkcenterData']->nama_proses , $data['selectedWorkcenterData']->nama_proses )
                                                        ->where('kva', $kap->ukuran_kapasitas)
                                                        ->whereBetween('deadline', $data['deadlineDate'])
                                                        ->sum('qty_trafo');
                                                @endphp
                                            @endforeach
                                            {{ $kebutuhanMPDRY }}
                                        </th>
                                        <th>/ini buat Mesin</th>
                                    </tr>
                                @endforeach


                            </tbody>
                            <tfoot class="text-center">
                                <tr>
                                    <th>Total</th>
                                    <th>20</th>
                                    <th>15</th>

                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <th>-3</th>
                                    <th>1</th>

                                </tr>
                            </tfoot>
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
            $('#workcenterSelect').change(function() {
                // Mengambil nilai yang dipilih
                var selectedValue = $(this).val();

                // Menyimpan nilai yang dipilih dalam localStorage
                localStorage.setItem('selectedWorkcenter', selectedValue);

                // Mengirimkan formulir secara otomatis
                $('#workcenterForm').submit();
            });

            // Memeriksa apakah ada nilai yang disimpan dalam localStorage
            var storedValue = localStorage.getItem('selectedWorkcenter');
            if (storedValue) {
                // Menetapkan nilai yang disimpan sebagai nilai awal dropdown
                $('#workcenterSelect').val(storedValue);
            }
        });
    </script>
@endsection
