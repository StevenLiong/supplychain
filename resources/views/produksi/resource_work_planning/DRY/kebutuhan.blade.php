@extends('produksi.resource_work_planning.template.bar')
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Kebutuhan Man Power dan Mesin</h4>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-4 align-items-center">

                    <form action="{{ route('process.workcenter') }}" method="post" class="ml-2" id="workcenterForm">
                        @csrf
                        <select class="custom-select" name="selectedWorkcenter" id="workcenterSelect"><i
                                class="ri-arrow-down-s-line ml-2 mr-0"></i>
                            <option value="1">Coil Making HV</option>
                            <option value="2">Coil Making LV</option>
                            <option value="3">Mould & Casting</option>
                            <option value="4">Core & Assembly</option>
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
                                    <th>Kebutuhan Man Power</th>
                                    <th>Kebutuhan Mesin</th>
                                </tr>
                                <tr>
                                    <th>{{ $data['workcenterLabel'] }}</th>
                                    <th>{{ $data['workcenterLabel'] }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                                <tr>
                                    @foreach ($data['kapasitas'] as $kap)
                                        @php
                                            $qtyTrafo = $data['mps']
                                                ->where('kva', $kap->ukuran_kapasitas)
                                                ->sum('qty_trafo');
                                        @endphp
                                        @if ($kap->ukuran_kapasitas && $qtyTrafo != 0)
                                            <th class="text-center">
                                                {{ $kap->ukuran_kapasitas }}
                                            </th>
                                        @endif
                                    @endforeach

                                    <th>

                                        {{ $data['kebutuhanMP'] }}
                                    </th>
                                    <th>/ini buat Mesin</th>
                                </tr>



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
