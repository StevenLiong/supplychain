@extends('produksi.resource_work_planning.template.bar')
@section('content')
    <div class="col-lg-12">
        <div class="row mb-4 align-items-center">
            <div class="dropdown status-dropdown ml-2 dropdown-toggl" id="dropdownMenuButton03" data-toggle="dropdown"
                aria-expanded="false">
                {{-- <div class="btn btn-primary">Periode<i class="ri-arrow-down-s-line ml-2 mr-0"></i></div>
                <div class="dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuButton03">
                    <a class="dropdown-item" href="#"> 1 Minggu</a>
                    <a class="dropdown-item" href="#"> 2 Minggu</a>
                    <a class="dropdown-item" href="#"> 3 Minggu</a>
                </div> --}}
                <form action="{{ route('process.periode') }}" method="post" id="periodeForm">
                    @csrf
                    <label>Pilih Periode:</label>
                    <select name="periode" id="periodeSelect">
                        <option value="1">Satu Bulan</option>
                        <option value="2">3 minggu</option>
                        <option value="3">2 minggu</option>
                        <option value="4">1 minggu</option>
                    </select>
                </form>
            </div>
        </div>

        {{-- <div class="card bg-primary">
            <div class="row">
                <div class="col-lg-2">
                    <div class="card-body">
                        <div class="card text-center">
                            <div class="card-header m-0 p-0 px-1 py-1">
                                <h6 >Quantity</h6>
                            </div>
                            <div class="card-body  text-primary m-0 p-0 px-3 py-2">
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="card-body">
                        <div class="card text-center">
                            <div class="card-header m-0 p-0 px-1 py-1">
                                <h6 >Quantity</h6>
                            </div>
                            <div class="card-body  text-primary m-0 p-0 px-3 py-2">
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="card-body">
                        <div class="card text-center">
                            <div class="card-header m-0 p-0 px-1 py-1">
                                <h6 >Quantity</h6>
                            </div>
                            <div class="card-body  text-primary m-0 p-0 px-3 py-2">
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="card-body">
                        <div class="card text-center">
                            <div class="card-header m-0 p-0 px-1 py-1">
                                <h6 >Quantity</h6>
                            </div>
                            <div class="card-body  text-primary m-0 p-0 px-3 py-2">
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="card-body">
                        <div class="card text-center">
                            <div class="card-header m-0 p-0 px-1 py-1">
                                <h6 >Quantity</h6>
                            </div>
                            <div class="card-body  text-primary m-0 p-0 px-3 py-2">
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>Product Line 2</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                @php
                                    $QtyPL2 = $data['mps']->where('production_line', '=', 'PL2')->sum('qty_trafo');
                                @endphp
                                <h3>{{ $QtyPL2 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                @php
                                    $kapasitasPL2 = 52;
                                    $loadkapasitasPL2 = ($QtyPL2 / $kapasitasPL2) * 100;
                                @endphp
                                <h3>{{ number_format($loadkapasitasPL2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>{{ number_format($data['kebutuhanMP']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Selisih MP</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"><b>100%</b></div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>Product Line 3</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                {{-- @php
                                    // $qtyPL2 = $mps->where('kva', $kap->ukuran_kapasitas)->sum('qty_trafo');
                                    $QtyPL3 = $mps->where('production_line', '=', 'PL3')->sum('qty_trafo');
                                @endphp
                                <h3>{{ $QtyPL3 }}</h3> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                {{-- @php
                                    $kapasitasPL3 = 52;
                                    $loadkapasitasPL3 = ($QtyPL3 / $kapasitasPL3) * 100;
                                @endphp
                                <h3>{{ number_format($loadkapasitasPL3) }}</h3> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                {{-- <h3>{{ $jumlahtotalHourSumPL3}}</h3> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Selisih MP</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"><b>100%</b></div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>CT / VT</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                {{-- @php
                                    // $qtyPL2 = $mps->where('kva', $kap->ukuran_kapasitas)->sum('qty_trafo');
                                    $Qtyctvt = $mps->where('production_line', '=', 'CT-VT')->sum('qty_trafo');
                                @endphp
                                <h3>{{ $Qtyctvt }}</h3> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                {{-- @php
                                    $kapasitasctvt = 52;
                                    $loadkapasitasctvt = ($Qtyctvt / $kapasitasctvt) * 100;
                                @endphp
                                <h3>{{ number_format($loadkapasitasctvt) }}</h3> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Selisih MP</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"><b>100%</b></div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>DRY</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                @php
                                    $QtyDry = $data['mps']->where('production_line', '=', 'DRY')->sum('qty_trafo');
                                @endphp
                                <h3>{{ $QtyDry }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                @php
                                    $kapasitasDry = 52;
                                    $loadkapasitasDry = ($QtyDry / $kapasitasDry) * 100;
                                @endphp
                                <h3>{{ number_format($loadkapasitasDry) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Selisih MP</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"><b>100%</b></div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>REPAIR</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                {{-- @php
                                    // $qtyPL2 = $mps->where('kva', $kap->ukuran_kapasitas)->sum('qty_trafo');
                                    $QtyRepair = $mps->where('production_line', '=', 'Repair')->sum('qty_trafo');
                                @endphp
                                <h3>{{ $QtyRepair }}</h3> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                {{-- @php
                                    $kapasitasRepair = 52;
                                    $loadkapasitasRepair = ($QtyRepair / $kapasitasRepair) * 100;
                                @endphp
                                <h3>{{ number_format($loadkapasitasRepair) }}</h3> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Selisih MP</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"><b>100%</b></div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Mendeteksi perubahan pada dropdown
            $('#periodeSelect').change(function() {
                // Mengambil nilai yang dipilih
                var selectedValue = $(this).val();

                // Menyimpan nilai yang dipilih dalam localStorage
                localStorage.setItem('selectedPeriode', selectedValue);

                // Mengirimkan formulir secara otomatis
                $('#periodeForm').submit();
            });

            // Memeriksa apakah ada nilai yang disimpan dalam localStorage
            var storedValue = localStorage.getItem('selectedPeriode');
            if (storedValue) {
                // Menetapkan nilai yang disimpan sebagai nilai awal dropdown
                $('#periodeSelect').val(storedValue);
            }
        });
    </script>
@endsection
